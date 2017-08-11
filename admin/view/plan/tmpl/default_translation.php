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

echo JHtml::_('bootstrap.startTabSet', 'plan-translation', array('active' => 'translation-page-'.$this->languages[0]->sef));

foreach ($this->languages as $language)
{
	$sef = $language->sef;
	echo JHtml::_('bootstrap.addTab', 'plan-translation', 'translation-page-' . $sef, $language->title . ' <img src="' . $rootUri . '/media/com_osmembership/flags/' . $sef . '.png" />');
	?>
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_TITLE'); ?>
		</div>
		<div class="controls">
			<input class="input-xlarge" type="text" name="title_<?php echo $sef; ?>" id="title_<?php echo $sef; ?>" size="" maxlength="250" value="<?php echo $this->item->{'title_'.$sef}; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_ALIAS'); ?>
		</div>
		<div class="controls">
			<input class="input-xlarge" type="text" name="alias_<?php echo $sef; ?>" id="title_<?php echo $sef; ?>" size="" maxlength="250" value="<?php echo $this->item->{'alias_'.$sef}; ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_SHORT_DESCRIPTION'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'short_description_'.$sef,  $this->item->{'short_description_'.$sef} , '100%', '250', '75', '10' ) ; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_DESCRIPTION'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'description_'.$sef,  $this->item->{'description_'.$sef} , '100%', '250', '75', '10' ) ; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_PLAN_SUBSCRIPTION_FORM_MESSAGE'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'subscription_form_message_'.$sef,  $this->item->{'subscription_form_message_'.$sef} , '100%', '250', '75', '10' ) ; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_USER_EMAIL_SUBJECT'); ?>
		</div>
		<div class="controls">
			<input type="text" name="user_email_subject_<?php echo $sef; ?>" class="inputbox" value="<?php echo $this->item->{'user_email_subject_'.$sef}; ?>" size="50" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_USER_EMAIL_BODY'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'user_email_body_'.$sef,  $this->item->{'user_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_USER_EMAIL_BODY_OFFLINE_PAYMENT'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'user_email_body_offline_'.$sef,  $this->item->{'user_email_body_offline_'.$sef} , '100%', '250', '75', '8' ) ;?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_THANK_MESSAGE'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'thanks_message_'.$sef,  $this->item->{'thanks_message_'.$sef} , '100%', '250', '75', '8' ) ;?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_THANK_MESSAGE_OFFLINE'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'thanks_message_offline_'.$sef,  $this->item->{'thanks_message_offline_'.$sef} , '100%', '250', '75', '8' ) ;?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_SUBSCRIPTION_APPROVED_EMAIL_SUBJECT'); ?>
		</div>
		<div class="controls">
			<input type="text" name="subscription_approved_email_subject_<?php echo $sef; ?>" class="inputbox" value="<?php echo $this->item->{'subscription_approved_email_subject_'.$sef}; ?>" size="50" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_SUBSCRIPTION_APPROVED_EMAIL_BODY'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'subscription_approved_email_body_'.$sef,  $this->item->{'subscription_approved_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
		</div>
	</div>

	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_RENEW_USER_EMAIL_SUBJECT'); ?>
		</div>
		<div class="controls">
			<input type="text" name="user_renew_email_subject_<?php echo $sef; ?>" class="inputbox" value="<?php echo $this->item->{'user_renew_email_subject_'.$sef}; ?>" size="50" />
		</div>
	</div>

	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_RENEW_USER_EMAIL_BODY'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'user_renew_email_body_'.$sef,  $this->item->{'user_renew_email_body_'.$sef} , '100%', '250', '75', '8' ) ;?>
		</div>
	</div>
	<?php
	echo JHtml::_('bootstrap.endTab');
}

echo JHtml::_('bootstrap.endTabSet');