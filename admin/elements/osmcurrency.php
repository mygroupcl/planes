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

JFormHelper::loadFieldClass('list');

class JFormFieldOSMCurrency extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var string
	 */
	protected $type = 'osmcurrency';

	protected function getOptions()
	{
		$currencies = require_once JPATH_ROOT . '/components/com_osmembership/helper/currencies.php';
		$options    = array();
		$options[]  = JHtml::_('select.option', '', JText::_('Select Currency'));
		foreach ($currencies as $code => $title)
		{
			$options[] = JHtml::_('select.option', $code, $title);
		}

		return $options;
	}
}
