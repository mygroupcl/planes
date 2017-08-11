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

JToolbarHelper::title(JText::_('OSM_IMPORT_SUBSCRIBERS_TITLE'));
JToolbarHelper::save('subscription.import');
JToolbarHelper::cancel('subscription.cancel');
?>
<form action="index.php?option=com_osmembership&view=import" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<table class="admintable adminform">
		<tr>
			<td class="key">
				<?php echo JText::_('OSM_SUBSCRIBERS_FILE'); ?>
			</td>
			<td>
				<input type="file" name="input_file" size="50" />
			</td>
			<td>
				<?php echo JText::_('OSM_SUBSCRIBERS_FILE_EXPLAIN'); ?>
			</td>
		</tr>
	</table>
	<input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>
</form>