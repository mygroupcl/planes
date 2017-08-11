<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die;

use Joomla\String\StringHelper;

class OSMembershipModelCoupon extends MPFModelAdmin
{
	/**
	 * Store custom fields mapping with plans.
	 *
	 * @param JTable   $row
	 * @param MPFInput $input
	 * @param bool     $isNew
	 */
	protected function afterStore($row, $input, $isNew)
	{
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		$planIds = $input->get('plan_id', array(), 'array');

		if (empty($planIds) || $planIds[0] == 0)
		{
			$row->plan_id = 0;
		}
		else
		{
			$row->plan_id = 1;
		}

		$row->store(); // Store the plan_id field

		if (!$isNew)
		{
			$query->delete('#__osmembership_coupon_plans')
				->where('coupon_id = ' . $row->id);
			$db->setQuery($query);
			$db->execute();
		}

		if ($row->plan_id != 0)
		{
			$query->clear();

			for ($i = 0, $n = count($planIds); $i < $n; $i++)
			{
				$planId = $planIds[$i];

				if ($planId > 0)
				{
					$query->values("$row->id, $planId");
				}
			}

			$query->insert('#__osmembership_coupon_plans')
				->columns('coupon_id, plan_id');
			$db->setQuery($query);

			$db->execute();
		}
	}

	/**
	 * Get list of subscription records which use the current coupon code
	 *
	 * @return array
	 */
	public function getSubscriptions()
	{
		if ($this->state->id)
		{
			$db    = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select('id, first_name, last_name, email, created_date, amount')
				->from('#__osmembership_subscribers')
				->where('coupon_id = ' . $this->state->id)
				->order('id');
			$db->setQuery($query);

			return $db->loadObjectList();
		}

		return array();
	}

	/**
	 * @param $file
	 *
	 * @return int
	 * @throws Exception
	 */
	public function import($file)
	{
		$coupons = OSMembershipHelperData::getDataFromFile($file);

		// Get list of plans
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id, title')
			->from('#__osmembership_plans');
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		$plans = array();

		foreach ($rows as $row)
		{
			$plans[StringHelper::strtolower($row->title)] = $row->id;
		}

		$imported = 0;


		if (count($coupons))
		{
			$executeInsert = false;

			$query->clear()
				->insert('#__osmembership_coupon_plans')
				->columns(array('plan_id', 'coupon_id'));

			foreach ($coupons as $coupon)
			{
				if (empty($coupon['code']) || empty($coupon['discount']))
				{
					continue;
				}

				$row = $this->getTable();

				if (!empty($coupon['id']))
				{
					$row->load($coupon['id']);
				}

				// Get plan Ids
				$planTitles = StringHelper::strtolower($coupon['plan']);
				$planTitles = explode(',', $planTitles);
				$planIds    = array();

				foreach ($planTitles as $planTitle)
				{
					$planIds[] = isset($plans[$planTitle]) ? $plans[$planTitle] : 0;
				}

				$planIds = array_filter($planIds);

				if (count($planIds))
				{
					$coupon['plan_id'] = 1;
				}
				else
				{
					$coupon['plan_id'] = 0;
				}

				if ($coupon['valid_from'])
				{
					$coupon ['valid_from'] = JHtml::date($coupon['valid_from'], 'Y-m-d');
				}
				else
				{
					$coupon ['valid_from'] = '';
				}

				if ($coupon['valid_to'])
				{
					$coupon ['valid_to'] = JHtml::date($coupon['valid_to'], 'Y-m-d');
				}
				else
				{
					$coupon ['valid_to'] = '';
				}

				$row->bind($coupon, array('id'));
				$row->store();

				if (count($planIds) > 0)
				{
					foreach ($planIds as $planId)
					{
						$query->values(implode(',', array($planId, $row->id)));
					}
				}

				$executeInsert = true;
				$imported++;
			}

			if ($executeInsert)
			{
				$db->setQuery($query)
					->execute();
			}
		}

		return $imported;
	}

	/**
	 * Generate batch coupon
	 *
	 * @param MPFInput $input
	 */
	public function batch($input)
	{
		$numberCoupon        = $input->getInt('number_coupon', 50);
		$charactersSet       = $input->getString('characters_set');
		$prefix              = $input->getString('prefix');
		$length              = $input->getInt('length', 20);
		$data                = array();
		$data['discount']    = $input->getFloat('discount', 0);
		$data['coupon_type'] = $input->getInt('coupon_type', 0);
		$data['times']       = $input->getInt('times');

		$data['plan_id'] = $input->getInt('plan_id', 0);

		if ($input->getString('valid_from'))
		{
			$data ['valid_from'] = JHtml::date($input->getString('valid_from'), 'Y-m-d', null);
		}
		else
		{
			$data ['valid_from'] = '';
		}

		if ($input->getString('valid_to'))
		{
			$data ['valid_to'] = JHtml::date($input->getString('valid_to'), 'Y-m-d', null);
		}
		else
		{
			$data ['valid_to'] = '';
		}
		$data['used']       = 0;
		$data ['published'] = $input->getInt('published');

		for ($i = 0; $i < $numberCoupon; $i++)
		{
			$salt         = static::genRandomCoupon($length, $charactersSet);
			$couponCode   = $prefix . $salt;
			$row          = $this->getTable();
			$data['code'] = $couponCode;

			$row->bind($data);
			$row->store();
		}
	}

	/**
	 * Generate random Coupon
	 *
	 * @param int    $length
	 * @param string $charactersSet
	 *
	 * @return string
	 */
	private static function genRandomCoupon($length = 8, $charactersSet)
	{
		$salt = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		if ($charactersSet)
		{
			$salt = $charactersSet;
		}

		$base     = strlen($salt);
		$makePass = '';

		/*
		 * Start with a cryptographic strength random string, then convert it to
		 * a string with the numeric base of the salt.
		 * Shift the base conversion on each character so the character
		 * distribution is even, and randomize the start shift so it's not
		 * predictable.
		 */
		$random = JCrypt::genRandomBytes($length + 1);
		$shift  = ord($random[0]);

		for ($i = 1; $i <= $length; ++$i)
		{
			$makePass .= $salt[($shift + ord($random[$i])) % $base];
			$shift += ord($random[$i]);
		}

		return $makePass;
	}

	/**
	 * Delete coupon relation data after coupon deleted
	 *
	 * @param array $cid
	 */
	protected function afterDelete($cid)
	{
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		$query->delete('#__osmembership_coupon_plans')
			->where('coupon_id IN (' . implode(',', $cid) . ')');
		$db->setQuery($query)
			->execute();
	}
}
