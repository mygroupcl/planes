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

class OSMembershipControllerProfile extends OSMembershipController
{
	/**
	 * Update user profile data
	 */
	public function update()
	{
		$Itemid = $this->input->getInt('Itemid', 0);
		$data   = $this->input->getData();

		/**@var OSMembershipModelProfile $model * */
		$model      = $this->getModel();
		$data['id'] = (int) $data['cid'][0];

		try
		{
			$model->updateProfile($data, $this->input);
			$message = JText::_('OSM_YOUR_PROFILE_UPDATED');
			$type    = 'message';
		}
		catch (Exception $e)
		{
			$message = $e->getMessage();
			$type    = 'error';
		}

		//Redirect to the profile page
		$this->setRedirect(JRoute::_('index.php?option=com_osmembership&view=profile&Itemid=' . $Itemid), $message, $type);
	}

	/**
	 * Update subscription credit card
	 */
	public function update_card()
	{
		$this->csrfProtection();

		$Itemid = $this->input->getInt('Itemid', 0);
		$data   = $this->input->post->getData();

		/**@var OSMembershipModelProfile $model * */
		$model = $this->getModel();

		try
		{
			$model->updateCard($data);
			$message = JText::_('OSM_CREDITCARD_UPDATED');
			$type    = 'message';
		}
		catch (Exception $e)
		{
			$message = $e->getMessage();
			$type    = 'error';
		}

		//Redirect to the profile page
		$this->setRedirect(JRoute::_('index.php?option=com_osmembership&view=profile&Itemid=' . $Itemid), $message, $type);
	}
}
