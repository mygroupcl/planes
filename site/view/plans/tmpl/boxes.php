<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die ;
?>

<style type="text/css">
	/*boxes*/
#osm-plans-list-boxes{
	color: #696969;
	font-family:'Oswald', sans serif !important;
	font-size: 14px;
	width: 910px;
	margin: 0 auto;
	padding:0;
	height:300px;
}
#osm-plans-list-boxes ul{
	margin: 0;
	padding: 0;
	float:left;
}
#osm-plans-list-boxes ul li{
	float: left;
	margin: 0;
	padding: 15px 0;
	width:100%;
}
#osm-plans-list-boxes ul li p{
	color: #222;
	font-size: 13px;
	font-family: 'Oswald', sans serif !important;
}
#osm-plans-list-boxes ul#col_Single1,
#osm-plans-list-boxes ul#col_Basic1,
#osm-plans-list-boxes ul#col_Standart1,
#osm-plans-list-boxes ul#col_Developer1{
	border: 1px solid #E1E2E3;
	text-align: center;
	width: 225px;
	list-style: none outside none;
}
#osm-plans-list-boxes ul#col_Single1:hover,
#osm-plans-list-boxes ul#col_Basic1:hover,
#osm-plans-list-boxes ul#col_Standart1:hover,
#osm-plans-list-boxes ul#col_Developer1:hover,
#osm-plans-list-boxes ul.default{
	box-shadow: 0 0 25px #d3d3d3;
	left: 0;
	position: relative;
	top: -30px;
	z-index: 10;
}
#osm-plans-list-boxes ul#col_Single1:hover .first1,
#osm-plans-list-boxes ul#col_Basic1:hover .first1,
#osm-plans-list-boxes ul#col_Standart1:hover .first1,
#osm-plans-list-boxes ul#col_Developer1:hover .first1,
#osm-plans-list-boxes ul.default .first1{
	background:url("http://ordasoft.com/templates/jv_bara/images/bg_blue.png") repeat-x ;
}
#osm-plans-list-boxes ul#col_Single1:hover .first1 span.title1,
#osm-plans-list-boxes ul#col_Basic1:hover .first1 span.title1,
#osm-plans-list-boxes ul#col_Standart1:hover .first1 span.title1,
#osm-plans-list-boxes ul#col_Developer1:hover .first1 span.title1,
#osm-plans-list-boxes ul.default .first1 span.title1{
	text-shadow:0 -1px #6D6D6D !important;
	color:#fff !important;
}
#osm-plans-list-boxes ul#col_Single1:hover .dark1,
#osm-plans-list-boxes ul#col_Basic1:hover .dark1,
#osm-plans-list-boxes ul#col_Standart1:hover .dark1,
#osm-plans-list-boxes ul#col_Developer1:hover .dark1,
#osm-plans-list-boxes ul.default{
	background:#E1E2E3;
}
#osm-plans-list-boxes ul li.first1{
	background: url("http://ordasoft.com/templates/jv_bara/images/bg_grey.png") repeat-x scroll 0 0 transparent;
	height: 70px;
	padding: 0 !important;
	width: 100%;
	border-bottom:1px solid #E1E2E3;
}
#osm-plans-list-boxes li.first1 span.title1{
	color: #000;
	display: block;
	font-size: 22px;
	margin: 22px 0;
	text-shadow: 1px 1px #FFF;
}
#osm-plans-list-boxes ul li.light1{
	background:#fff;
	padding: 20px 0 !important;
	border-bottom: 1px solid #E1E2E3;
}
#osm-plans-list-boxes li.light1 span.single1,
#osm-plans-list-boxes li.light1 span.basic1,
#osm-plans-list-boxes li.light1 span.standart1,
#osm-plans-list-boxes li.light1 span.developer1{
	color: #333;
	height: 65px;
	display: block;
	font-family: 'Dosis',sans-serif;
	font-size: 51px;
	font-weight: bold;
	text-align: center !important;
        line-height: 65px;
	
}
#osm-plans-list-boxes ul li.dark1{
	background:  #FAFAFA;
	border-bottom: 1px solid #E1E2E3;
	color: #222;
	font-size: 18px;
	height: 250px;
	padding: 10px 0;
	text-align: left;
	text-shadow: 1px 1px #FFF;
}
#osm-plans-list-boxes li.dark1 ul.sub{
	list-style:none;
}
#osm-plans-list-boxes li.dark1 ul.sub li{
	font-size: 14px;
	line-height: 0 !important;
	height: 26px;
	margin: 0 5px 3px 10px !important;
	padding: 0 0 5px 10px !important;
	text-align: left;
}

