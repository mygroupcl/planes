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
			<?php echo JText::_('OSM_ADMIN_EMAIL_SUBJECT'); ?>
		</td>
		<td width="60%">
			<input type="text" name="admin_email_subject" class="input-xlarge" value="<?php echo $this->item->admin_email_subject; ?>" size="50" />
		</td>
		<td>
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_ADMIN_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'admin_email_body',  $this->item->admin_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('User email subject'); ?>
		</td>
		<td>
			<input type="text" name="user_email_subject" class="input-xlarge" value="<?php echo $this->item->user_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_USER_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'user_email_body',  $this->item->user_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_USER_EMAIL_BODY_OFFLINE_PAYMENT'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'user_email_body_offline',  $this->item->user_email_body_offline , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_SUBSCRIPTION_APPROVED_EMAIL_SUBJECT'); ?>
		</td>
		<td>
			<input type="text" name="subscription_approved_email_subject" class="input-xlarge" value="<?php echo $this->item->subscription_approved_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_SUBSCRIPTION_APPROVED_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'subscription_approved_email_body',  $this->item->subscription_approved_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong>Available Tags :[PAYMENT_DETAIL], [FORM_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [CITY], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_SUBSCRIPTION_FORM_MESSAGE'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'subscription_form_msg',  $this->item->subscription_form_msg , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_SUBSCRIPTION_FORM_MESSAGE_EXPLAIN'); ?></strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_THANK_MESSAGE'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'thanks_message',  $this->item->thanks_message , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<?php echo JText::_('OSM_THANK_MESSAGE_EXPLAIN'); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_THANK_MESSAGE_OFFLINE'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'thanks_message_offline',  $this->item->thanks_message_offline , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<?php echo JText::_('OSM_THANK_MESSAGE_OFFLINE_EXPLAIN'); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_PAYMENT_CANCEL_MESSAGE'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'cancel_message',  $this->item->cancel_message , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<?php echo JText::_('OSM_PAYMENT_CANCEL_MESSAGE_EXPLAIN'); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_PAYMENT_FAILURE_MESSAGE'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'failure_message',  $this->item->failure_message , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<?php echo JText::_('OSM_PAYMENT_FAILURE_MESSAGE_EXPLAIN'); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_PROFILE_UPDATE_EMAIL_SUBJECT'); ?>
		</td>
		<td>
			<input type="text" name="profile_update_email_subject" class="input-xlarge" value="<?php echo $this->item->profile_update_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_PROFILE_UPDATE_EMAIL_SUBJECT_EXPLAIN'); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_PROFILE_UPDATE_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'profile_update_email_body',  $this->item->profile_update_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[PROFILE_LINK], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_NEW_GROUP_MEMBER_EMAIL_SUBJECT'); ?>
		</td>
		<td>
			<input type="text" name="new_group_member_email_subject" class="input-xlarge" value="<?php echo $this->item->new_group_member_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_NEW_GROUP_MEMBER_EMAIL_SUBJECT_EXPLAIN'); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_NEW_GROUP_MEMBER_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'new_group_member_email_body',  $this->item->new_group_member_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_CONTENT_RESTRICTED_MESSAGE'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'content_restricted_message',  $this->item->content_restricted_message , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<?php echo JText::_('OSM_CONTENT_RESTRICTED_MESSAGE_EXPLAIN'); ?>
		</td>
	</tr>
</table>
