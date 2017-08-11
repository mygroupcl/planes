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
	<legend class="adminform"><?php echo JText::_('OSM_RECURRING_SETTINGS'); ?></legend>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_RECURRING_SUBSCRIPTION'); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['recurring_subscription']; ?>
		</div>
	</div>
	<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('recurring_subscription' => '1')); ?>'>
		<div class="control-label">
			<?php echo JText::_('OSM_TRIAL_AMOUNT'); ?>
		</div>
		<div class="controls">
			<input type="text" class="inputbox" name="trial_amount" value="<?php echo $this->item->trial_amount; ?>" size="10" />
		</div>
	</div>
	<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('recurring_subscription' => '1')); ?>'>
		<div class="control-label">
			<?php echo JText::_('OSM_TRIAL_DURATION'); ?>
		</div>
		<div class="controls">
			<input type="text" class="input-mini" name="trial_duration" value="<?php echo $this->item->trial_duration > 0 ? $this->item->trial_duration : ''; ?>"/>
			<?php echo $this->lists['trial_duration_unit']; ?>
		</div>
	</div>
	<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('recurring_subscription' => '1')); ?>'>
		<div class="control-label">
			<?php echo JText::_('OSM_NUMBER_PAYMENTS'); ?>
		</div>
		<div class="controls">
			<input type="text" class="inputbox" name="number_payments" value="<?php echo $this->item->number_payments; ?>" size="10" />
		</div>
	</div>
</fieldset>
