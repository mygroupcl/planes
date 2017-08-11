<?php 
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */

JHtml::_('behavior.tooltip');
JHtml::_('formbehavior.chosen', 'select');
?>
<form action="index.php?option=com_osmembership&view=plugin" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
<div class="row-fluid">
	<div class="span7">
		<fieldset class="adminform">
			<legend><?php echo JText::_('OSM_PLUGIN_DETAIL'); ?></legend>
			<div class="control-group">
				<div class="control-label">
					<?php echo  JText::_('OSM_NAME'); ?>
				</div>
				<div class="controls">
					<?php echo $this->item->name ; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo  JText::_('OSM_TITLE'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="title" id="title" size="40" maxlength="250" value="<?php echo $this->item->title;?>" />
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_AUTHOR'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="author" id="author" size="40" maxlength="250" value="<?php echo $this->item->author;?>" />
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_CREATION_DATE'); ?>
				</div>
				<div class="controls">
					<?php echo $this->item->creation_date; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_COPYRIGHT') ; ?>
				</div>
				<div class="controls">
					<?php echo $this->item->copyright; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_LICENSE'); ?>
				</div>
				<div class="controls">
					<?php echo $this->item->license; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_AUTHOR_EMAIL'); ?>
				</div>
				<div class="controls">
					<?php echo $this->item->author_email; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_AUTHOR_URL'); ?>
				</div>
				<div class="controls">
					<?php echo $this->item->author_url; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_VERSION'); ?>
				</div>
				<div class="controls">
					<?php echo $this->item->version; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_DESCRIPTION'); ?>
				</div>
				<div class="controls">
					<?php echo $this->item->description; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_ACCESS'); ?>
				</div>
				<div class="controls">
					<?php
						echo $this->lists['access'];
					?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('Published'); ?>
				</div>
				<div class="controls">
					<?php
						echo $this->lists['published'];
					?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span5">
		<fieldset class="adminform">
			<legend><?php echo JText::_('OSM_PLUGIN_PARAMETERS'); ?></legend>
			<?php
				foreach ($this->form->getFieldset('basic') as $field)
				{
				?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $field->label ;?>
					</div>
					<div class="controls">
						<?php echo  $field->input ; ?>
					</div>
				</div>
			<?php
				}
			?>
		</fieldset>
	</div>
</div>		
	<div class="clearfix"></div>
	<?php echo JHtml::_( 'form.token' ); ?>
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>