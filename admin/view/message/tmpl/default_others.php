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
			<?php echo JText::_('OSM_CONSUMED_EMAIL_SUBJECT'); ?>
		</td>
		<td width="60%">
			<input type="text" name="consumed_email_subject" class="input-xlarge" value="<?php echo $this->item->consumed_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [NUMBER_DAYS]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_CONSUMED_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'consumed_email_body',  $this->item->consumed_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [NUMBER_DAYS], [EXPIRE_DATE]</strong>
		</td>
	</tr>
	<tr>
		<td class="key" width="20%">
			<?php echo JText::_('OSM_REACTIVE_EMAIL_SUBJECT'); ?>
		</td>
		<td width="60%">
			<input type="text" name="reactive_email_subject" class="input-xlarge" value="<?php echo $this->item->reactive_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [NUMBER_DAYS]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_REACTIVE_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'reactive_email_body',  $this->item->reactive_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [NUMBER_DAYS], [EXPIRE_DATE], [BOOKING_DATE], [SERVICE_NAME], [START_TIME], [END_TIME]</strong>
		</td>
	</tr>
	<tr>
		<td class="key" width="20%">
			<?php echo JText::_('OSM_LAST_QUOTE_EMAIL_SUBJECT'); ?>
		</td>
		<td width="60%">
			<input type="text" name="last_quote_email_subject" class="input-xlarge" value="<?php echo $this->item->last_quote_email_subject; ?>" size="50" />
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> : [PLAN_TITLE], [NUMBER_DAYS]</strong>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('OSM_LAST_QUOTE_EMAIL_BODY'); ?>
		</td>
		<td>
			<?php echo $editor->display( 'last_quote_email_body',  $this->item->last_quote_email_body , '100%', '250', '75', '8' ) ;?>
		</td>
		<td valign="top">
			<strong><?php echo JText::_('OSM_AVAILABLE_TAGS'); ?> [PLAN_TITLE], [FIRST_NAME], [LAST_NAME], [NUMBER_DAYS], [EXPIRE_DATE], [REMAINDER_QUOTAS]</strong>
		</td>
	</tr>
</table>
