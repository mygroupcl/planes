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

/**
 * HTML View class for Membership Pro component
 *
 * @static
 * @package        Joomla
 * @subpackage     Membership Pro
 *
 * @property OSMembershipModelCoupon $model
 */
class OSMembershipViewCouponHtml extends MPFViewItem
{
	protected function prepareView()
	{
		parent::prepareView();

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id, title')
			->from('#__osmembership_plans')
			->where('published = 1')
			->order('ordering');
		$db->setQuery($query);
		$options[] = JHtml::_('select.option', 0, JText::_('OSM_ALL_PLANS'), 'id', 'title');
		$options   = array_merge($options, $db->loadObjectList());

		if ($this->item->id)
		{
			$query->clear()
				->select('plan_id')
				->from('#__osmembership_coupon_plans')
				->where('coupon_id = ' . $this->item->id);
			$db->setQuery($query);
			$planIds = $db->loadColumn();

			if (count($planIds) == 0)
			{
				$planIds = array(0);
			}
		}
		else
		{
			$planIds = array(0);
		}

		$this->lists['plan_id'] = JHtml::_('select.genericlist', $options, 'plan_id[]', ' multiple="multiple" ', 'id', 'title', $planIds);

		$options                    = array();
		$options[]                  = JHtml::_('select.option', 0, JText::_('%'));
		$options[]                  = JHtml::_('select.option', 1, '$');
		$this->lists['coupon_type'] = JHtml::_('select.genericlist', $options, 'coupon_type', ' class="input-small" ', 'value', 'text', $this->item->coupon_type);

		$options                  = array();
		$options[]                = JHtml::_('select.option', 0, JText::_('OSM_ALL_PAYMENTS'));
		$options[]                = JHtml::_('select.option', 1, JText::_('OSM_ONLY_FIRST_PAYMENT'));
		$this->lists['apply_for'] = JHtml::_('select.genericlist', $options, 'apply_for', '', 'value', 'text', $this->item->apply_for);
		$this->subscriptions      = $this->model->getSubscriptions();

		$this->nullDate = '0000-00-00';
		$this->config   = OSMembershipHelper::getConfig();
	}

	protected function addToolbar()
	{
		$layout = $this->getLayout();

		if ($layout == 'default')
		{
			parent::addToolbar();
		}
	}
}
