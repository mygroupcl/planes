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

class OSMembershipModelImport extends MPFModel
{
	/**
	 * @param $file
	 *
	 * @return int
	 * @throws Exception
	 */
	public function store($file)
	{
		jimport('joomla.user.helper');
		$app              = JFactory::getApplication();
		$db               = JFactory::getDbo();
		$query            = $db->getQuery(true);
		$params           = JComponentHelper::getParams('com_users');
		$newUserType      = $params->get('new_usertype', 2);
		$subscribers      = OSMembershipHelperData::getDataFromFile($file);
		$data             = array();
		$data['groups']   = array();
		$data['groups'][] = $newUserType;
		$data['block']    = 0;
		$rowFieldValue    = JTable::getInstance('OsMembership', 'FieldValue');
		$query->select('id, name')
			->from('#__osmembership_fields')
			->where('is_core = 0');
		$db->setQuery($query);
		$customFields = $db->loadObjectList();


		JPluginHelper::importPlugin('osmembership');
		$dispatcher = JEventDispatcher::getInstance();

		// Get list of plans
		$query->clear()
			->select('id, title')
			->from('#__osmembership_plans');
		$db->setQuery($query);
		$rows  = $db->loadObjectList();
		$plans = array();

		foreach ($rows as $row)
		{
			$plans[StringHelper::strtolower($row->title)] = $row->id;
		}

		$timezone   = JFactory::getConfig()->get('offset');
		$dateFields = array('created_date', 'payment_date', 'from_date', 'to_date');
		$imported   = 0;


		foreach ($subscribers as $subscriber)
		{
			if (empty($subscriber['plan']))
			{
				continue;
			}

			$userId = 0;

			$subscriber['username'] = trim($subscriber['username']);

			//check username exit in table users
			if ($subscriber['username'])
			{
				$query->clear();
				$query->select('id')
					->from('#__users')
					->where('username = ' . $db->quote($subscriber['username']));
				$db->setQuery($query);
				$userId = (int) $db->loadResult();

				if (!$userId)
				{
					$data['name'] = $subscriber['first_name'] . ' ' . $subscriber['last_name'];

					if ($subscriber['password'])
					{
						$data['password'] = $data['password2'] = $subscriber['password'];
					}
					else
					{
						$data['password'] = $data['password2'] = JUserHelper::genRandomPassword();
					}
					$data['email']    = $data['email1'] = $data['email2'] = trim($subscriber['email']);
					$data['username'] = $subscriber['username'];

					if ($data['username'] && $data['name'] && $data['email1'])
					{
						$user = new JUser();
						$user->bind($data);
						$user->save();
						$userId = $user->id;
					}
				}
			}

			foreach ($dateFields as $field)
			{
				if (!empty($subscriber[$field]))
				{
					try
					{
						$date = JFactory::getDate($subscriber[$field], $timezone);
						$date->setTime(23, 59, 59);
						$subscriber[$field] = $date->toSql();
					}
					catch (Exception $e)
					{
						$app->enqueueMessage($subscriber[$field] . ' for field ' . $field . ' is not a correct date value');
					}
				}
			}

			//get plan Id
			$planTitle = StringHelper::strtolower($subscriber['plan']);

			$planId                = isset($plans[$planTitle]) ? $plans[$planTitle] : 0;
			$subscriber['plan_id'] = $planId;
			$subscriber['user_id'] = $userId;

			//save subscribers core
			/* @var OSMembershipTableSubscriber $row */
			$row = $this->getTable('Subscriber');

			if (!empty($subscriber['id']))
			{
				$row->load($subscriber['id']);
				if ($row->id)
				{
					$query->clear()
						->delete('#__osmembership_field_value')
						->where('subscriber_id = ' . $row->id);
					$db->setQuery($query);
					$db->execute();
				}
			}

			$row->bind($subscriber, array('id'));

			if (!$row->payment_date)
			{
				$row->payment_date = $row->from_date;
			}
			
			if (!$row->created_date)	
			{
				$row->created_date     = $row->from_date;
			}
			
			$row->is_profile       = 1;
			$row->plan_main_record = 1;

			if ($userId > 0)
			{
				$query->clear();
				$query->select('id')
					->from('#__osmembership_subscribers')
					->where('is_profile = 1')
					->where('user_id = ' . $userId);
				$db->setQuery($query);
				$profileId = $db->loadResult();

				if ($profileId)
				{
					$row->is_profile = 0;
					$row->profile_id = $profileId;
				}

				$query->clear()
					->select('plan_subscription_from_date')
					->from('#__osmembership_subscribers')
					->where('plan_main_record = 1')
					->where('user_id = ' . $userId)
					->where('plan_id = ' . $row->plan_id);
				$db->setQuery($query);

				if ($row->id > 0)
				{
					$query->where('id != ' . $row->id);
				}

				$db->setQuery($query);
				$planMainRecord = $db->loadObject();

				if ($planMainRecord)
				{
					$row->plan_main_record            = 0;
					$row->plan_subscription_from_date = $planMainRecord->plan_subscription_from_date;
				}
			}

			if (!$row->id && $row->plan_main_record == 1)
			{
				$row->plan_subscription_status    = $row->published;
				$row->plan_subscription_from_date = $row->from_date;
				$row->plan_subscription_to_date   = $row->to_date;
			}

			$row->store();

			if (!$row->profile_id)
			{
				$row->profile_id = $row->id;
				$row->store();
			}

			//get Extra Field
			if (count($customFields))
			{
				foreach ($customFields as $customField)
				{
					if (isset($subscriber[$customField->name]) && $subscriber[$customField->name])
					{
						$rowFieldValue->id            = 0;
						$rowFieldValue->field_id      = $customField->id;
						$rowFieldValue->subscriber_id = $row->id;
						$rowFieldValue->field_value   = $subscriber[$customField->name];
						$rowFieldValue->store();
					}
				}
			}

			if ($row->published == 1)
			{
				$dispatcher->trigger('onMembershipActive', array($row));
			}

			$imported++;
		}

		return $imported;
	}

