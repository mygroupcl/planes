<?php
/**
 * @version		1.0.0
 * @package		Joomla
 * @subpackage	Docman2EDocman
 * @author		Tuan Pham Ngoc
 * @copyright	Copyright (C) 2018-2011 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined( '_JEXEC' ) or die ;

JToolbarHelper::title('Data Migration');

$start = JFactory::getApplication()->input->getInt('start', 0);
?>
<form action="index.php?option=com_osmembership&task=datamigration.process&start=<?php echo $start; ?>" method="post" name="adminForm" id="adminForm">
	<div class="row-fluid">
		<div class="span12" style="text-align:center;">
			<div class="img img-polaroid" style="padding:10px;text-align:left; font-size: 16px; font-weight: bold;">
				<p class="alert alert-danger">
					The system is migrating your data to new structure to support Membership Reporting feature added to Membership Pro 2.6.0. Please don't do anything until this process complete and you are being redirected back to Membership Pro Dashboard
				</p>
			</div>
		</div>
	</div>
	<?php echo JHtml::_( 'form.token' ); ?>
	<script type="text/javascript">
		function redirect() {
			document.adminForm.submit();
		}
		setTimeout('redirect()', 5000);
	</script>
</form>