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

class OSMembershipViewScheduleK2itemsHtml extends MPFViewHtml
{
	public function display()
	{

		$app = JFactory::getApplication();

		if (!JPluginHelper::isEnabled('system', 'schedulek2items'))
		{
			$app->enqueueMessage(JText::_('Schedule K2 Items feature is not enabled. Please contact super administrator'));

			return;
		}

		if (!JFactory::getUser()->get('id'))
		{
			$app->redirect(JRoute::_('index.php?option=com_users&view=login&return=' . base64_encode(JUri::getInstance()->toString())), JText::_('OSM_PLEASE_LOGIN'));
		}

		/* @var $model OSMembershipModelScheduleK2items */
		$model               = $this->getModel();
		$this->items         = $model->getData();
		$this->pagination    = $model->getPagination();
		$this->config        = OSMembershipHelper::getConfig();
		$this->subscriptions = OSMembershipHelperSubscription::getUserSubscriptionsInfo();

		parent::display();
	}
}