	/**
	 * Import subscribers from Joomla core users
	 *
	 * @param int $planid
	 * @param int $start
	 * @param int $limit
	 *
	 * @return int
	 */
	public function importFromJoomla($planId, $start = 0, $limit = 0)
	{
		$dispatcher = JEventDispatcher::getInstance();

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// TODO: Change to ID of the actual plan before running the import
		$nullDate = $db->getNullDate();
		$imported = 0;

		$query->select('*')
			->from('#__osmembership_plans')
			->where('id = ' . (int) $planId);
		$db->setQuery($query);
		$rowPlan = $db->loadObject();

		$query->clear()
			->select('id, name, email')
			->where('id IN (SELECT user_id FROM #__user_usergroup_map WHERE group_id NOT IN (7, 8))')
			->from('#__users')
			->order('id');

		if ($limit)
		{
			$db->setQuery($query, $start, $limit);
		}
		else
		{
			$db->setQuery($query);
		}

		$users = $db->loadObjectList();

		foreach ($users as $user)
		{
			$query->clear()
				->select('COUNT(*)')
				->from('#__osmembership_subscribers')
				->where('plan_id = ' . $planId)
				->where('user_id = ' . $user->id);
			$db->setQuery($query);
			$total = $db->loadResult();

			if ($total)
			{
				continue;
			}

			$data            = array();
			$userId          = $user->id;
			$data['plan_id'] = $planId;
			$data['user_id'] = $userId;

			// Detect first name and last name
			$name = $user->name;

			if ($name)
			{
				$pos = strpos($name, ' ');

				if ($pos !== false)
				{
					$data['first_name'] = substr($name, 0, $pos);
					$data['last_name']  = substr($name, $pos + 1);
				}
				else
				{
					$data['first_name'] = $name;
					$data['last_name']  = '';
				}
			}

			/* @var OSMembershipTableSubscriber $row */
			$row = $this->getTable('Subscriber');
			$row->bind($data);

			$row->published        = 1;
			$row->created_date     = JFactory::getDate()->toSql();
			$row->payment_date     = $row->created_date;
			$row->user_id          = $userId;
			$row->is_profile       = 1;
			$row->plan_main_record = 1;


			$query->clear()
				->select('id')
				->from('#__osmembership_subscribers')
				->where('user_id = ' . $userId)
				->where('is_profile = 1');
			$db->setQuery($query);
			$profileId = $db->loadResult();

			if ($profileId)
			{
				$row->is_profile = 0;
				$row->profile_id = $profileId;
			}

			$row->language = JFactory::getLanguage()->getTag();

			$date           = JFactory::getDate();
			$row->from_date = $date->toSql();

			if ($rowPlan->expired_date && $rowPlan->expired_date != $nullDate)
			{

				$expiredDate = JFactory::getDate($rowPlan->expired_date, JFactory::getConfig()->get('offset'));

				// Change year of expired date to current year
				if ($date->year > $expiredDate->year)
				{
					$expiredDate->setDate($date->year, $expiredDate->month, $expiredDate->day);
				}

				$expiredDate->setTime(23, 59, 59);
				$date->setTime(23, 59, 59);

				$numberYears = 1;

				if ($rowPlan->subscription_length_unit == 'Y')
				{
					$numberYears = $rowPlan->subscription_length;
				}

				if ($date >= $expiredDate)
				{
					$numberYears++;
				}

				$expiredDate->setDate($expiredDate->year + $numberYears - 1, $expiredDate->month, $expiredDate->day);

				OSMembershipHelperSubscription::modifySubscriptionDuration($date, $rowFields, $data);

				$row->to_date = $expiredDate->toSql();
			}
			else
			{
				if ($rowPlan->lifetime_membership)
				{
					$row->to_date = '2099-12-31 23:59:59';
				}
				else
				{
					$dateIntervalSpec = 'P' . $rowPlan->subscription_length . $rowPlan->subscription_length_unit;
					$date->add(new DateInterval($dateIntervalSpec));
					$row->to_date = $date->toSql();
				}
			}

			$row->plan_subscription_status    = $row->published;
			$row->plan_subscription_from_date = $row->from_date;
			$row->plan_subscription_to_date   = $row->to_date;

			$row->store();

			if (!$row->profile_id)
			{
				$row->profile_id = $row->id;
				$row->store();
			}

			$dispatcher->trigger('onMembershipActive', array($row));

			$imported++;
		}

		return $imported;
	}
}
