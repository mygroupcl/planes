<?php

/**
 * Custom Fields Table Class
 */
class OSMembershipTableField extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_fields', 'id', $db);
	}
}
