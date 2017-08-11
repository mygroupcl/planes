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

class os_offline extends MPFPayment
{
	/**
	 * Process payment
	 */
	public function processPayment($row, $data)
	{
		$Itemid = JFactory::getApplication()->input->getInt('Itemid');

		$subscriptionStatus = $this->params->get('subscription_status');

		if ($subscriptionStatus == 1)
		{
			$this->onPaymentSuccess($row, $row->transaction_id);
		}
		else
		{
			$config = OSMembershipHelper::getConfig();
			OSMembershipHelper::sendEmails($row, $config);
		}

		JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_osmembership&view=complete&Itemid=' . $Itemid, false, false));
	}
}
