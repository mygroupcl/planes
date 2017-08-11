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

class OSMembershipModelPlans extends MPFModelList
{
	/**
	 * Instantiate the model.
	 *
	 * @param array $config configuration data for the model
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->state->insert('filter_category_id', 'int', 0);
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
		$query->select(array('tbl.*'))
			->select('b.title AS category_title')
			->select('vl.title AS access_level');

		return $this;
	}

	/**
	 * Builds JOINS clauses for the query
	 *
	 * @param JDatabaseQuery $query
	 *
	 * @return $this
	 */
	protected function buildQueryJoins(JDatabaseQuery $query)
	{
		$query->leftJoin('#__osmembership_categories AS b ON tbl.category_id = b.id')
			->leftJoin('#__viewlevels AS vl ON vl.id = tbl.access');

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
		parent::buildQueryWhere($query);

		if ($this->state->filter_category_id)
		{
			$query->where('tbl.category_id = ' . $this->state->filter_category_id);
		}

		return $this;
	}
}
