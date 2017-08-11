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

class OSMembershipModelReports extends MPFModelList
{
	/**
	 * Instantiate the model.
	 *
	 * @param array $config configuration data for the model
	 */
	public function __construct($config = array())
	{
		$config['table']         = '#__osmembership_subscribers';
		$config['search_fields'] = array('tbl.first_name', 'tbl.last_name', 'tbl.email', 'tbl.subscription_id', 'tbl.membership_id', 'c.username', 'c.name');
		$config['clear_join']    = false;

		parent::__construct($config);

		$this->state->insert('plan_id', 'int', 0)
			->insert('published', 'int', -1)
			->insert('filter_in', 'int', 30)
			->setDefault('filter_order', 'tbl.created_date')
			->setDefault('filter_order_Dir', 'DESC');
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
			->select('b.title AS plan_title, b.lifetime_membership')
			->select('b.currency, b.currency_symbol')
			->select('c.username AS username');

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
		$query->leftJoin('#__osmembership_plans AS b ON tbl.plan_id = b.id')
			->leftJoin('#__users AS c ON tbl.user_id = c.id');

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

		$state = $this->getState();

		$query->where('group_admin_id = 0')
			->where('plan_main_record = 1');

		if ($state->plan_id)
		{
			$query->where('tbl.plan_id = ' . $state->plan_id);
		}

		if (in_array($state->published, array(0, 1, 2, 3)))
		{
			$query->where('tbl.plan_subscription_status = ' . $state->published);
		}

		$db  = $this->getDbo();
		$now = $db->quote(JFactory::getDate()->toSql());

		if ($state->published == 4)
		{
			$query->where('DATEDIFF(plan_subscription_to_date, ' . $now . ') >= 0');

			if ($state->filter_in > 0)
			{
				$query->where('DATEDIFF(plan_subscription_to_date, ' . $now . ') <= ' . $state->filter_in);
			}

			if ($state->plan_id <= 0)
			{
				$query->where('b.recurring_subscription = 0');
			}
		}

		if ($state->published == 5)
		{
			$query->where('DATEDIFF(plan_subscription_to_date, ' . $now . ') >= 0');

			if ($state->filter_in > 0)
			{
				$query->where('DATEDIFF(plan_subscription_to_date, ' . $now . ') <= ' . $state->filter_in);
			}

			if ($state->plan_id <= 0)
			{
				$query->where('b.recurring_subscription = 1');
			}
		}		
		
		return $this;
	}

	/**
	 * Builds a generic ORDER BY clasue based on the model's state
	 *
	 * @param JDatabaseQuery $query
	 *
	 * @return $this
	 */
	protected function buildQueryOrder(JDatabaseQuery $query)
	{
		if (in_array($this->state->published, array(4, 5)))
		{
			$this->set('filter_order', 'plan_subscription_to_date')
				->set('filter_order_Dir', '');
		}

		return parent::buildQueryOrder($query);
	}
}
