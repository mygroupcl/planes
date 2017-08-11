<?php
/**
 * @package        Joomla
 * @subpackage     OSMembership
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die;
JHtml::_('bootstrap.tooltip');
$fields = $this->fields;
$cols = count($fields);
$showAvatar = $this->params->get('show_avatar', 1);
$showPlan = $this->params->get('show_plan', 1);
$showSubscriptionDate = $this->params->get('show_subscription_date', 1);
?>
<div id="osm-members-list" class="osm-container row-fluid">
	<div class="page-header">
		<h1 class="osm-page-title"><?php echo JText::_('OSM_MEMBERS_LIST') ; ?></h1>
	</div>
	<form method="post" name="adminForm" id="adminForm" action="<?php echo JRoute::_('index.php?option=com_osmembership&view=members&Itemid='.$this->Itemid); ?>">
		<fieldset class="filters btn-toolbar clearfix">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('OSM_FILTER_SEARCH_MEMBERS_DESC');?></label>
				<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->filter_search); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('OSM_SEARCH_MEMBERS_DESC'); ?>" />
			</div>
			<div class="btn-group pull-left">
				<button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><span class="icon-search"></span></button>
				<button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><span class="icon-remove"></span></button>
			</div>
		</fieldset>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<?php
						if ($showAvatar)
						{
							$cols++;
						?>
							<th>
								<?php echo JText::_('OSM_AVATAR') ?>
							</th>
						<?php
						}

						if ($showPlan)
						{
							$cols++;
						?>
							<th>
								<?php echo JText::_('OSM_PLAN') ?>
							</th>
						<?php
						}

						foreach($fields as $field)
						{
						?>
							<th><?php echo $field->title; ?></th>
						<?php
						}

						if ($showSubscriptionDate)
						{
							$cols++;
						?>
							<th class="center">
								<?php echo JText::_('OSM_SUBSCRIPTION_DATE') ; ?>
							</th>
						<?php
						}
					?>
				</tr>
			</thead>
			<tbody>
			<?php
				$fieldsData = $this->fieldsData;
				for ($i = 0 , $n = count($this->items) ; $i < $n ; $i++)
				{
					$row = $this->items[$i] ;
				?>
					<tr>
						<?php
						if ($showAvatar)
						{
						?>
							<td>
								<?php
								if ($row->avatar && file_exists(JPATH_ROOT . '/media/com_osmembership/avatars/' . $row->avatar))
								{
								?>
									<img class="oms-avatar" src="<?php echo JUri::base(true) . '/media/com_osmembership/avatars/' . $row->avatar; ?>"/>
								<?php
								}
								?>
							</td>
						<?php
						}

						if ($showPlan)
						{
						?>
							<td>
								<?php echo $row->plan_title; ?>
							</td>
						<?php
						}

						foreach ($fields as $field)
						{
							if ($field->is_core)
							{
								$fieldValue = $row->{$field->name};
							}
							elseif (isset($fieldsData[$row->id][$field->id]))
							{
								$fieldValue = $fieldsData[$row->id][$field->id];
							}
							else
							{
								$fieldValue = '';
							}
							
							if (is_string($fieldValue) && is_array(json_decode($fieldValue)))
							{
								$fieldValue = implode(', ', json_decode($fieldValue));
							}
							
							if ($fieldValue && filter_var($fieldValue, FILTER_VALIDATE_URL))
							{
								$fieldValue = '<a href="' . $fieldValue . '" target="_blank">' . $fieldValue . '<a/>';
							}
							?>
								<td>
									<?php echo $fieldValue; ?>
								</td>
							<?php
						}

						if ($showSubscriptionDate)
						{
						?>
							<td class="center">
								<?php echo JHtml::_('date', $row->created_date, $this->config->date_format); ?>
							</td>
						<?php
						}
						?>
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
							<div class="pagination"><?php echo $this->pagination->getPagesLinks(); ?></div>
						</td>
					</tr>
				</tfoot>
				<?php
				}
			?>
		</table>
	</form>
</div>