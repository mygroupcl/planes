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
?>
<form action="index.php?option=com_osmembership&view=country" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_COUNTRY_NAME'); ?>
		</div>
		<div class="controls">
			<input class="text_area" type="text" name="name" id="name" size="40" maxlength="250" value="<?php echo $this->item->name;?>" />
		</div>
	</div>	
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_COUNTRY_CODE_3'); ?>
		</div>
		<div class="controls">
			<input class="text_area" type="text" name="country_3_code" id="country_3_code" maxlength="250" value="<?php echo $this->item->country_3_code;?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_COUNTRY_CODE_2'); ?>
		</div>
		<div class="controls">
			<input class="text_area" type="text" name="country_2_code" id="country_2_code" maxlength="250" value="<?php echo $this->item->country_2_code;?>" />
		</div>
	</div>				
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_PUBLISHED'); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['published']; ?>
		</div>
	</div>
	<?php echo JHtml::_( 'form.token' ); ?>
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>