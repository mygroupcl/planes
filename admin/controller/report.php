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

/**
 * OSMembership Plugin controller
 *
 * @package        Joomla
 * @subpackage     Membership Pro
 */
class OSMembershipControllerReport extends OSMembershipController
{
	/**
	 * Export subscribers
	 */
	public function export()
	{
		$this->checkAccessPermission('subscriptions');

		$config = $config = OSMembershipHelper::getConfig();
		$model  = $this->getModel('reports');

		/* @var OSMembershipModelReports $model */

		$model->set('limitstart', 0)
			->set('limit', 0)
			->set('filter_order', 'tbl.id')
			->set('filter_order_Dir', 'ASC');

		$rows = $model->getData();

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		if (count($rows))
		{

			$ids = array();
			for ($i = 0, $n = count($rows); $i < $n; $i++)
			{
				$row   = $rows[$i];
				$ids[] = $row->id;
				switch ($row->plan_subscription_status)
				{
					case 0:
						$row->subscription_status = JText::_('OSM_PENDING');
						break;
					case 1:
						$row->subscription_status = JText::_('OSM_ACTIVE');
						break;
					case 2:
						$row->subscription_status = JText::_('OSM_EXPIRED');
						break;
					case 3:
						$row->subscription_status = JText::_('OSM_CANCELLED_PENDING');
						break;
					case 4:
						$row->subscription_status = JText::_('OSM_CANCELLED_REFUNDED');
						break;
					default:
						$row->subscription_status = '';
						break;
				}
			}

			$query->clear();
			$query->select('name, title')
				->from('#__osmembership_plugins');
			$db->setQuery($query);
			$plugins      = $db->loadObjectList();
			$pluginTitles = array();
			foreach ($plugins as $plugin)
			{
				$pluginTitles[$plugin->name] = $plugin->title;
			}

			//Get list of custom fields
			$query->clear();
			$query->select('id, name, title, is_core')
				->from('#__osmembership_fields')
				->where('published = 1')
				->order('ordering');
			$db->setQuery($query);
			$rowFields = $db->loadObjectList();

			$customFieldDatas = array();
			$query->clear();
			$query->select('*')
				->from('#__osmembership_field_value')
				->where('subscriber_id IN (' . implode(',', $ids) . ')');
			$db->setQuery($query);
			$fieldDatas = $db->loadObjectList();
			if (count($fieldDatas))
			{
				foreach ($fieldDatas as $fieldData)
				{
					$customFieldDatas[$fieldData->subscriber_id][$fieldData->field_id] = $fieldData->field_value;
				}
			}

			$results_arr   = array();
			$results_arr[] = JText::_('OSM_PLAN');
			$results_arr[] = JText::_('Username');
			foreach ($rowFields as $rowField)
			{
				$results_arr[] = $rowField->title;
			}
			$results_arr[] = JText::_('OSM_SUBSCRIPTION_START_DATE');
			$results_arr[] = JText::_('OSM_SUBSCRIPTION_END_DATE');
			$results_arr[] = JText::_('OSM_SUBSCRIPTION_STATUS');
			$results_arr[] = JText::_('OSM_MEMBERSHIP_ID');

			$csv_output = "\"" . implode("\",\"", $results_arr) . "\"";

			foreach ($rows as $r)
			{
				$results_arr   = array();
				$results_arr[] = $r->plan_title;
				$results_arr[] = $r->username;
				foreach ($rowFields as $rowField)
				{
					if ($rowField->is_core)
					{
						$fieldName     = $rowField->name;
						$results_arr[] = $r->{$fieldName};
					}
					else
					{
						$fieldId    = $rowField->id;
						$fieldValue = @$customFieldDatas[$r->id][$fieldId];
						if (is_string($fieldValue) && is_array(json_decode($fieldValue)))
						{
							$fieldValue = implode(', ', json_decode($fieldValue));
						}
						$results_arr[] = $fieldValue;
					}
				}
				$results_arr[] = JHtml::_('date', $r->plan_subscription_from_date, $config->date_format);
				$results_arr[] = JHtml::_('date', $r->plan_subscription_to_date, $config->date_format);
				$results_arr[] = $r->subscription_status;
				$results_arr[] = $r->membership_id;
				$csv_output .= "\n\"" . implode("\",\"", $results_arr) . "\"";
			}
			$csv_output .= "\n";
			if (preg_match('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
			{
				$UserBrowser = "Opera";
			}
			elseif (preg_match('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
			{
				$UserBrowser = "IE";
			}
			else
			{
				$UserBrowser = '';
			}
			$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
			$filename  = "subscribers_report_" . JFactory::getDate()->toSql();
			@ob_end_clean();
			ob_start();
			header('Content-Type: ' . $mime_type);
			header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			if ($UserBrowser == 'IE')
			{
				header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			}
			else
			{
				header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
				header('Pragma: no-cache');
			}
			print $csv_output;
			exit();
		}
	}
}
