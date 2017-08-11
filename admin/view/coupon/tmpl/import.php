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
JToolbarHelper::title(JText::_('OSM_IMPORT_COUPONS_TITLE'));
JToolbarHelper::custom('coupon.import', 'upload', 'upload', 'Import Coupons', false);
JToolbarHelper::cancel('coupon.cancel');
?>
<form action="index.php?option=com_osmembership&view=coupon&layout=import" method="post" name="adminForm" id="adminForm"
      enctype="multipart/form-data">
	<table class="admintable adminform">
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_COUPON_FILE'); ?>
			</td>
			<td>
				<input type="file" name="input_file" size="50"/>
			</td>
			<td>
				<?php echo JText::_('OSM_COUPON_FILE_EXPLAIN'); ?>
			</td>
		</tr>
	</table>
	<input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>
</form>