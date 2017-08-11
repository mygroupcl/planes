<?php
/**
 * Category Table Class
 */
class OSMembershipTableCategory extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_categories', 'id', $db);
	}
}
