<?php
/**
 * Config Table Class
 */
class OSMembershipTableConfig extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_configs', 'id', $db);
	}
}
