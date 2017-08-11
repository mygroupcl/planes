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
class OSMembershipViewEmailsHtml extends MPFViewList
{
	/**
	 * Method to instantiate the view.
	 *
	 * @param   array $config The configuration data for the view
	 *
	 * @since  1.0
	 */
	public function __construct($config = array())
	{
		$config['hide_buttons'] = array('add', 'edit', 'publish');

		parent::__construct($config);
	}

	/**
	 * Build necessary data for the view before it is being displayed
	 *
	 */
	protected function prepareView()
	{
		parent::prepareView();

		$options   = array();
		$options[] = JHtml::_('select.option', '', JText::_('OSM_EMAIL_TYPE'));
		$options[] = JHtml::_('select.option', 'new_subscription_emails', JText::_('OSM_NEW_SUBSCRIPTION_EMAILS'));
		$options[] = JHtml::_('select.option', 'subscription_renewal_emails', JText::_('OSM_SUBSCRIPTION_RENEWAL_EMAILS'));
		$options[] = JHtml::_('select.option', 'subscription_upgrade_emails', JText::_('OSM_SUBSCRIPTION_UPGRADE_EMAILS'));
		$options[] = JHtml::_('select.option', 'subscription_approved_emails', JText::_('OSM_SUBSCRIPTION_APPROVED_EMAILS'));
		$options[] = JHtml::_('select.option', 'subscription_cancel_emails', JText::_('OSM_SUBSCRIPTION_CANCEL_EMAILS'));
		$options[] = JHtml::_('select.option', 'profile_updated_emails', JText::_('OSM_PROFILE_UPDATED_EMAILS'));
		$options[] = JHtml::_('select.option', 'first_reminder_emails', JText::_('OSM_FIRST_REMINDER_EMAILS'));
		$options[] = JHtml::_('select.option', 'second_reminder_emails', JText::_('OSM_SECOND_REMINDER_EMAILS'));
		$options[] = JHtml::_('select.option', 'third_reminder_emails', JText::_('OSM_THIRD_REMINDER_EMAILS'));

		$this->lists['filter_email_type'] = JHtml::_('select.genericlist', $options, 'filter_email_type', ' onchange="submit();" ', 'value', 'text', $this->state->filter_email_type);

		$options   = array();
		$options[] = JHtml::_('select.option', 0, JText::_('OSM_SENT_TO'));
		$options[] = JHtml::_('select.option', 1, JText::_('OSM_ADMIN'));
		$options[] = JHtml::_('select.option', 2, JText::_('OSM_SUBSCRIBERS'));

		$this->lists['filter_sent_to'] = JHtml::_('select.genericlist', $options, 'filter_sent_to', ' onchange="submit();" ', 'value', 'text', $this->state->filter_sent_to);
	}

	/**
	 * Method to add toolbar buttons
	 */
	protected function addToolbar()
	{
		parent::addToolbar();

		JToolbarHelper::trash('delete_all', 'OSM_DELETE_ALL', false);
	}
}
