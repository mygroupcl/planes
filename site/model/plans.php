<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

class OSMembershipModelPlans extends MPFModelList
{
	/**
	 * Instantiate the model.
	 *
	 * @param array $config configuration data for the model
	 */
	public function __construct($config = array())
	{
		$config['remember_states'] = false;

		parent::__construct($config);

		$this->state->insert('id', 'int', 0)
			->insert('filter_plan_ids', '');
	}

	/**
	 * Builds SELECT columns list for the query
	 *
	 * @param JDatabaseQuery $query
	 *
	 * @return $this
	 */
	protected function buildQueryColumns(JDatabaseQuery $query)
	{
		$fieldSuffix = OSMembershipHelper::getFieldSuffix();
		$query->select('tbl.*')
			->select('tbl.title' . $fieldSuffix . ' AS title')
			->select('tbl.short_description' . $fieldSuffix . ' AS short_description')
			->select('tbl.description' . $fieldSuffix . ' AS description');

		return $this;
	}

	/**
	 * Builds a WHERE clause for the query
	 *
	 * @param JDatabaseQuery $query
	 *
	 * @return $this
	 */
	protected function buildQueryWhere(JDatabaseQuery $query)
	{
		$config = OSMembershipHelper::getConfig();

		$query->where('tbl.published = 1')
			->where('tbl.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')');

		if ($this->state->id)
		{
			$query->where('tbl.category_id = ' . $this->state->id);
		}

		if (!empty($config->hide_active_plans))
		{
			$activePlanIds = OSMembershipHelperSubscription::getActiveMembershipPlans();

			if (count($activePlanIds) > 1)
			{
				$query->where('tbl.id NOT IN (' . implode(',', $activePlanIds) . ')');
			}
		}

		if ($this->state->filter_plan_ids)
		{
			$planIds = $this->state->filter_plan_ids;

			if (strpos($planIds, 'cat-') !== false)
			{
				$catId = (int) substr($planIds, 4);
				$query->where('tbl.category_id = ' . $catId);
			}
			elseif ($planIds != '*')
			{
				$planIds = explode(',', $planIds);
				$planIds = ArrayHelper::toInteger($planIds);
				$planIds = implode(',', $planIds);
				$query->where('tbl.id IN (' . $planIds . ')');
			}
		}

		return $this;
	}
}
