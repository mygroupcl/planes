<?php

/**
 * Subscription Plan Table Class
 *
 * @property $id
 * @property $price
 * @property $subscription_length
 * @property $subscription_length_unit
 * @property $lifetime_membership
 * @property $expired_date
 * @property $params
 */
class OSMembershipTablePlan extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_plans', 'id', $db);
	}
}