#osm-plans-list-boxes li.dark1 ul.sub li.description_domain p{
	background: url("http://ordasoft.com/templates/jv_bara/images/check.png") no-repeat scroll 0 0 transparent !important;
}
#osm-plans-list-boxes li.dark1 ul.sub li.duration_domain{
    background: none repeat scroll 0 0 transparent !important;
    height: auto;
    line-height: 1.2 !important;
    margin: 0 !important;
    padding: 0 !important;
    text-align: center;
    width: 100% !important;
}
#osm-plans-list-boxes li.dark1 ul.sub li.duration_domain p{
	color: #222;
	font-size: 15px;
	line-height:25px;    	                	
	text-shadow: 1px 1px #FFF;
	text-align: center;
}
#osm-plans-list-boxes li.dark1 ul.sub li p a {
	display: inline;
	font-family: 'Arial', sans-serif !important;
	color:#006688;
}
#osm-plans-list-boxes span.info_hover{
	background: none repeat scroll 0 0 #000;
	border-radius: 3px;
	color: #fff;
	font-family: 'Arial', sans-serif !important;
	height: auto;
	left: -112px;
	opacity: 0.8;
	padding: 15px 5px 10px 10px;
	position: absolute;
	top: 24px;
	white-space: normal !important;
	width: 204px;
	z-index: 100;
	cursor:help !important;
	display:none;
	line-height: 1.2;
	text-shadow: none;
}
#osm-plans-list-boxes a:hover span.info_hover{
	display: block;
}
#osm-plans-list-boxes ul li.footer1{
	background: none repeat scroll 0 0 #FAFAFA;
	padding-bottom: 25px !important;
}

#osm-plans-list-boxes ul li.footer1 u{
	list-style: :none;
	float: left;
}
</style>

<div id="osm-plans-list-boxes">
	<?php
		if (!$this->input->getInt('hmvc_call'))
		{
			if ($this->category)
			{
				$pageHeading = $this->params->get('page_heading') ? $this->params->get('page_heading') : $this->category->title;
			}
			else
			{
				$pageHeading = $this->params->get('page_heading') ? $this->params->get('page_heading') : JText::_('OSM_SUBSCRIPTION_PLANS');
			}
			?>

			<h1 class="osm-page-title"><?php echo $pageHeading; ?></h1>

			<?php
			if (!empty($this->category->description))
			{
			?>
				<div class="osm-description clearfix"><?php echo $this->category->description;?></div>
			<?php
			}
		}

		if (count($this->categories))
		{
			echo OSMembershipHelperHtml::loadCommonLayout('common/tmpl/categories.php', array('items' => $this->categories, 'categoryId' => $this->categoryId, 'config' => $this->config, 'Itemid' => $this->Itemid));
		}

		if (count($this->items))
		{
			echo OSMembershipHelperHtml::loadCommonLayout('common/tmpl/boxes_plans.php', array('items' => $this->items, 'input' => $this->input, 'config' => $this->config, 'Itemid' => $this->Itemid, 'categoryId' => $this->categoryId, 'bootstrapHelper' => $this->bootstrapHelper));
		}

		if (!$this->input->getInt('hmvc_call') && ($this->pagination->total > $this->pagination->limit))
		{
		?>
			<div class="pagination">
				<?php echo $this->pagination->getPagesLinks(); ?>
			</div>
		<?php
		}
	?>
</div>