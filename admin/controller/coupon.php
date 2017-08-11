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

class OSMembershipControllerCoupon extends OSMembershipController
{
	/**
	 * Method to import coupon codes from a csv file
	 */
	public function import()
	{
		$this->checkAccessPermission('coupons');

		$inputFile = $this->input->files->get('input_file');
		$fileName  = $inputFile ['name'];
		$fileExt   = strtolower(JFile::getExt($fileName));

		if (!in_array($fileExt, array('csv', 'xls', 'xlsx')))
		{
			$this->setRedirect('index.php?option=com_osmembership&view=coupon&layout=import', JText::_('Invalid File Type. Only CSV, XLS and XLS file types are supported'));

			return;
		}

		/* @var OSMembershipModelCoupon $model */
		$model = $this->getModel('Coupon');
		try
		{
			$numberImportedCoupons = $model->import($inputFile['tmp_name']);
			$this->setRedirect('index.php?option=com_osmembership&view=coupons', JText::sprintf('OSM_NUMBER_COUPONS_IMPORTED', $numberImportedCoupons));
		}
		catch (Exception $e)
		{
			$this->setRedirect('index.php?option=com_osmembership&view=coupon&layout=import');
			$this->setMessage($e->getMessage(), 'error');
		}
	}

	/**
	 * Export Coupons into a CSV file
	 */
	public function export()
	{
		$this->checkAccessPermission('coupons');

		set_time_limit(0);

		$nullDate = JFactory::getDbo()->getNullDate();

		/* @var OSMembershipModelCoupons $model */
		$model = $this->getModel('coupons');
		$model->set('limitstart', 0)
			->set('limit', 0);
		$rows = $model->getData();

		if (count($rows) == 0)
		{
			$this->setMessage(JText::_('There are no coupon records to export'));
			$this->setRedirect('index.php?option=com_osmembership&view=coupons');

			return;
		}

		$fields = array(
			'id',
			'plan',
			'code',
			'coupon_type',
			'discount',
			'times',
			'used',
			'valid_from',
			'valid_to',
			'published'
		);

		foreach ($rows as $row)
		{
			if ($row->valid_from != $nullDate && $row->valid_from)
			{
				$row->valid_from = JHtml::_('date', $row->valid_from, 'Y-m-d', null);
			}
			else
			{
				$row->valid_from = '';
			}

			if ($row->valid_to != $nullDate && $row->valid_to)
			{
				$row->valid_to = JHtml::_('date', $row->valid_to, 'Y-m-d', null);
			}
			else
			{
				$row->valid_to = '';
			}
		}

		OSMembershipHelperData::excelExport($fields, $rows, 'coupons_list');
	}

	/**
	 * Batch coupon generation
	 */
	public function batch()
	{
		$this->checkAccessPermission('coupons');

		/* @var OSMembershipModelCoupon $model */
		$model = $this->getModel('Coupon');
		$model->batch($this->input);

		$this->setRedirect('index.php?option=com_osmembership&view=coupons', JText::_('OSM_COUPONS_SUCCESSFULLY_GENERATED'));
	}
}