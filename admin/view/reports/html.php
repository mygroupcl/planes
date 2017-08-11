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

class OSMembershipViewReportsHtml extends MPFViewList
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

		$options                = array();
		$options[]              = JHtml::_('select.option', 0, JText::_('OSM_ALL_PLANS'), 'id', 'title');
		$options                = array_merge($options, $db->loadObjectList());
		$this->lists['plan_id'] = JHtml::_('select.genericlist', $options, 'plan_id', ' class="inputbox" onchange="submit();" ', 'id', 'title', $this->state->plan_id);

		$options                  = array();
		$options[]                = JHtml::_('select.option', -1, JText::_('OSM_ALL'));
		$options[]                = JHtml::_('select.option', 0, JText::_('OSM_PENDING'));
		$options[]                = JHtml::_('select.option', 1, JText::_('OSM_ACTIVE'));
		$options[]                = JHtml::_('select.option', 2, JText::_('OSM_EXPIRED'));
		$options[]                = JHtml::_('select.option', 3, JText::_('OSM_CANCELLED_PENDING'));
		$options[]                = JHtml::_('select.option', 4, JText::_('OSM_UPCOMING_EXPIRED'));
		$options[]                = JHtml::_('select.option', 5, JText::_('OSM_UPCOMING_RENEWAL'));
		$this->lists['published'] = JHtml::_('select.genericlist', $options, 'published', ' class="input-box" onchange="submit();" ', 'value', 'text', $this->state->published);

		$options   = array();
		$options[] = JHtml::_('select.option', 0, JText::_('OSM_IN'));

		for ($i = 5; $i <= 60; $i += 5)
		{
			$options[] = JHtml::_('select.option', $i, $i . ' ' . JText::_('OSM_DAYS'));
		}

		$this->lists['filter_in'] = JHtml::_('select.genericlist', $options, 'filter_in', ' class="input-small" onchange="submit();" ', 'value', 'text', $this->state->filter_in);

		$this->config = OSMembershipHelper::getConfig();

		$this->setLayout('default');
	}

	/**
	 * Empty method so that no default toolbar buttons ar added
	 */
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_(strtoupper('OSM_REPORT_MANAGEMENT')), 'link ' . $this->name);
	}
}
