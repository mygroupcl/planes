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
	<legend class="adminform"><?php echo JText::_('OSM_UPGRADE_OPTIONS'); ?></legend>
	<table class="adminlist" style="width:100%;">
		<tr>
			<th width="60%">
				<?php echo JText::_('OSM_TO_PLAN'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('OSM_PRICE'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('OSM_PRORATED'); ?>
			</th>
			<th colspan="2">
				<?php echo JText::_('OSM_PUBLISHED'); ?>
			</th>
		</tr>
		<tbody id="upgrade-rule">
		<?php
		$options = array();
		$options[] = JHtml::_('select.option', '1', Jtext::_('OSM_YES'));
		$options[] = JHtml::_('select.option', '0', Jtext::_('OSM_NO'));

		$upgradeProratedOptions   = array();
		$upgradeProratedOptions[] = JHtml::_('select.option', '0', Jtext::_('OSM_NO'));
		$upgradeProratedOptions[] = JHtml::_('select.option', '1', Jtext::_('OSM_BY_TIME'));
		$upgradeProratedOptions[] = JHtml::_('select.option', '2', Jtext::_('OSM_BY_PRICE'));

		for ($i = 0, $n = count($this->upgradeRules); $i < $n; $i++)
		{
			$upgradeRule = $this->upgradeRules[$i];
			$optionPlans = array();
			$optionPlans[] = JHtml::_('select.option', 0, JText::_('OSM_TO_PLAN'), 'id', 'title');
			$optionPlans = array_merge($optionPlans, $this->plans);
			?>
			<tr id="rule_<?php echo $i; ?>">
				<td>
					<?php echo JHtml::_('select.genericlist', $optionPlans, 'to_plan_id[]', ' class="input-medium" ', 'id', 'title', $upgradeRule->to_plan_id);; ?>
				</td>
				<td>
					<input class="input-mini" type="text" name="upgrade_price[]" size="10" maxlength="250" value="<?php echo $upgradeRule->price?>" />
				</td>
				<td>
					<?php echo JHtml::_('select.genericlist', $upgradeProratedOptions, 'upgrade_prorated[]', ' class="input-mini"', 'value', 'text', $upgradeRule->upgrade_prorated); ?>
				</td>
				<td>
					<?php echo JHtml::_('select.genericlist', $options, 'rule_published[]', ' class="inputbox input-mini"', 'value', 'text', $upgradeRule->published); ?>
				</td>
				<td>
					<button type="button" class="btn btn-danger" onclick="removeRule(<?php echo $i; ?>)"><i class="icon-remove"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
		</tbody>
		<tfoot>
		<tr>
			<td colspan="3">
				<button id="add-rule" type="button" class="btn btn-small btn-success">
					<span class="icon-new icon-white"></span><?php echo JText::_('OSM_ADD'); ?>
				</button>
			</td>
		</tr>
		</tfoot>
	</table>
</fieldset>
