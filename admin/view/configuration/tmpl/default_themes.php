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
	<legend><?php echo JText::_('OSM_THEME_SETTINGS'); ?></legend>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('load_twitter_bootstrap_in_frontend', JText::_('OSM_LOAD_BOOTSTRAP_CSS_IN_FRONTEND'), JText::_('OSM_LOAD_BOOTSTRAP_CSS_IN_FRONTEND_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('load_twitter_bootstrap_in_frontend', isset($config->load_twitter_bootstrap_in_frontend) ? $config->load_twitter_bootstrap_in_frontend : 1); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('twitter_bootstrap_version', JText::_('OSM_TWITTER_BOOTSTRAP_VERSION'), JText::_('OSM_TWITTER_BOOTSTRAP_VERSION_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['twitter_bootstrap_version'];?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('hide_active_plans', JText::_('OSM_HIDE_ACTIVE_PLANS'), JText::_('OSM_HIDE_ACTIVE_PLANS_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('hide_active_plans', isset($config->hide_active_plans) ? $config->hide_active_plans : 0); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('show_price_including_tax', JText::_('OSM_SHOW_PRICE_INCLUDING_TAX'), ''); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('show_price_including_tax', $config->show_price_including_tax); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('hide_details_button', JText::_('OSM_HIDE_DETAILS_BUTTON'), JText::_('OSM_HIDE_DETAILS_BUTTON_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('hide_details_button', $config->hide_details_button); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('date_format', JText::_('OSM_DATE_FORMAT'), ''); ?>
		</div>
		<div class="controls">
			<input type="text" name="date_format" class="inputbox" value="<?php echo $this->config->date_format; ?>" size="10" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('date_field_format', JText::_('OSM_DATE_FIELD_FORMAT'), JText::_('OSM_DATE_FIELD_FORMAT_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['date_field_format']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('currency_code', JText::_('OSM_CURRENCY')); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['currency_code']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('currency_symbol', JText::_('OSM_CURRENCY_SYMBOL'), ''); ?>
		</div>
		<div class="controls">
			<input type="text" name="currency_symbol" class="inputbox" value="<?php echo $this->config->currency_symbol; ?>" size="10" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('decimals', JText::_('OSM_DECIMALS'), JText::_('OSM_DECIMALS_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="decimals" class="inputbox" value="<?php echo isset($this->config->decimals) ? $this->config->decimals : 2; ?>" size="10" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('dec_point', JText::_('OSM_DECIMAL_POINT'), JText::_('OSM_DECIMAL_POINT_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="dec_point" class="inputbox" value="<?php echo isset($this->config->dec_point) ? $this->config->dec_point : '.'; ?>" size="10" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('thousands_sep', JText::_('OSM_THOUNSANDS_SEP'), JText::_('OSM_THOUNSANDS_SEP_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="thousands_sep" class="inputbox" value="<?php echo isset($this->config->thousands_sep) ? $this->config->thousands_sep : ','; ?>" size="10" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('currency_position', JText::_('OSM_CURRENCY_POSITION'), ''); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['currency_position']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('number_columns', JText::_('OSM_NUMBER_COLUMNS_IN_COLUMNS_LAYOUT'), JText::_('OSM_NUMBER_COLUMNS_IN_COLUMNS_LAYOUT_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="number_columns" class="inputbox" value="<?php echo $this->config->number_columns ? $this->config->number_columns : 3 ; ?>" size="10" />
		</div>
	</div>
</fieldset>
