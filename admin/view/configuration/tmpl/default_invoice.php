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
?>
<fieldset class="form-horizontal">
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('activate_invoice_feature', JText::_('OSM_ACTIVATE_INVOICE_FEATURE'), JText::_('OSM_ACTIVATE_INVOICE_FEATURE_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('activate_invoice_feature', $config->activate_invoice_feature); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('send_invoice_to_customer', JText::_('OSM_SEND_INVOICE_TO_SUBSCRIBERS'), JText::_('OSM_SEND_INVOICE_TO_SUBSCRIBERS_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('send_invoice_to_customer', $config->send_invoice_to_customer); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('send_invoice_to_admin', JText::_('OSM_SEND_COPY_OF_INVOICE_TO_ADMIN'), JText::_('OSM_SEND_COPY_OF_INVOICE_TO_ADMIN_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('send_invoice_to_admin', $config->send_invoice_to_admin); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('invoice_start_number', JText::_('OSM_INVOICE_START_NUMBER'), JText::_('OSM_INVOICE_START_NUMBER_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="invoice_start_number" class="inputbox" value="<?php echo $this->config->invoice_start_number ? $this->config->invoice_start_number : 1; ?>" size="10" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('reset_invoice_number', JText::_('OSM_RESET_INVOICE_NUMBER_EVERY_YEAR'), JText::_('OSM_RESET_INVOICE_NUMBER_EVERY_YEAR_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('reset_invoice_number', $config->reset_invoice_number); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('invoice_prefix', JText::_('OSM_INVOICE_PREFIX'), JText::_('OSM_INVOICE_PREFIX_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="invoice_prefix" class="inputbox" value="<?php echo isset($this->config->invoice_prefix) ? $this->config->invoice_prefix : 'IV'; ?>" size="10" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('invoice_number_length', JText::_('OSM_INVOICE_NUMBER_LENGTH'), JText::_('OSM_INVOICE_NUMBER_LENGTH_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="invoice_number_length" class="inputbox" value="<?php echo $this->config->invoice_number_length ? $this->config->invoice_number_length : 5; ?>" size="10" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('pdf_font', JText::_('OSM_PDF_FONT'), JText::_('OSM_PDF_FONT_EXPLAIN')); ?>
			<p class="text-warning">
				<?php echo JText::_('OSM_PDF_FONT_WARNING'); ?>
			</p>
		</div>
		<div class="controls">
			<?php echo $this->lists['pdf_font']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('invoice_format', JText::_('OSM_INVOICE_FORMAT'), ''); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'invoice_format',  $this->config->invoice_format , '100%', '550', '75', '8') ;?>
		</div>
	</div>
</fieldset>
