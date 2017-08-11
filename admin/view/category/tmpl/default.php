<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die ;
$editor = JFactory::getEditor();
$translatable = JLanguageMultilang::isEnabled() && count($this->languages);

if ($translatable)
{
	JHtml::_('behavior.tabstate');
}

JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(pressbutton)
	{
		var form = document.adminForm;
		if (pressbutton == 'cancel')
		{
			Joomla.submitform(pressbutton, form);
		}
		else
		{
			//Validate the entered data before submitting
			if (form.title.value == '') {
				alert("<?php echo JText::_('OSM_ENTER_CATEGORY_TITLE'); ?>");
				form.title.focus();
				return ;
			}
			Joomla.submitform(pressbutton, form);
		}
	}
</script>
<form action="index.php?option=com_osmembership&view=category" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
<?php
	if ($translatable)
	{
		echo JHtml::_('bootstrap.startTabSet', 'category', array('active' => 'general-page'));
		echo JHtml::_('bootstrap.addTab', 'category', 'general-page', JText::_('OSM_GENERAL', true));
	}
?>
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
			<?php echo  JText::_('OSM_ALIAS'); ?>
		</div>
		<div class="controls">
			<input class="text_area" type="text" name="alias" id="alias" size="40" maxlength="250" value="<?php echo $this->item->alias;?>" />
		</div>
	</div>

	<div class="control-group">
		<div class="control-label">
			<?php echo  JText::_('OSM_PARENT_CATEGORY'); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::buildCategoryDropdown($this->item->parent_id); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo OSMembershipHelperHtml::getFieldLabel('exclusive_plans', JText::_('OSM_EXCLUSIVE_PLANS'), JText::_('OSM_EXCLUSIVE_PLANS_EXPLAIN')); ?>
		</div>
		<div class="controls">
			<?php echo OSMembershipHelperHtml::getBooleanInput('exclusive_plans', $this->item->exclusive_plans); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_DESCRIPTION'); ?>
		</div>
		<div class="controls">
			<?php echo $editor->display( 'description',  $this->item->description , '100%', '250', '75', '10' ) ; ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo JText::_('OSM_ACCESS'); ?>
		</div>
		<div class="controls">
			<?php echo $this->lists['access']; ?>
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
	<?php
	if ($translatable)
	{
		echo JHtml::_('bootstrap.endTab');
		echo JHtml::_('bootstrap.addTab', 'category', 'translation-page', JText::_('OSM_TRANSLATION', true));
		echo JHtml::_('bootstrap.startTabSet', 'category-translation', array('active' => 'translation-page-'.$this->languages[0]->sef));
		$rootUri = JUri::root(true);
		foreach ($this->languages as $language)
		{
			$sef = $language->sef;
			echo JHtml::_('bootstrap.addTab', 'category-translation', 'translation-page-' . $sef, $language->title . ' <img src="' . $rootUri . '/media/com_osmembership/flags/' . $sef . '.png" />');
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
					<input class="input-xlarge" type="text" name="alias_<?php echo $sef; ?>" id="alias_<?php echo $sef; ?>" size="" maxlength="250" value="<?php echo $this->item->{'alias_'.$sef}; ?>" />
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
		<?php
			echo JHtml::_('bootstrap.endTab');
		}
		echo JHtml::_('bootstrap.endTabSet');
		echo JHtml::_('bootstrap.endTab');
		echo JHtml::_('bootstrap.endTabSet');
	}
	?>
	<?php echo JHtml::_( 'form.token' ); ?>
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>