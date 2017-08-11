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
JHtml::_('behavior.tooltip');
$editor = JFactory::getEditor(); 	
$translatable = JLanguageMultilang::isEnabled() && count($this->languages);

JHtml::_('formbehavior.chosen', '#basic-information-page select');

JHtml::_('behavior.tabstate');
JHtml::_('jquery.framework');
JHtml::_('script', 'jui/cms.js', false, true);
?>
<form action="index.php?option=com_osmembership&view=plan" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" class="form form-horizontal">
	<?php
	echo JHtml::_('bootstrap.startTabSet', 'plan', array('active' => 'basic-information-page'));
		echo JHtml::_('bootstrap.addTab', 'plan', 'basic-information-page', JText::_('OSM_BASIC_INFORMATION', true));
	?>
		<div class="row-fluid clearfix">
			<div class="span8 pull-left">
				<?php echo $this->loadTemplate('general', array('editor' => $editor)); ?>
			</div>
			<div class="span4 pull-left" style="display: inline;">
				<?php echo $this->loadTemplate('renew_options'); ?>
			</div>

			<div class="span4 pull-left" style="display: inline;">
				<?php echo $this->loadTemplate('upgrade_options'); ?>
			</div>

			<div class="span4 pull-left" style="display: inline;">
				<?php echo $this->loadTemplate('recurring_settings'); ?>
			</div>
			<div class="span4 pull-left" style="display: inline;">
				<?php echo $this->loadTemplate('advanced_settings'); ?>
			</div>
		</div>
	<?php
		echo JHtml::_('bootstrap.endTab');

		echo JHtml::_('bootstrap.addTab', 'plan', 'messages-page', JText::_('OSM_MESSAGES', true));
		echo $this->loadTemplate('messages', array('editor' => $editor));
		echo JHtml::_('bootstrap.endTab');

		echo JHtml::_('bootstrap.addTab', 'plan', 'reminder-messages-page', JText::_('OSM_REMINDER_MESSAGES', true));
		echo $this->loadTemplate('reminder_messages', array('editor' => $editor));
		echo JHtml::_('bootstrap.endTab');

		if ($translatable)
		{
			echo JHtml::_('bootstrap.addTab', 'plan', 'translation-page', JText::_('OSM_TRANSLATION', true));
			echo $this->loadTemplate('translation', array('editor' => $editor));
			echo JHtml::_('bootstrap.endTab');
		}

		if (count($this->plugins))
		{
			$count = 0 ;

			foreach ($this->plugins as $plugin)
			{
				$count++ ;
				echo JHtml::_('bootstrap.addTab', 'plan', 'tab_'.$count, JText::_($plugin['title'], true));
				echo $plugin['form'];
				echo JHtml::_('bootstrap.endTab');
			}
		}
	echo JHtml::_('bootstrap.endTabSet');
	?>
	<div class="clearfix"></div>
	<?php echo JHtml::_( 'form.token' ); ?>
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" id="recurring" name="recurring" value="<?php echo (int)$this->item->recurring_subscription;?>" />
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
					alert("<?php echo JText::_('OSM_ENTER_PLAN_TITLE'); ?>");
					form.title.focus();
					return ;
				}
				var lifetimeMembership = jQuery('input[name=\'lifetime_membership\']:checked').val();
				if (!form.subscription_length.value  && lifetimeMembership == 0) {
					alert("<?php echo JText::_('OSM_ENTER_SUBSCRIPTION_LENGTH'); ?>");
					form.subscription_length.focus();
					return ;
				}
				var recurringSubscription = jQuery('input[name=\'recurring_subscription\']:checked').val();
				if (recurringSubscription == 1 && form.price.value <= 0) {
					alert("<?php echo JText::_('OSM_PRICE_REQUIRED'); ?>");
					form.price.focus();
					return ;
				}
				if(jQuery('.article_checkbox').length)
				{
					jQuery('.article_checkbox').attr("checked", false);
				}
				if(jQuery('.k2_item_checkbox').length)
				{
					jQuery('.k2_item_checkbox').attr("checked", false);
				}
				Joomla.submitform(pressbutton, form);
			}
		}

		function addRow()
		{
			var table = document.getElementById('price_list');
			var newRowIndex = table.rows.length - 1 ;
			var row = table.insertRow(newRowIndex);
			var renewOptionLength = row.insertCell(0);
			var renewOptionLengthUnit             = row.insertCell(1);
			var renewPrice = row.insertCell(2);
			renewOptionLength.innerHTML = '<input type="text" class="input-small" name="renew_option_length[]" size="10" />';
			renewOptionLengthUnit.innerHTML = '<?php echo preg_replace(array('/\r/', '/\n/'), '', JHtml::_('select.genericlist', $this->renewOptionLengthUnits, 'renew_option_length_unit[]', 'class="input-medium"', 'value', 'text', 'D')); ?>';
			renewPrice.innerHTML = '<input type="text" class="input-small" name="renew_price[]" size="10" />';

		}

		function removeRow()
		{
			var table = document.getElementById('price_list');
			var deletedRowIndex = table.rows.length - 2 ;
			if (deletedRowIndex >= 1)
			{
				table.deleteRow(deletedRowIndex);
			}
			else
			{
				alert("<?php echo JText::_('OSM_NO_ROW_TO_DELETE'); ?>");
			}
		}

		(function($){
			$(document).ready(function(){
				$('.osm-waring').hide();
				if($('#recurring').val() == 1 && $('#price').val() <= 0)
					$('.osm-waring').slideDown();
				var countRuler = '<?php echo count($this->upgradeRules); ?>';
				$('#add-rule').click(function(){
					var html = '<tr id="rule_' + countRuler + '">';

					html += '<td><select class="input-medium" name="to_plan_id[]">';
					html += '<option value="0"><?php echo JText::_('OSM_TO_PLAN'); ?></option>';
					<?php
					for ($i = 0; $i < count($this->plans); $i++)
					{
						$plan = $this->plans[$i];
					?>
					html += "<option value='<?php echo $plan->id; ?>'><?php echo $plan->title; ?></option>";
					<?php
					 }
					?>
					html += '</select></td>';
					html += '<td>';
					html += '<input type="text" value=" " maxlength="250" size="10" name="upgrade_price[]" class="input-mini">';
					html += '</td>'
					html += '<td style="text-align: center; vertical-align: middle;"><select class="inputbox input-mini" name="upgrade_prorated[]">';
					html += '<option value="0" selected="selected"><?php echo JText::_('OSM_NO'); ?></option>';
					html += '<option value="1"><?php echo JText::_('OSM_BY_TIME'); ?></option>';
					html += '<option value="2"><?php echo JText::_('OSM_BY_PRICE'); ?></option>';
					html += '</select></td>';
					html += '<td style="text-align: center; vertical-align: middle;"><select class="inputbox input-mini" name="rule_published[]">';
					html += '<option value="1"><?php echo JText::_('OSM_YES'); ?></option>';
					html += '<option value="0" selected="selected"><?php echo JText::_('OSM_NO'); ?></option>';
					html += '</select></td>';
					html += '<td>';
					html += '<button type="button" class="btn btn-danger" id="rule_' + countRuler + '" onclick="removeRule('+countRuler+')"><i class="icon-remove"></i></button>';
					html += '</td>';
					html += '</tr>';
					$('#upgrade-rule').append(html);
					countRuler ++;
				});
			})
		})(jQuery)
		//remove rule plan
		function removeRule(rowIndex) {
			jQuery('#rule_'+ rowIndex).remove();
		}
	</script>
</form>