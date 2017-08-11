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

$rootUri = JUri::root(true);
echo JHtml::_('bootstrap.startTabSet', 'invoice-translation', array('active' => 'invoice-translation-'.$this->languages[0]->sef));

foreach ($this->languages as $language)
{
	$sef = $language->sef;
	echo JHtml::_('bootstrap.addTab', 'invoice-translation', 'invoice-translation-' . $sef, $language->title . ' <img src="' . $rootUri . '/media/com_osmembership/flags/' . $sef . '.png" />');
	?>
		<div class="control-group">
			<div class="control-label">
				<?php echo OSMembershipHelperHtml::getFieldLabel('invoice_format_'.$sef, JText::_('OSM_INVOICE_FORMAT'), JText::_('OSM_INVOICE_FORMAT_EXPLAIN')); ?>
			</div>
			<div class="controls">
				<?php echo $editor->display('invoice_format_' . $sef, $config->{'invoice_format_' . $sef}, '100%', '550', '75', '8');?>
			</div>
		</div>
	<?php
	echo JHtml::_('bootstrap.endTab');
}

echo JHtml::_('bootstrap.endTabSet');

