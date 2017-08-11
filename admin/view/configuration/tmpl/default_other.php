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
	<legend><?php echo JText::_('OSM_OTHER_SETTINGS'); ?></legend>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('send_attachments_to_admin', JText::_('OSM_SEND_ATTACHMENTS_TO_ADMIN'), JText::_('OSM_SEND_ATTACHMENTS_TO_ADMIN_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('send_attachments_to_admin', $config->send_attachments_to_admin); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('use_https', JText::_('OSM_ACTIVATE_HTTPS'), ''); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('use_https', $config->use_https); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('country_list', JText::_('OSM_DEFAULT_COUNTRY'), ''); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['country_list']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('eu_vat_number_field', JText::_('OSM_EU_VAT_NUMBER_FIELD'), JText::_('OSM_EU_VAT_NUMBER_FIELD_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['eu_vat_number_field']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('article_id', JText::_('OSM_TERMS_AND_CONDITIONS_ARTICLE'), ''); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getArticleInput($this->config->article_id, 'article_id'); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('allowed_file_types', JText::_('OSM_ALLOWED_FILE_TYPES'), JText::_('OSM_ALLOWED_FILE_TYPES_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="allowed_file_types" class="input-xlarge" value="<?php echo $this->config->allowed_file_types; ?>" size="50" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('conversion_tracking_code', JText::_('OSM_CONVERSION_TRACKING_CODE'), JText::_('OSM_CONVERSION_TRACKING_CODE_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<textarea name="conversion_tracking_code" class="input-xlarge" rows="10"><?php echo $this->config->conversion_tracking_code;?></textarea>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('export_data_format', JText::_('OSM_EXPORT_DATA_FORMAT')); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['export_data_format']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('debug', JText::_('OSM_DEBUG'), JText::_('OSM_DEBUG_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('debug', $config->debug); ?>
		</div>
	</div>
</fieldset>
