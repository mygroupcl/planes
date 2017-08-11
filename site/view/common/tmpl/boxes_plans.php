<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012-2014 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
if (!isset($categoryId))
{
	$categoryId = 0;
}

$span7Class    = $bootstrapHelper->getClassMapping('span7');
$span5class    = $bootstrapHelper->getClassMapping('span5');
$btnClass      = $bootstrapHelper->getClassMapping('btn');
$imgClass      = $bootstrapHelper->getClassMapping('img-polaroid');
$rowFluidClass = $bootstrapHelper->getClassMapping('row-fluid');

//subscripciones por expirar
$subscribedPlanIds = OSMembershipHelperSubscription::getSubscribedPlans();
//subscripciones congeladas
$frozenPlansIds	= OSMembershipHelperSubscription::getFrozenPlans();
//sbscripciones expiradas o consumidas
$consumedandexpiredPlansIds = OSMembershipHelperSubscription::getConsumedandexpiredPlans();
var_dump($consumedandexpiredPlansIds);
//subscripciones esclusivas
$exclusivePlanIds = OSMembershipHelperSubscription::getExclusivePlanIds();


$nullDate      = JFactory::getDbo()->getNullDate();
$defaultItemId = $Itemid;

for ($i = 0 , $n = count($items) ;  $i < $n ; $i++)
{
	$item = $items[$i] ;
	$Itemid = OSMembershipHelperRoute::getPlanMenuId($item->id, $item->category_id, $defaultItemId);
	if ($item->thumb)
	{
		$imgSrc = JUri::base().'media/com_osmembership/'.$item->thumb ;
	}

	if ($item->category_id)
	{
		$url = JRoute::_('index.php?option=com_osmembership&view=plan&catid='.$item->category_id.'&id='.$item->id.'&Itemid='.$Itemid);
	}
	else
	{
		$url = JRoute::_('index.php?option=com_osmembership&view=plan&id='.$item->id.'&Itemid='.$Itemid);
	}

	if ($config->use_https)
	{
		$signUpUrl = JRoute::_(OSMembershipHelperRoute::getSignupRoute($item->id, $Itemid), false, 1);
	}
	else
	{
		$signUpUrl = JRoute::_(OSMembershipHelperRoute::getSignupRoute($item->id, $Itemid));
	}

	$symbol = $item->currency_symbol ? $item->currency_symbol : $item->currency;
	?>

	<?php 
	if($item->alias =="plan-full"){
		$style = "Standart1";
		$default="default";
	}
	else{
		$style = "Basic1";
		$default="";
	}
	?>
	<ul id="col_<?php echo $style;?>" style="width: 216px;" class="<?php echo $default;?>">
		<li class="first1"><span class="title1"><?php echo $item->title; ?></span></li>
		<li class="light1">
			<span class="basic1"> 
				<?php
				if ($item->price > 0)
				{
					//echo JText::_('OSM_SETUP_PRICE'); 
					echo OSMembershipHelper::formatCurrency($item->price, $config, $symbol);
				}
				else{
					echo JText::_('Free'); 
				}
				?>

			</span>
		</li>
		<li class="dark1"> 
			<ul class="sub">
				<li class="duration_domain">
				<p>
					<?php echo strtoupper(JText::_('OSM_TRIAL_DURATION')); ?>
					<?php
					if ($item->lifetime_membership)
					{
						echo strtoupper(JText::_('OSM_LIFETIME'));
					}
					else
					{
						switch ($item->trial_duration_unit) {
							case 'D' :
								echo strtoupper($item->trial_duration.' '.JText::_('OSM_DAYS'));
								break;
							case 'W' :
								echo strtoupper($item->trial_duration.' '.JText::_('OSM_WEEKS'));
								break;
							case 'M' :
								echo strtoupper($item->trial_duration.' '.JText::_('OSM_MONTHS'));
								break;
							case 'Y' :
								echo strtoupper($item->trial_duration.' '.JText::_('OSM_YEARS'));
								break;
							default :
								echo strtoupper($item->trial_duration.' '.JText::_('OSM_DAYS'));
								break;
						}
					}
					?>
				</p>
				</li>
				<?php
				if ($item->recurring_subscription && $item->trial_duration)
				{
				?>
				<?php } ?>
				<li class="description_domain">
					<?php
						if ($item->short_description)
						{
							echo $item->short_description;
						}
						else
						{
							echo $item->description;
						}
					?>
				</li>
			</ul>
	</li>
	<li class="footer1">
						<?php
						if (OSMembershipHelper::canSubscribe($item) && (!in_array($item->id, $exclusivePlanIds) || in_array($item->id, $subscribedPlanIds)))
						{
						?>
								<a href="<?php echo $signUpUrl; ?>" class="<?php echo $btnClass; ?> btn-primary">
									<?php 
									if(in_array($item->id, $subscribedPlanIds) 
										|| in_array($item->id, $consumedandexpiredPlansIds))
										echo JText::_('OSM_RENEW');
									elseif(in_array($item->id, $frozenPlansIds))
									 	echo "";
									 else
									 	echo JText::_('OSM_SIGNUP'); 
									 ?>
								</a>
						<?php
						}

						if (empty($config->hide_details_button))
						{
						?>
								<a href="<?php echo $url; ?>" class="<?php echo $btnClass; ?>">
									<?php echo JText::_('OSM_DETAILS'); ?>
								</a>
						<?php
						}
						?>
	</li>
</ul>

<?php
}
?>