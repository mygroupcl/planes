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
 */
class OSMembershipViewSubscribersHtml extends MPFViewList
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

		$options   = array();
		$options[] = JHtml::_('select.option', 0, JText::_('OSM_ALL_PLANS'), 'id', 'title');
		$options   = array_merge($options, $db->loadObjectList());

		$this->lists['plan_id'] = JHtml::_('select.genericlist', $options, 'plan_id', ' onchange="submit();" ', 'id', 'title', $this->state->plan_id);

		$options   = array();
		$options[] = JHtml::_('select.option', 0, JText::_('OSM_ALL_SUBSCRIPTIONS'));
		$options[] = JHtml::_('select.option', 1, JText::_('OSM_NEW_SUBSCRIPTION'));
		$options[] = JHtml::_('select.option', 2, JText::_('OSM_SUBSCRIPTION_RENEWAL'));
		$options[] = JHtml::_('select.option', 3, JText::_('OSM_SUBSCRIPTION_UPGRADE'));

		$this->lists['subscription_type'] = JHtml::_('select.genericlist', $options, 'subscription_type', ' class="inputbox" onchange="submit();" ', 'value', 'text', $this->state->subscription_type);

		$options   = array();
		$options[] = JHtml::_('select.option', -1, JText::_('OSM_ALL'));
		$options[] = JHtml::_('select.option', 0, JText::_('OSM_PENDING'));
		$options[] = JHtml::_('select.option', 1, JText::_('OSM_ACTIVE'));
		$options[] = JHtml::_('select.option', 2, JText::_('OSM_EXPIRED'));

		$this->lists['published'] = JHtml::_('select.genericlist', $options, 'published', ' class="input-medium" onchange="submit();" ', 'value', 'text', $this->state->published);

		$this->config = OSMembershipHelper::getConfig();

		$this->addToolbar();
	}

	/**
	 * Add Toolbar
	 */
	protected function addToolbar()
	{
		require_once JPATH_ADMINISTRATOR . '/includes/toolbar.php';

		parent::addToolbar();

		JToolbarHelper::custom('renew', 'plus', 'plus', 'OSM_RENEW_SUBSCRIPTION', true);
		JToolbarHelper::custom('export', 'download', 'download', 'OSM_EXPORT', false);
	}
}
