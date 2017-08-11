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

class OSMembershipViewSubscriptionsHtml extends MPFViewHtml
{
	public function display()
	{
		$app = JFactory::getApplication();

		if (!JFactory::getUser()->get('id'))
		{
			$active = $app->getMenu()->getActive();
			$option = isset($active->query['option']) ? $active->query['option'] : '';
			$view   = isset($active->query['view']) ? $active->query['view'] : '';

			if ($option == 'com_osmembership' && $view == 'subscriptions')
			{
				$returnUrl = 'index.php?Itemid=' . $active->id;
			}
			else
			{
				$returnUrl = JUri::getInstance()->toString();
			}

			$url = JRoute::_('index.php?option=com_users&view=login&return=' . base64_encode($returnUrl), false);

			$app->redirect($url, JText::_('OSM_PLEASE_LOGIN'));
		}

		$model            = $this->getModel();
		$this->items      = $model->getData();
		$this->config     = OSMembershipHelper::getConfig();
		$this->pagination = $model->getPagination();

		parent::display();
	}
}
