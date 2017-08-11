<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
// no direct access
defined( '_JEXEC' ) or die;
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.submitbutton = function (pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			Joomla.submitform(pressbutton, form);
			return;
		}
		else
		{
			if (form.rate.value == "")
			{
				alert("<?php echo JText::_("OSM_ENTER_TAX_RATE"); ?>");
				form.rate.focus();
			}
			else
			{
				Joomla.submitform(pressbutton, form);
			}
		}
	}
</script>
<form action="index.php?option=com_osmembership&view=tax" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_PLAN'); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['plan_id']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_COUNTRY'); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['country']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_STATE'); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['state']; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_TAX_RATE'); ?>
		</div>
		<div class="controls">
			<input class="text_area" type="text" name="rate" id="rate" size="5" maxlength="250" value="<?php echo $this->item->rate;?>" />
		</div>
	</div>
	<?php
		if (isset($this->lists['vies']))
		{
		?>
		<div class="control-group">
			<div class="control-label">
				<?php echo JText::_('OSM_VIES'); ?>
			</div>
			<div class="controls">
				<?php echo $this->lists['vies'];?>
			</div>
		</div>
		<?php
		}
	?>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_PUBLISHED'); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['published']; ?>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php echo JHtml::_( 'form.token' ); ?>
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>