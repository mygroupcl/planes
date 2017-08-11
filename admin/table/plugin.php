<?php
/**
 * Payment Plugins Table Class
 */
class OSMembershipTablePlugin extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_plugins', 'id', $db);
	}
}
