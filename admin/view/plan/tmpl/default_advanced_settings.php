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
<fieldset class="adminform">
	<legend class="adminform"><?php echo JText::_('OSM_ADVANCED_SETTINGS'); ?></legend>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('setup_fee', JText::_('OSM_SETUP_FEE'), JText::_('OSM_SETUP_FEE_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" class="input-small" name="setup_fee" id="setup_fee" value="<?php echo $this->item->setup_fee; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('number_group_members', JText::_('PLG_GRM_MAX_NUMBER_MEMBERS'), JText::_('PLG_GRM_MAX_NUMBER_MEMBERS_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" class="input-small" name="number_group_members" id="number_group_members" value="<?php echo $this->item->number_group_members; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('login_redirect_menu_id', JText::_('OSM_LOGIN_REDIRECT'), JText::_('OSM_LOGIN_REDIRECT_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['login_redirect_menu_id']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('payment_methods', JText::_('OSM_PAYMENT_METHODS'), JText::_('OSM_PAYMENT_METHODS_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['payment_methods'];?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('currency_code', JText::_('OSM_CURRENCY'), JText::_('OSM_CURRENCY_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['currency'];?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('currency_symbol', JText::_('OSM_CURRENCY_SYMBOL'), JText::_('OSM_CURRENCY_SYMBOL_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" class="input-small" name="currency_symbol" id="currency_symbol" value="<?php echo $this->item->currency_symbol; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_SUBSCRIPTION_COMPLETE_URL'); ?>
		</div>
		<div class="controls">
			<input type="text" class="inputbox" name="subscription_complete_url" value="<?php echo $this->item->subscription_complete_url; ?>" size="50" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('notification_emails', JText::_('OSM_NOTIFICATION_EMAILS'), JText::_('OSM_NOTIFICATION_EMAILS_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" class="input-xlarge" name="notification_emails" value="<?php echo $this->item->notification_emails; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('paypal_email', JText::_('OSM_PAYPAL_EMAIL'), JText::_('OSM_PAYPAL_EMAIL_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" class="inputbox" name="paypal_email" value="<?php echo $this->item->paypal_email; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_TERMS_AND_CONDITIONS_ARTICLE') ; ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getArticleInput($this->item->terms_and_conditions_article_id, 'terms_and_conditions_article_id'); ?>
		</div>
	</div>
</fieldset>
