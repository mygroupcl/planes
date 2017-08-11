<?php
/**
 * Tax rate Table Class
 */
class OSMembershipTableTax extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_taxes', 'id', $db);
	}
}
