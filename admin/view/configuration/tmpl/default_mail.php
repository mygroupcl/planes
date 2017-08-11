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
	<legend><?php echo JText::_('OSM_MAIL_SETTINGS'); ?></legend>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('from_name', JText::_('OSM_FROM_NAME'), JText::_('OSM_FROM_NAME_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="from_name" class="input-xlarge" value="<?php echo $config->from_name; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('from_email', JText::_('OSM_FROM_EMAIL'), JText::_('OSM_FROM_EMAIL_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="from_email" class="input-xlarge" value="<?php echo $config->from_email; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('disable_notification_to_admin', JText::_('OSM_DISABLE_NOTIFICATION_TO_ADMIN'), JText::_('OSM_DISABLE_NOTIFICATION_TO_ADMIN_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('disable_notification_to_admin', $config->disable_notification_to_admin); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('notification_emails', JText::_('OSM_NOTIFICATION_EMAILS'), JText::_('OSM_NOTIFICATION_EMAILS_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<input type="text" name="notification_emails" class="input-xlarge" value="<?php echo $config->notification_emails; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('log_email_types', JText::_('OSM_LOG_EMAIL_TYPES'), JText::_('OSM_LOG_EMAIL_TYPES_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['log_email_types']; ?>
		</div>
	</div>
</fieldset>
