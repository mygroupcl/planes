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
			<?php echo JText::_('OSM_FIRST_REMINDER_EMAIL_SUBJECT'); ?>
		</td>
		<td width="60%">
			<input type="text" name="first_reminder_email_subject" class="input-xlarge" value="<?php echo $this->item->first_reminder_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [NUMBER_DAYS]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_FIRST_REMINDER_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'first_reminder_email_body',  $this->item->first_reminder_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [NUMBER_DAYS], [EXPIRE_DATE]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_SECOND_REMINDER_EMAIL_SUBJECT'); ?>
		</td>
		<td>
			<input type="text" name="second_reminder_email_subject" class="input-xlarge" value="<?php echo $this->item->second_reminder_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [NUMBER_DAYS]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_SECOND_REMINDER_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'second_reminder_email_body',  $this->item->second_reminder_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [NUMBER_DAYS], [EXPIRE_DATE]</strong>
		</td>
	</tr>

	<tr>
		<td class="key">
			<?php echo JText::_('OSM_THIRD_REMINDER_EMAIL_SUBJECT'); ?>
		</td>
		<td>
			<input type="text" name="third_reminder_email_subject" class="input-xlarge" value="<?php echo $this->item->third_reminder_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [NUMBER_DAYS]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_THIRD_REMINDER_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'third_reminder_email_body',  $this->item->third_reminder_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [NUMBER_DAYS], [EXPIRE_DATE]</strong>
		</td>
	</tr>
</table>
