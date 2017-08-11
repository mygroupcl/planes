<?php
/**
 * Coupons Table Class
 */
class OSMembershipTableCoupon extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_coupons', 'id', $db);
	}
}
