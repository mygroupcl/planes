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
<table class="admintable adminform" style="width:100%;">
	<tr>
		<td class="key" width="20%">
			<?php echo JText::_('OSM_SUBSCRIPTION_RENEW_FORM_MESSAGE'); ?>
		</td>
		<td width="60%">
			<?php echo $editor->display( 'subscription_renew_form_msg',  $this->item->subscription_renew_form_msg , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_SUBSCRIPTION_RENEW_FORM_MESSAGE_EXPLAIN'); ?></strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_NENEW_ADMIN_EMAIL_SUBJECT'); ?>
		</td>
		<td>
			<input type="text" name="admin_renw_email_subject" class="input-xlarge" value="<?php echo $this->item->admin_renw_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_RENEW_ADMIN_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'admin_renew_email_body',  $this->item->admin_renew_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_RENEW_USER_EMAIL_SUBJECT'); ?>
		</td>
		<td>
			<input type="text" name="user_renew_email_subject" class="input-xlarge" value="<?php echo $this->item->user_renew_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_RENEW_USER_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'user_renew_email_body',  $this->item->user_renew_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_RENEW_USER_EMAIL_BODY_OFFLINE'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'user_renew_email_body_offline',  $this->item->user_renew_email_body_offline , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_RENEW_THANK_MESSAGE'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'renew_thanks_message',  $this->item->renew_thanks_message , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<?php echo JText::_('OSM_RENEW_THANK_MESSAGE_EXPLAIN'); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_RENEW_THANK_MESSAGE_OFFLINE'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'renew_thanks_message_offline',  $this->item->renew_thanks_message_offline , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<?php echo JText::_('OSM_RENEW_THANK_MESSAGE_OFFLINE_EXPLAIN'); ?>
		</td>
	</tr>
</table>
