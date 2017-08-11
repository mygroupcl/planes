<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */

/**
 * Subscribers Table Class
 *
 * @property $id
 * @property $plan_id
 * @property $user_id
 * @property $coupon_id
 * @property $first_name
 * @property $last_name
 * @property $organization
 * @property $address
 * @property $address2
 * @property $city
 * @property $state
 * @property $zip
 * @property $country
 * @property $phone
 * @property $fax
 * @property $email
 * @property $comment
 * @property $created_date
 * @property $payment_date
 * @property $from_date
 * @property $to_date
 * @property $invoice_number
 * @property $is_profile
 * @property $profile_id
 * @property $membership_id
 * @property $act
 * @property $published
 * @property $setup_fee
 * @property $tax_rate
 * @property $amount
 * @property $tax_amount
 * @property $discount_amount
 * @property $gross_amount
 * @property $payment_processing_fee
 * @property $payment_method
 * @property $transaction_id
 * @property $language
 * @property $plan_main_record
 * @property $plan_subscription_from_date
 * @property $plan_subscription_to_date
 * @property $plan_subscription_status
 */
class OSMembershipTableSubscriber extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__osmembership_subscribers', 'id', $db);
	}
}
