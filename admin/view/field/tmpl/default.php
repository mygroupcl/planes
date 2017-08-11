<?php
/**
 * @package        Joomla
 * @subpackage     OSMembership
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die;
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('jquery.framework');
JHtml::_('script', 'jui/cms.js', false, true);

JHtml::_('bootstrap.tooltip');
$document = JFactory::getDocument();
$document->addStyleDeclaration(".hasTip{display:block !important}");

$translatable = JLanguageMultilang::isEnabled() && count($this->languages);

if ($translatable)
{
	JHtml::_('behavior.tabstate');
}
?>
<script type="text/javascript">
	Joomla.submitbutton = function(pressbutton)
	{
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			Joomla.submitform(pressbutton, form);
		} else {
			if (form.name.value == "") {
				alert('<?php echo JText::_('OSM_ENTER_CUSTOM_FIELD_NAME'); ?>');
				form.name.focus();
				return ;
			}
			if (form.title.value == "") {
				alert("<?php echo JText::_("OSM_ENTER_CUSTOM_FIELD_TITLE"); ?>");
				form.title.focus();
				return ;
			}
			if (form.fieldtype.value == -1) {
				alert("<?php echo JText::_("OSM_CHOOSE_CUSTOM_FIELD_TYPE") ; ?>");
				return ;
			}
			//Validate the entered data before submitting
			Joomla.submitform(pressbutton, form);
		}
	}
</script>
<form action="index.php?option=com_osmembership&view=field" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
<?php
	if ($translatable)
	{
		echo JHtml::_('bootstrap.startTabSet', 'field', array('active' => 'general-page'));
		echo JHtml::_('bootstrap.addTab', 'field', 'general-page', JText::_('OSM_GENERAL', true));
	}
?>
	<div class="span6">
		<fieldset class="form-horizontal">
			<legend><?php echo JText::_('OSM_BASIC'); ?></legend>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_PLAN'); ?>
				</div>
				<div class="controls">
					<?php echo $this->lists['plan_id'] ; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('name', JText::_('OSM_NAME'), JText::_('OSM_FIELD_NAME_REQUIREMNET')); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="name" id="name" size="50" maxlength="250" value="<?php echo $this->item->name;?>" onchange="checkFieldName();" <?php if ($this->item->is_core) echo 'readonly="readonly"' ; ?> />
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo  JText::_('OSM_TITLE'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="title" id="title" size="50" maxlength="250" value="<?php echo $this->item->title;?>" />
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
					<?php echo JText::_('OSM_REQUIRED'); ?>
				</div>
				<div class="controls">
					<?php echo $this->lists['required']; ?>
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
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_DATATYPE_VALIDATION') ; ?>
				</div>
				<div class="controls">
					<?php echo $this->lists['datatype_validation']; ?>
				</div>
			</div>

			<div class="control-group validation-rules">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('validation_rules', JText::_('OSM_VALIDATION_RULES'), JText::_('OSM_VALIDATION_RULES_EXPLAIN')); ?>
				</div>
				<div class="controls">
					<input type="text" class="inputbox" size="50" name="validation_rules" value="<?php echo $this->item->validation_rules ; ?>" />
				</div>
			</div>

			<div class="control-group validation-rules">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('validation_error_message', JText::_('OSM_VALIDATION_ERROR_MESSAGE'), JText::_('OSM_VALIDATION_ERROR_MESSAGE_EXPLAIN')); ?>
				</div>
				<div class="controls">
					<input type="text" class="input-xlarge" size="50" name="validation_error_message" value="<?php echo $this->item->validation_error_message ; ?>" />
				</div>
			</div>
			<?php
			if (isset($this->lists['field_mapping']))
			{
				?>
				<div class="control-group">
					<div class="control-label">
						<?php echo OSMembershipHelperHtml::getFieldLabel('field_mapping', JText::_('OSM_FIELD_MAPPING'), JText::_('OSM_FIELD_MAPPING_GUIDE')); ?>
					</div>
					<div class="controls">
						<?php echo $this->lists['field_mapping'] ; ?>
					</div>
				</div>
				<?php
			}
			if (JPluginHelper::isEnabled('osmembership', 'userprofile'))
			{
				?>
				<div class="control-group">
					<div class="control-label">
						<?php echo OSMembershipHelperHtml::getFieldLabel('profile_field_mapping', JText::_('OSM_PROFILE_FIELD_MAPPING'), JText::_('OSM_PROFILE_FIELD_MAPPING_GUIDE')); ?>
					</div>
					<div class="controls">
						<?php echo $this->lists['profile_field_mapping'] ; ?>
					</div>
				</div>
				<?php
			}
			?>
			<div class="control-group">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('show_on_members_list', JText::_('OSM_SHOW_ON_MEMBER_LIST'), JText::_('OSM_SHOW_ON_MEMBER_LIST_EXPLAIN')); ?>
				</div>
				<div class="controls">
					<?php echo $this->lists['show_on_members_list']; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('hide_on_membership_renewal', JText::_('OSM_HIDE_ON_MEMBERSHIP_RENEWAL'), JText::_('OSM_HIDE_ON_MEMBERSHIP_RENEWAL_EXPLAIN')); ?>
				</div>
				<div class="controls">
					<?php echo $this->lists['hide_on_membership_renewal']; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('hide_on_email', JText::_('OSM_HIDE_ON_EMAIL'), JText::_('OSM_HIDE_ON_EMAIL_EXPLAIN')); ?>
				</div>
				<div class="controls">
					<?php echo $this->lists['hide_on_email']; ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('hide_on_export', JText::_('OSM_HIDE_ON_EXPORT'), JText::_('OSM_HIDE_ON_EXPORT_EXPLAIN')); ?>
				</div>
				<div class="controls">
					<?php echo $this->lists['hide_on_export']; ?>
				</div>
			</div>
			<?php
			if (JPluginHelper::isEnabled('osmembership', 'groupmembership'))
			{
			?>
				<div class="control-group">
					<div class="control-label">
						<?php echo OSMembershipHelperHtml::getFieldLabel('populate_from_group_admin', JText::_('OSM_POPULATE_FROM_GROUP_ADMIN'), JText::_('OSM_POPULATE_FROM_GROUP_ADMIN_EXPLAIN')); ?>
					</div>
					<div class="controls">
						<?php echo OSMembershipHelperHtml::getBooleanInput('populate_from_group_admin', $this->item->populate_from_group_admin); ?>
					</div>
				</div>
			<?php
			}
			?>
			<div class="control-group">
				<div class="control-label">
					<?php echo  JText::_('OSM_EXTRA'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="extra" id="extra" size="40" maxlength="250" value="<?php echo $this->escape($this->item->extra);?>" />
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_DESCRIPTION'); ?>
				</div>
				<div class="controls">
					<textarea rows="7" cols="50" name="description" class="input-xlarge"><?php echo $this->item->description;?></textarea>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span6">
		<fieldset class="form-horizontal">
			<legend><?php echo JText::_('OSM_FIELD_SETTINGS'); ?></legend>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_FIELD_TYPE'); ?>
				</div>
				<div class="controls">
					<?php echo $this->lists['fieldtype']; ?>
				</div>
			</div>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => 'List')); ?>'>
				<div class="control-label">
					<?php echo JText::_('OSM_MULTIPLE'); ?>
				</div>
				<div class="controls">
					<?php echo $this->lists['multiple']; ?>
				</div>
			</div>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => array('List', 'Checkboxes', 'Radio'))); ?>'>
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('values', JText::_('OSM_VALUES'), JText::_('OSM_EACH_ITEM_IN_ONELINE')); ?>
				</div>
				<div class="controls">
					<textarea rows="5" cols="50" name="values"><?php echo $this->item->values; ?></textarea>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('default_values', JText::_('OSM_DEFAULT_VALUES'), JText::_('OSM_EACH_ITEM_IN_ONELINE')); ?>
				</div>
				<div class="controls">
					<textarea rows="5" cols="50" name="default_values"><?php echo $this->item->default_values; ?></textarea>
				</div>
			</div>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => array('Text', 'List', 'Checkboxes', 'Radio'))); ?>'>
				<div class="control-label"><?php echo JText::_('OSM_FEE_FIELD') ; ?></div>
				<div class="controls">
					<?php echo $this->lists['fee_field']; ?>
				</div>
			</div>
			<?php
				$showOnData = array(
					'fieldtype' => array('List', 'Checkboxes', 'Radio'),
					'fee_field' => '1'
				);
			?>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon($showOnData); ?>'>
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('fee_values', JText::_('OSM_FEE_VALUES'), JText::_('OSM_EACH_ITEM_IN_ONELINE')); ?>
				</div>
				<div class="controls">
					<textarea rows="5" cols="50" name="fee_values"><?php echo $this->item->fee_values; ?></textarea>
				</div>
			</div>
			<?php
				$showOnData = array(
					'fieldtype' => array('Text', 'List', 'Checkboxes', 'Radio'),
					'fee_field' => '1'
				);
			?>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon($showOnData); ?>'>
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('fee_formula', JText::_('OSM_FEE_FORMULA'), JText::_('OSM_FEE_FORMULA_EXPLAIN')); ?>
				</div>
				<div class="controls">
					<input type="text" class="inputbox" size="50" name="fee_formula" value="<?php echo $this->item->fee_formula ; ?>" />
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_DEPEND_ON_FIELD');?>
				</div>
				<div class="controls">
					<?php echo $this->lists['depend_on_field_id']; ?>
				</div>
			</div>
			<div class="control-group" id="depend_on_options_container" style="display: <?php echo $this->item->depend_on_field_id ? '' : 'none'; ?>">
				<div class="control-label">
					<?php echo JText::_('OSM_DEPEND_ON_OPTIONS');?>
				</div>
				<div class="controls" id="options_container" >
					<?php
					if (count($this->dependOptions))
					{
						?>
						<table cellspacing="3" cellpadding="3" width="100%">
							<?php
							$optionsPerLine = 3;
							for ($i = 0 , $n = count($this->dependOptions) ; $i < $n ; $i++)
							{
								$value = $this->dependOptions[$i] ;
								if ($i % $optionsPerLine == 0) {
									?>
									<tr>
									<?php
								}
								?>
								<td>
									<input class="inputbox" value="<?php echo $value; ?>" type="checkbox" name="depend_on_options[]" <?php if (in_array($value, $this->dependOnOptions)) echo 'checked="checked"'; ?>><?php echo $value;?>
								</td>
								<?php
								if (($i+1) % $optionsPerLine == 0)
								{
									?>
									</tr>
									<?php
								}
							}
							if ($i % $optionsPerLine != 0)
							{
								$colspan = $optionsPerLine - $i % $optionsPerLine ;
								?>
									<td colspan="<?php echo $colspan; ?>">&nbsp;</td>
									</tr>
								<?php
							}
							?>
						</table>
						<?php
					}
					?>
				</div>				
			</div>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => array('List', 'Checkboxes', 'Radio'))); ?>' style="margin-top:10px;">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('joomla_group_ids', JText::_('OSM_JOOMLA_GROUP_IDS'), JText::_('OSM_JOOMLA_GROUP_IDS_EXPLAINS')); ?>
				</div>
				<div class="controls">
					<textarea rows="5" cols="50" name="joomla_group_ids"><?php echo $this->item->joomla_group_ids; ?></textarea>
				</div>
			</div>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => array('List', 'Radio'))); ?>' style="margin-top:10px;">
				<div class="control-label">
					<?php echo OSMembershipHelperHtml::getFieldLabel('modify_subscription_duration', JText::_('OSM_MODIFY_SUBSCRIPTION_DURATION'), JText::_('OSM_MODIFY_SUBSCRIPTION_DURATION_EXPLAINS')); ?>
				</div>
				<div class="controls">
					<textarea rows="5" cols="50" name="modify_subscription_duration"><?php echo $this->item->modify_subscription_duration; ?></textarea>
				</div>
			</div>
		</fieldset>
		<fieldset class="form-horizontal">
			<legend><?php echo JText::_('OSM_DISPLAY_SETTINGS'); ?></legend>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => array('Textarea'))); ?>'>
				<div class="control-label">
					<?php echo  JText::_('OSM_ROWS'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="rows" id="rows" size="10" maxlength="250" value="<?php echo $this->item->rows;?>" />
				</div>
			</div>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => array('Textarea'))); ?>'>
				<div class="control-label">
					<?php echo  JText::_('OSM_COLS'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="cols" id="cols" size="10" maxlength="250" value="<?php echo $this->item->cols;?>" />
				</div>
			</div>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => array('Text', 'Checkboxes', 'Radio'))); ?>'>
				<div class="control-label">
					<?php echo  JText::_('OSM_SIZE'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="size" id="size" size="10" maxlength="250" value="<?php echo $this->item->size;?>" />
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo  JText::_('OSM_CSS_CLASS'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="css_class" id="css_class" size="10" maxlength="250" value="<?php echo $this->item->css_class;?>" />
				</div>
			</div>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => array('Text', 'Textarea'))); ?>'>
				<div class="control-label">
					<?php echo  JText::_('OSM_PLACE_HOLDER'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="place_holder" id="place_holder" size="50" maxlength="250" value="<?php echo $this->item->place_holder;?>" />
				</div>
			</div>
			<div class="control-group" data-showon='<?php echo OSMembershipHelperHtml::renderShowon(array('fieldtype' => array('Text', 'Textarea'))); ?>'>
				<div class="control-label">
					<?php echo  JText::_('OSM_MAX_LENGTH'); ?>
				</div>
				<div class="controls">
					<input class="text_area" type="text" name="max_length" id="max_lenth" size="50" maxlength="250" value="<?php echo $this->item->max_length;?>" />
				</div>
			</div>
		</fieldset>
	</div>
	<?php
	if ($translatable)
	{
		echo JHtml::_('bootstrap.endTab');
		echo JHtml::_('bootstrap.addTab', 'field', 'translation-page', JText::_('OSM_TRANSLATION', true));
		echo JHtml::_('bootstrap.startTabSet', 'field-translation', array('active' => 'translation-page-'.$this->languages[0]->sef));
		$rootUri = JUri::root(true);
		foreach ($this->languages as $language)
		{
			$sef = $language->sef;
			echo JHtml::_('bootstrap.addTab', 'field-translation', 'translation-page-' . $sef, $language->title . ' <img src="' . $rootUri . '/media/com_osmembership/flags/' . $sef . '.png" />');
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
					<?php echo JText::_('OSM_DESCRIPTION'); ?>
				</div>
				<div class="controls">
					<textarea rows="5" cols="50" name="description_<?php echo $sef; ?>"><?php echo $this->item->{'description_'.$sef};?></textarea>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_VALUES'); ?>
				</div>
				<div class="controls">
					<textarea rows="5" cols="50" name="values_<?php echo $sef; ?>"><?php echo $this->item->{'values_'.$sef}; ?></textarea>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_DEFAULT_VALUES'); ?>
				</div>
				<div class="controls">
					<textarea rows="5" cols="50" name="default_values_<?php echo $sef; ?>"><?php echo $this->item->{'default_values_'.$sef}; ?></textarea>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_('OSM_FEE_VALUES'); ?>
				</div>
				<div class="controls">
					<textarea rows="5" cols="50" name="fee_values_<?php echo $sef; ?>"><?php echo $this->item->{'fee_values_'.$sef}; ?></textarea>
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
	<div class="clearfix"></div>
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_( 'form.token' ); ?>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				var validateEngine = <?php  echo OSMembershipHelper::validateEngine(); ?>;
				$("input[name='required']").bind( "click", function() {
					validateRules();
				});

				$( "#datatype_validation" ).bind( "change", function() {
					validateRules();
				});

				function validateRules()
				{
					var validationString;
					if ($("input[name='name']").val() == 'email')
					{
						//Hardcode the validation rule for email
						validationString = 'validate[required,custom[email],ajax[ajaxEmailCall]]';
					}
					else
					{
						var validateType = parseInt($('#datatype_validation').val());
						validationString = validateEngine[validateType];
						var required = $("input[name='required']:checked").val();
						if (required == 1)
						{
							if (validationString == '')
							{
								validationString = 'validate[required]';
							}
							else
							{
								if (validationString.indexOf('required') == -1)
								{
									validationString = [validationString.slice(0, 9), 'required,', validationString.slice(9)].join('');
								}
							}
						}
						else
						{
							if (validationString == 'validate[required]')
							{
								validationString = '';
							}
							else
							{
								validationString = validationString.replace('validate[required', 'validate[');
							}
						}
					}

					$("input[name='validation_rules']").val(validationString);
				}
			});
		})(jQuery);
		function checkFieldName() {
			var form = document.adminForm ;
			var name = form.name.value ;
			var oldValue = name ;
			name = name.replace('osm_', '');
			while(name.indexOf('  ') >=0)
				name = name.replace('  ', ' ');
			while(name.indexOf(' ') >=0)
				name = name.replace(' ', '_');
			name = name.replace(/[^a-zA-Z0-9_]*/ig, '');
			form.name.value='osm_' + name;
		}

		(function($){
			updateDependOnOptions = (function()
			{
				var siteUrl = "<?php echo JUri::base(); ?>";
				var fieldId = $('#depend_on_field_id').val();
				if (fieldId > 0) {
					$.ajax({
						type: 'POST',
						url: siteUrl + 'index.php?option=com_osmembership&view=field&format=raw&field_id=' + fieldId,
						dataType: 'html',
						success: function(msg, textStatus, xhr) {
							$('#options_container').html(msg);
							$('#depend_on_options_container').show();
						},
						error: function(jqXHR, textStatus, errorThrown) {
							alert(textStatus);
						}
					});

				}
				else
				{
					$('#options_container').html('');
					$('#depend_on_options_container').hide();
				}
			});
		})(jQuery);
	</script>
</form>