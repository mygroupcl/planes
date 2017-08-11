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

echo JHtml::_('bootstrap.startTabSet', 'message-translation', array('active' => 'translation-page-'.$this->languages[0]->sef));

$rootUri = JUri::root(true);

foreach ($this->languages as $language)
{
	$sef = $language->sef;
	echo JHtml::_('bootstrap.addTab', 'message-translation', 'translation-page-' . $sef, $language->title . ' <img src="' . $rootUri . '/media/com_osmembership/flags/' . $sef . '.png" />');
	?>
	<table class="admintable adminform" style="width:100%;">
		<tr>
			<td class="key" width="20%">
				<?php echo JText::_('OSM_ADMIN_EMAIL_SUBJECT'); ?>
			</td>
			<td>
				<input type="text" name="admin_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'admin_email_subject_'.$sef}; ?>" size="50" />
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
				<?php echo $editor->display( 'admin_email_body_'.$sef,  $this->item->{'admin_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('User email subject'); ?>
			</td>
			<td>
				<input type="text" name="user_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'user_email_subject_'.$sef}; ?>" size="50" />
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_USER_EMAIL_BODY'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'user_email_body_'.$sef,  $this->item->{'user_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_USER_EMAIL_BODY_OFFLINE_PAYMENT'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'user_email_body_offline_'.$sef,  $this->item->{'user_email_body_offline_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_SUBSCRIPTION_APPROVED_EMAIL_SUBJECT'); ?>
			</td>
			<td>
				<input type="text" name="subscription_approved_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'subscription_approved_email_subject_'.$sef}; ?>" size="50" />
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_SUBSCRIPTION_APPROVED_EMAIL_BODY'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'subscription_approved_email_body_'.$sef,  $this->item->{'subscription_approved_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong>Available Tags :[PAYMENT_DETAIL], [FORM_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [CITY], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_SUBSCRIPTION_FORM_MESSAGE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'subscription_form_msg_'.$sef,  $this->item->{'subscription_form_msg_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_SUBSCRIPTION_FORM_MESSAGE_EXPLAIN'); ?></strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_THANK_MESSAGE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'thanks_message_'.$sef,  $this->item->{'thanks_message_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<?php echo JText::_('OSM_THANK_MESSAGE_EXPLAIN'); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_THANK_MESSAGE_OFFLINE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'thanks_message_offline_'.$sef,  $this->item->{'thanks_message_offline_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<?php echo JText::_('OSM_THANK_MESSAGE_OFFLINE_EXPLAIN'); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_PAYMENT_CANCEL_MESSAGE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'cancel_message_'.$sef,  $this->item->{'cancel_message_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<?php echo JText::_('OSM_PAYMENT_CANCEL_MESSAGE_EXPLAIN'); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_PAYMENT_FAILURE_MESSAGE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'failure_message_'.$sef,  $this->item->{'failure_message_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<?php echo JText::_('OSM_PAYMENT_FAILURE_MESSAGE_EXPLAIN'); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_PROFILE_UPDATE_EMAIL_SUBJECT'); ?>
			</td>
			<td>
				<input type="text" name="profile_update_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'profile_update_email_subject_'.$sef}; ?>" size="50" />
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_PROFILE_UPDATE_EMAIL_BODY'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'profile_update_email_body_'.$sef,  $this->item->{'profile_update_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_SUBSCRIPTION_RENEW_FORM_MESSAGE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'subscription_renew_form_msg_'.$sef,  $this->item->{'subscription_renew_form_msg_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_SUBSCRIPTION_RENEW_FORM_MESSAGE_EXPLAIN'); ?></strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_NENEW_ADMIN_EMAIL_SUBJECT'); ?>
			</td>
			<td>
				<input type="text" name="admin_renw_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'admin_renw_email_subject_'.$sef}; ?>" size="50" />
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_RENEW_ADMIN_EMAIL_BODY'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'admin_renew_email_body_'.$sef,  $this->item->{'admin_renew_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_RENEW_USER_EMAIL_SUBJECT'); ?>
			</td>
			<td>
				<input type="text" name="user_renew_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'user_renew_email_subject_'.$sef}; ?>" size="50" />
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_RENEW_USER_EMAIL_BODY'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'user_renew_email_body_'.$sef,  $this->item->{'user_renew_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_RENEW_USER_EMAIL_BODY_OFFLINE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'user_renew_email_body_offline_'.$sef,  $this->item->{'user_renew_email_body_offline_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
			</td>
		</tr>

		<tr>
			<td class="key">
				<?php echo JText::_('OSM_RENEW_THANK_MESSAGE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'renew_thanks_message_'.$sef,  $this->item->{'renew_thanks_message_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<?php echo JText::_('OSM_RENEW_THANK_MESSAGE_EXPLAIN'); ?>
			</td>
		</tr>

		<tr>
			<td class="key">
				<?php echo JText::_('OSM_RENEW_THANK_MESSAGE_OFFLINE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'renew_thanks_message_offline_'.$sef,  $this->item->{'renew_thanks_message_offline_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<?php echo JText::_('OSM_RENEW_THANK_MESSAGE_OFFLINE_EXPLAIN'); ?>
			</td>
		</tr>

		<tr>
			<td class="key">
				<?php echo JText::_('OSM_SUBSCRIPTION_UPGRADE_FORM_MESSAGE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'subscription_upgrade_form_msg_'.$sef,  $this->item->{'subscription_upgrade_form_msg_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_SUBSCRIPTION_UPGRADE_FORM_MESSAGE_EXPLAIN'); ?></strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_UPGRADE_ADMIN_EMAIL_SUBJECT'); ?>
			</td>
			<td>
				<input type="text" name="admin_upgrade_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'admin_upgrade_email_subject_'.$sef}; ?>" size="50" />
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [TO_PLAN_TITLE]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_UPGRADE_ADMIN_EMAIL_BODY'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'admin_upgrade_email_body_'.$sef,  $this->item->{'admin_upgrade_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_UPGRADE_USER_EMAIL_SUBJECT'); ?>
			</td>
			<td>
				<input type="text" name="user_upgrade_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'user_upgrade_email_subject_'.$sef}; ?>" size="50" />
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [TO_PLAN_TITLE]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_UPGRADE_USER_EMAIL_BODY'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'user_upgrade_email_body_'.$sef,  $this->item->{'user_upgrade_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> :[SUBSCRIPTION_DETAIL], [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [ORGANIZATION], [ADDRESS], [ADDRESS2], [CITY], [STATE], [ZIP], [COUNTRY], [PHONE], [FAX], [EMAIL], [COMMENT], [AMOUNT], [TRANSACTION_ID], [PAYMENT_METHOD]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_UPGRADE_THANK_MESSAGE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'upgrade_thanks_message_'.$sef,  $this->item->{'upgrade_thanks_message_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<?php echo JText::_('OSM_UPGRADE_THANK_MESSAGE_EXPLAIN'); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_FIRST_REMINDER_EMAIL_SUBJECT'); ?>
			</td>
			<td>
				<input type="text" name="first_reminder_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'first_reminder_email_subject_'.$sef}; ?>" size="50" />
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [NUMBER_DAYS]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_FIRST_REMINDER_EMAIL_BODY'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'first_reminder_email_body_'.$sef,  $this->item->{'first_reminder_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [NUMBER_DAYS], [EXPIRE_DATE]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_SECOND_REMINDER_EMAIL_SUBJECT'); ?>
			</td>
			<td>
				<input type="text" name="second_reminder_email_subject_<?php echo $sef; ?>" class="input-xlarge" value="<?php echo $this->item->{'second_reminder_email_subject_'.$sef}; ?>" size="50" />
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [NUMBER_DAYS]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_SECOND_REMINDER_EMAIL_BODY'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'second_reminder_email_body_'.$sef,  $this->item->{'second_reminder_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [NUMBER_DAYS], [EXPIRE_DATE]</strong>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_CONTENT_RESTRICTED_MESSAGE'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'content_restricted_message_'.$sef,  $this->item->{'content_restricted_message_'.$sef} , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				<?php echo JText::_('OSM_CONTENT_RESTRICTED_MESSAGE_EXPLAIN'); ?>
			</td>
		</tr>
	</table>
	<?php
	echo JHtml::_('bootstrap.endTab');
}

echo JHtml::_('bootstrap.endTabSet');