<?php
/**
 * Rules Table Class
 */
class OSMembershipTableRule extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_upgraderules', 'id', $db);
	}
}
