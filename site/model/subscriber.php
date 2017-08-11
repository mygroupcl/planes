<?php
/**
 * @package        Joomla
 * @subpackage     OSMembership
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die;

JLoader::register('OSMembershipModelSubscription', JPATH_ADMINISTRATOR . '/components/com_osmembership/model/subscription.php');

class OSMembershipModelSubscriber extends OSMembershipModelSubscription
{

}