<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

class OSMembershipViewCardHtml extends MPFViewHtml
{
	public $hasModel = false;

	public function display()
	{
		// Add necessary javascript files
		OSMembershipHelper::addLangLinkForAjax();
		JFactory::getDocument()->addScript(JUri::base(true) . '/media/com_osmembership/assets/js/paymentmethods.min.js');

		$config         = OSMembershipHelper::getConfig();
		$subscriptionId = $this->input->getString('subscription_id');
		$subscription   = OSMembershipHelperSubscription::getSubscription($subscriptionId);

		if (!$subscription)
		{
			throw new Exception(JText::sprintf('Subscription ID %s not found', $subscriptionId));
		}

		$method = os_payments::getPaymentMethod($subscription->payment_method);

		// Payment Methods parameters
		$lists['exp_month'] = JHtml::_('select.integerlist', 1, 12, 1, 'exp_month', ' id="exp_month" class="input-small" ', $this->input->get('exp_month', date('m'), 'none'), '%02d');
		$currentYear        = date('Y');
		$lists['exp_year']  = JHtml::_('select.integerlist', $currentYear, $currentYear + 10, 1, 'exp_year', ' id="exp_year" class="input-small" ', $this->input->get('exp_year', date('Y'), 'none'));

		$this->bootstrapHelper = new OSMembershipHelperBootstrap($config->twitter_bootstrap_version);
		$this->lists           = $lists;
		$this->subscription    = $subscription;

		parent::display();
	}
}
