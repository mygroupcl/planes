<?php
/**
 * Email Table Class
 */
class OSMembershipTableEmail extends JTable
{
	/**
	 * Constructor
	 *
	 * @param JDatabaseDriver $db Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_emails', 'id', $db);
	}
}
