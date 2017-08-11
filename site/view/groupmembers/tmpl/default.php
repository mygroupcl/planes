<?php
/**
 * @package        Joomla
 * @subpackage     OSMembership
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die;
$fields = $this->fields;
$cols = count($fields) + 2;
?>
<div id="osm-subscription-history" class="osm-container row-fluid">
	<div class="page-header">
		<h1 class="osm-page-title">
			<?php
			echo JText::_('OSM_GROUP_MEMBERS_LIST') ;

			if ($this->canManage == 2)
			{
			?>
				<span class="osm-add-group-member_link pull-right"><a href="<?php echo JRoute::_('index.php?option=com_osmembership&view=groupmember&Itemid='. OSMembershipHelperRoute::findView('groupmember', $this->Itemid)); ?>"><?php echo JText::_('OSM_ADD_NEW_GROUP_MEMBER'); ?></a></span>
			<?php
			}
			?>
		</h1>
	</div>
<form method="post" name=os_form id="os_form" action="<?php echo JRoute::_('index.php?option=com_osmembership&view=groupmembers&Itemid='.$this->Itemid); ?>">
	<fieldset class="filters btn-toolbar clearfix">
		<div class="filter-search btn-group pull-left">
			<label for="filter_search" class="element-invisible"><?php echo JText::_('OSM_FILTER_SEARCH_SUBSCRIPTIONS_DESC');?></label>
			<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->filter_search); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('OSM_SEARCH_SUBSCRIPTIONS_DESC'); ?>" />
		</div>
		<div class="btn-group pull-left">
			<button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><span class="icon-search"></span></button>
			<button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><span class="icon-remove"></span></button>
		</div>
	</fieldset>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th><?php echo JText::_('OSM_PLAN'); ?></th>
				<?php
					foreach($fields as $field)
					{
					?>
						<th><?php echo $field->title; ?></th>
					<?php
					}
				?>
				<th class="center">
					<?php echo JText::_('OSM_CREATED_DATE') ; ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php
			for ($i = 0 , $n = count($this->items) ; $i < $n ; $i++)
			{
				$row = $this->items[$i];
				$link = JRoute::_('index.php?option=com_osmembership&view=groupmember&id=' . $row->id . '&Itemid=' . $this->Itemid);
			?>
				<tr>
					<td>
						<a href="<?php echo $link; ?>"><?php echo $row->plan_title;?></a>
						<a href="javascript:deleteMemberConfirm(<?php echo $row->id; ?>)" title="<?php echo JText::_('OSM_DELETE_THIS_MEMBER'); ?>"><i
								class="icon-remove alert-danger"></i></a>
					</td>
					<?php
					foreach ($fields as $field)
					{
					?>
						<td>
							<?php
								echo $row->{$field->name};
							?>
						</td>
					<?php
					}
					?>
					<td class="center">
						<?php echo JHtml::_('date', $row->created_date, $this->config->date_format); ?>
					</td>
				</tr>
			<?php
			}
			?>
			</tbody>
			<?php
			if ($this->pagination->total > $this->pagination->limit)
			{
			?>
			<tfoot>
				<tr>
					<td colspan="<?php echo $cols; ?>">
						<div class="pagination"><?php echo $this->pagination->getListFooter(); ?></div>
					</td>
				</tr>
			</tfoot>
			<?php
			}
		?>
	</table>
	<script language="javascript">
		function deleteMemberConfirm(id)
		{
			if (confirm("<?php echo JText::_('OSM_DELETE_MEMBER_CONFIRM'); ?>"))
			{
				form = document.os_form;
				form.task.value = 'delete';
				form.member_id.value = id;
				form.submit();
			}
		}
	</script>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="member_id" value="0" />
	<?php echo JHtml::_( 'form.token' ); ?>
</form>
</div>