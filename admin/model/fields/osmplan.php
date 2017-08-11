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

class JFormFieldOSMPlan extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var string
	 */
	protected $type = 'osmplan';

	protected function getOptions()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select($db->quoteName('id', 'value'))
			->select($db->quoteName('title', 'text'))
			->from('#__osmembership_plans')
			->where('published = 1')
			->order('title');
		$db->setQuery($query);
		$options   = array();
		$options[] = JHtml::_('select.option', '0', JText::_('Select Plan'));

		return array_merge($options, $db->loadObjectList());
	}
}
