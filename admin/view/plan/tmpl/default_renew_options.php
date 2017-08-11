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
	<legend class="adminform"><?php echo JText::_('OSM_RENEW_OPTIONS'); ?></legend>
	<table class="adminlist" id="price_list">
		<tr>
			<th>
				<?php echo JText::_('OSM_RENEW_OPTION_LENGTH'); ?>
			</th>
			<th>
				<?php echo JText::_('OSM_RENEW_OPTION_UNIT'); ?>
			</th>
			<th>
				<?php echo JText::_('OSM_PRICE'); ?>
			</th>
		</tr>
		<?php
		$n = max(count($this->prices), 3);
		for ($i = 0 ; $i < $n ; $i++)
		{
			if (isset($this->prices[$i]))
			{
				$price                 = $this->prices[$i];
				$renewOptionLength     = $price->renew_option_length;
				$renewOptionLengthUnit = $price->renew_option_length_unit;
				$renewPrice            = $price->price;
			}
			else
			{
				$renewOptionLength     = null;
				$renewOptionLengthUnit = null;
				$renewPrice            = null;
			}
			?>
			<tr>
				<td>
					<input type="text" class="input-small" name="renew_option_length[]" size="10" value="<?php echo $renewOptionLength; ?>" />
				</td>
				<td>
					<?php echo JHtml::_('select.genericlist', $this->renewOptionLengthUnits, 'renew_option_length_unit[]', 'class="input-medium"', 'value', 'text', $renewOptionLengthUnit);  ?>
				</td>
				<td>
					<input type="text" class="input-small" name="renew_price[]" size="10" value="<?php echo $renewPrice; ?>" />
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="2">
				<button type="button" class="btn btn-success" onclick="addRow();"><i class="icon-new icon-white"></i><?php echo JText::_('OSM_ADD'); ?></button>
				<button type="button" class="btn btn-danger" onclick="removeRow();"><i class="icon-remove"></i><?php echo JText::_('OSM_REMOVE'); ?></button>
			</td>
		</tr>
	</table>
</fieldset>
