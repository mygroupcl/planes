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

use Joomla\Registry\Registry;

/**
 * HTML View class for Membership Pro component
 *
 * @static
 * @package        Joomla
 * @subpackage     Membership Pro
 */
class OSMembershipViewPluginHtml extends MPFViewItem
{
	protected function prepareView()
	{
		parent::prepareView();
		$registry = new Registry();
		$registry->loadString($this->item->params);
		$data         = new stdClass();
		$data->params = $registry->toArray();
		$form         = JForm::getInstance('osmembership', JPATH_ROOT . '/components/com_osmembership/plugins/' . $this->item->name . '.xml', array(), false, '//config');
		$form->bind($data);
		$this->form = $form;
	}

	protected function addToolbar()
	{
		$helperClass = $this->viewConfig['class_prefix'] . 'Helper';
		if (is_callable($helperClass . '::getActions'))
		{
			$canDo = call_user_func(array($helperClass, 'getActions'), $this->name, $this->state);
		}
		else
		{
			$canDo = call_user_func(array('MPFHelper', 'getActions'), $this->viewConfig['option'], $this->name, $this->state);
		}
		$languagePrefix = $this->viewConfig['language_prefix'];
		if ($this->item->id)
		{
			$toolbarTitle = $languagePrefix . '_' . $this->name . '_EDIT';
		}
		else
		{
			$toolbarTitle = $languagePrefix . '_' . $this->name . '_NEW';
		}

		JToolbarHelper::title(JText::_(strtoupper($toolbarTitle)));
		if ($canDo->get('core.edit') || ($canDo->get('core.create')))
		{
			JToolbarHelper::apply('apply', 'JTOOLBAR_APPLY');
			JToolbarHelper::save('save', 'JTOOLBAR_SAVE');
		}
		if ($this->item->id)
		{
			JToolbarHelper::cancel('cancel', 'JTOOLBAR_CLOSE');
		}
		else
		{
			JToolbarHelper::cancel('cancel', 'JTOOLBAR_CANCEL');
		}
	}
}
