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
	
JToolbarHelper::title(   JText::_( 'Configuration' ), 'generic.png' );
JToolbarHelper::apply();
JToolbarHelper::save('save');
JToolbarHelper::cancel('cancel');

if (JFactory::getUser()->authorise('core.admin', 'com_osmembership'))
{
	JToolbarHelper::preferences('com_osmembership');
}

JHtml::_('bootstrap.tooltip');
JHtml::_('formbehavior.chosen', 'select');

$document = JFactory::getDocument();
$document->addStyleDeclaration(".hasTip{display:block !important}");
$editor = JFactory::getEditor() ;
$config = $this->config;

$translatable = JLanguageMultilang::isEnabled() && count($this->languages);

JHtml::_('jquery.framework');
JHtml::_('behavior.tabstate');
JHtml::_('script', 'jui/cms.js', false, true);
?>
<div class="row-fluid">
	<form action="index.php?option=com_osmembership&view=configuration" method="post" name="adminForm" id="adminForm" class="form-horizontal osm-configuration">
		<?php echo JHtml::_('bootstrap.startTabSet', 'configuration', array('active' => 'general-page')); ?>
			<?php echo JHtml::_('bootstrap.addTab', 'configuration', 'general-page', JText::_('OSM_GENERAL', true)); ?>
				<div class="span6">
					<?php echo $this->loadTemplate('subscriptions', array('config' => $config)); ?>
					<?php echo $this->loadTemplate('mail', array('config' => $config)); ?>
				</div>
				<div class="span6">
					<?php echo $this->loadTemplate('themes', array('config' => $config)); ?>
					<?php echo $this->loadTemplate('other', array('config' => $config)); ?>
				</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php
				echo JHtml::_('bootstrap.addTab', 'configuration', 'invoice-page', JText::_('OSM_INVOICE_SETTINGS', true));
				echo $this->loadTemplate('invoice', array('config' => $config, 'editor' => $editor));
				echo JHtml::_('bootstrap.endTab');

			if ($translatable)
			{
				echo JHtml::_('bootstrap.addTab', 'configuration', 'invoice-translation', JText::_('OSM_INVOICE_TRANSLATION', true));
				echo $this->loadTemplate('translation', array('config' => $config, 'editor' => $editor));
				echo JHtml::_('bootstrap.endTab');
			}

			$editorPlugin = null;

			if (JPluginHelper::isEnabled('editors', 'codemirror'))
			{
				$editorPlugin = 'codemirror';
			}
			elseif(JPluginHelper::isEnabled('editor', 'none'))
			{
				$editorPlugin = 'none';
			}

			if ($editorPlugin)
			{
				echo JHtml::_('bootstrap.addTab', 'configuration', 'custom-css', JText::_('OSM_CUSTOM_CSS', true));
				$customCss = '';

				if (file_exists(JPATH_ROOT.'/media/com_osmembership/assets/css/custom.css'))
				{
					$customCss = file_get_contents(JPATH_ROOT.'/media/com_osmembership/assets/css/custom.css');
				}

				echo JEditor::getInstance($editorPlugin)->display('custom_css', $customCss, '100%', '550', '75', '8', false, null, null, null, array('syntax' => 'css'));
				echo JHtml::_('bootstrap.endTab');
			}
			?>
		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
		<input type="hidden" name="task" value="" />
		<div class="clearfix"></div>
	</form>
</div>