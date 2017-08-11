<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012-2014 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
$showPlan = $this->params->get('show_plan', 1);
$showSubscriptionDate = $this->params->get('show_subscription_date', 1);
$numberColumns = $this->params->get('number_columns', 2);

$bootstrapHelper = new OSMembershipHelperBootstrap($this->config->twitter_bootstrap_version);
$span = intval(12 / $numberColumns);
$spanClass = $bootstrapHelper->getClassMapping('span' . $span);
$rowFluidClass = $bootstrapHelper->getClassMapping('row-fluid');

$fieldsData = $this->fieldsData;
$items = $this->items;
$fields = $this->fields;

OSMembershipHelperJquery::equalHeights();
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
		<div class="clearfix <?php echo $rowFluidClass; ?>">
		<?php
		$i = 0;
		$numberProfiles = count($items);

		foreach ($items as $item)
		{
			$i++;

			if (!$item->avatar)
			{
				$item->avatar = 'no_avatar.jpg';
			}
		?>
			<div class="osm-user-profile-wrapper <?php echo $spanClass; ?>">
				<div class="row-fluid">
					<div class="span4">
						<img class="<?php echo $imgClass; ?> oms-avatar img-circle" src="<?php echo JUri::base(true) . '/media/com_osmembership/avatars/' . $item->avatar; ?>"/>
					</div>
					<div class="span8">
						<div class="profile-name"><?php echo rtrim($item->first_name . ' ' . $item->last_name); ?></div>
						<table class="table table-striped">
							<?php
							if ($showPlan)
							{
							?>
								<tr>
									<td class="osm-profile-field-title">
										<?php echo JText::_('OSM_PLAN'); ?>:
									</td>
									<td>
										<?php echo $item->plan_title; ?>
									</td>
								</tr>
							<?php
							}

							if ($showSubscriptionDate)
							{
							?>
								<tr>
									<td class="osm-profile-field-title">
										<?php echo JText::_('OSM_SUBSCRIPTION_DATE'); ?>:
									</td>
									<td>
										<?php echo JHtml::_('date', $item->created_date, $this->config->date_format); ?>
									</td>
								</tr>
							<?php
							}

							foreach($fields as $field)
							{
								if ($field->name == 'first_name' || $field->name == 'last_name')
								{
									continue;
								}

								if ($field->is_core)
								{
									$fieldValue = $item->{$field->name};
								}
								elseif (isset($fieldsData[$item->id][$field->id]))
								{
									$fieldValue = $fieldsData[$item->id][$field->id];
								}
								else
								{
									$fieldValue = '';
								}
								
								if (is_string($fieldValue) && is_array(json_decode($fieldValue)))
								{
									$fieldValue = implode(', ', json_decode($fieldValue));
								}								
								?>
								<tr>
									<td class="osm-profile-field-title">
										<?php echo $field->title; ?>:
									</td>
									<td class="osm-profile-field-value">
										<?php echo $fieldValue; ?>
									</td>
								</tr>
							<?php
							}
							?>
						</table>
					</div>
				</div>
			</div>
			<?php
			if ($i % $numberColumns == 0 && $i < $numberProfiles)
			{
			?>
				</div>
				<div class="clearfix <?php echo $rowFluidClass; ?>">
			<?php
			}
		}
		?>
		</div>
		
		<?php
			if ($this->pagination->total > $this->pagination->limit)
			{
			?>			
				<div class="pagination">
					<?php echo $this->pagination->getPagesLinks(); ?>
				</div>					
			<?php
			}
		?>	
		
	</form>
</div>
<script type="text/javascript">
	OSM.jQuery(function($) {
		$(document).ready(function() {
			$(".osm-user-profile-wrapper").equalHeights(150);
		});
	});
</script>