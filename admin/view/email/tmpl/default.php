<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

$config = OSMembershipHelper::getConfig();
?>
<form action="index.php?option=com_osmembership&view=email" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_SUBJECT'); ?>
		</div>
		<div class="controls">
			<?php echo $this->item->subject; ?>
		</div>
	</div>	
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_EMAIL'); ?>
		</div>
		<div class="controls">
			<?php echo $this->item->email; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_SENT_TO'); ?>
		</div>
		<div class="controls">
			<?php
				if ($this->item->sent_to == 1)
				{
					echo JText::_('OSM_ADMIN');
				}
				else
				{
					echo JText::_('OSM_SUBSCRIBER');
				}
			?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_SENT_AT'); ?>
		</div>
		<div class="controls">
			<?php echo JHtml::_('date', $this->item->sent_at, $config->date_format.' H:i'); ?>
		</div>
	</div>				
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_MESSAGE'); ?>
		</div>
		<div class="controls">
			<?php echo $this->item->body; ?>
		</div>
	</div>
	<?php echo JHtml::_( 'form.token' ); ?>
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>