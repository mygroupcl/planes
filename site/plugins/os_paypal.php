<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2017 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die;

class os_paypal extends MPFPayment
{
	/**
	 * Constructor
	 *
	 * @param JRegistry $params
	 * @param array     $config
	 */
	public function __construct($params, $config = array())
	{
		parent::__construct($params, $config);

		$this->mode = $params->get('paypal_mode', 0);

		if ($this->mode)
		{
			$this->url = 'https://www.paypal.com/cgi-bin/webscr';
		}
		else
		{
			$this->url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}

		$this->setParameter('business', $params->get('paypal_id'));
		$this->setParameter('rm', 2);
		$this->setParameter('cmd', '_xclick');
		$this->setParameter('no_shipping', 1);
		$this->setParameter('no_note', 1);

		$locale = $params->get('paypal_locale');

		if (empty($locale))
		{
			if (JLanguageMultilang::isEnabled())
			{
				$locale = JFactory::getLanguage()->getTag();
			}
			else
			{
				$locale = 'en_US';
			}
		}
		
		$this->setParameter('lc', $locale);
		$this->setParameter('charset', 'utf-8');

		// Disable tax calculation if it is setup in the owner Paypal account
		$this->setParameter('tax', 0);
	}

	/**
	 * Process onetime subscription payment
	 *
	 * @param JTable $row
	 * @param array  $data
	 */
	public function processPayment($row, $data)
	{
		$app     = JFactory::getApplication();
		$Itemid  = $app->input->getInt('Itemid', 0);

		$siteUrl = JUri::base();

		$this->setParameter('currency_code', $data['currency']);
		$this->setParameter('item_name', $data['item_name']);
		$this->setParameter('amount', round($data['amount'], 2));
		$this->setParameter('custom', $row->id);

		$rowPlan = OSMembershipHelperDatabase::getPlan($row->plan_id);

		// Override PayPal email
		if ($rowPlan->paypal_email)
		{
			$this->setParameter('business', $rowPlan->paypal_email);
		}

		$this->setParameter('return',
			$siteUrl . 'index.php?option=com_osmembership&view=complete&Itemid=' . $Itemid);
		$this->setParameter('cancel_return', $siteUrl . 'index.php?option=com_osmembership&view=cancel&id=' . $row->id . '&Itemid=' . $Itemid);
		$this->setParameter('notify_url', $siteUrl . 'index.php?option=com_osmembership&task=payment_confirm&payment_method=os_paypal');
		$this->setParameter('address1', $row->address);
		$this->setParameter('address2', $row->address2);
		$this->setParameter('city', $row->city);
		$this->setParameter('country', $data['country']);
		$this->setParameter('first_name', $row->first_name);
		$this->setParameter('last_name', $row->last_name);
		$this->setParameter('state', $row->state);
		$this->setParameter('zip', $row->zip);
		$this->setParameter('email', $row->email);

		// Store receiver PayPal email before redirecting to PayPal
		$row->receiver_email = $this->getParameter('business');
		$row->store();

		$this->renderRedirectForm();
	}

	/**
	 * Verify onetime subscription payment
	 *
	 * @return bool
	 */
	public function verifyPayment()
	{
		$ret = $this->validate();

		if ($ret)
		{
			$row           = JTable::getInstance('OsMembership', 'Subscriber');
			$id            = $this->notificationData['custom'];
			$transactionId = $this->notificationData['txn_id'];

			if ($transactionId && OSMembershipHelper::isTransactionProcessed($transactionId))
			{
				return false;
			}

			$amount        = floatval($this->notificationData['mc_gross']);

			if ($amount < 0)
			{
				return false;
			}

			$row->load($id);
			
			if (!$row->id)
			{
				return false;
			}

			if ($row->published)
			{
				return false;
			}

			// Accept 0.05$ difference to avoid bug causes by rounding
			if (($row->payment_amount - $amount) > 0.05)
			{
				return false;
			}

			$receiverEmail       = strtoupper($this->notificationData['receiver_email']);
			$receiverId          = strtoupper($this->notificationData['receiver_id']);
			$business            = strtoupper($this->notificationData['business']);
			$row->receiver_email = strtoupper($row->receiver_email);

			if ($receiverEmail != $row->receiver_email && $receiverId != $row->receiver_email && $business != $row->receiver_email)
			{
				return false;
			}

			// Validate currency
			$receivedPaymentCurrency = strtoupper($this->notificationData['mc_currency']);

			if ($receivedPaymentCurrency != strtoupper($row->payment_currency))
			{
				return false;
			}
			
			if ($this->mode && ($this->notificationData['payment_status'] != 'Completed'))
			{
				return false;
			}

			$this->onPaymentSuccess($row, $transactionId);
		}
	}

	/**
	 * Process recurring subscription payment
	 *
	 * @param JTable $row
	 * @param array  $data
	 */
	public function processRecurringPayment($row, $data)
	{
		$app     = JFactory::getApplication();
		$siteUrl = JUri::base();
		$Itemid  = $app->input->getInt('Itemid', 0);

		$rowPlan = OSMembershipHelperDatabase::getPlan($row->plan_id);

		$this->setParameter('currency_code', $data['currency']);
		$this->setParameter('item_name', $data['item_name']);
		$this->setParameter('custom', $row->id);

		// Override Paypal email if needed
		if ($rowPlan->paypal_email)
		{
			$this->setParameter('business', $rowPlan->paypal_email);
		}

		$this->setParameter('return', $siteUrl . 'index.php?option=com_osmembership&view=complete&Itemid=' . $Itemid);

		$this->setParameter('cancel_return', $siteUrl . 'index.php?option=com_osmembership&view=cancel&id=' . $row->id . '&Itemid=' . $Itemid);
		$this->setParameter('notify_url', $siteUrl . 'index.php?option=com_osmembership&task=recurring_payment_confirm&payment_method=os_paypal');
		$this->setParameter('cmd', '_xclick-subscriptions');
		$this->setParameter('src', 1);
		$this->setParameter('sra', 1);
		$this->setParameter('a3', $data['regular_price']);
		$this->setParameter('address1', $row->address);
		$this->setParameter('address2', $row->address2);
		$this->setParameter('city', $row->city);
		$this->setParameter('country', $data['country']);
		$this->setParameter('first_name', $row->first_name);
		$this->setParameter('last_name', $row->last_name);
		$this->setParameter('state', $row->state);
		$this->setParameter('zip', $row->zip);
		$this->setParameter('p3', $rowPlan->subscription_length);
		$this->setParameter('t3', $rowPlan->subscription_length_unit);
		$this->setParameter('lc', 'US');

		if ($rowPlan->number_payments > 1)
		{
			$this->setParameter('srt', $rowPlan->number_payments);
		}

		if ($data['trial_duration'])
		{
			$this->setParameter('a1', $data['trial_amount']);
			$this->setParameter('p1', $data['trial_duration']);
			$this->setParameter('t1', $data['trial_duration_unit']);
		}

		// Store receiver PayPal email before redirecting to PayPal
		$row->receiver_email = $this->getParameter('business');
		$row->store();

		//Redirect users to PayPal for processing payment
		$this->renderRedirectForm();
	}

	/**
	 * Verify recurring payment
	 */
	public function verifyRecurringPayment()
	{
		$ret = $this->validate();

		if ($ret)
		{
			$id            = $this->notificationData['custom'];
			$transactionId = $this->notificationData['txn_id'];
			$amount        = floatval($this->notificationData['mc_gross']);
			$txnType       = $this->notificationData['txn_type'];

			if ($amount < 0)
			{
				return false;
			}

			if ($transactionId && OSMembershipHelper::isTransactionProcessed($transactionId))
			{
				return false;
			}

			$row = JTable::getInstance('OsMembership', 'Subscriber');

			if (!$row->load($id))
			{
				return false;
			}

			switch ($txnType)
			{
				case 'subscr_signup':
					if (!$row->published)
					{
						$row->subscription_id = $this->notificationData['subscr_id'];
						$this->onPaymentSuccess($row, $transactionId);
					}
					break;
				case 'subscr_payment':
					if ($row->payment_currency)
					{
						$isValid = true;

						// Validate receiver account
						$receiverEmail       = strtoupper($this->notificationData['receiver_email']);
						$receiverId          = strtoupper($this->notificationData['receiver_id']);
						$business            = strtoupper($this->notificationData['business']);
						$row->receiver_email = strtoupper($row->receiver_email);

						if ($receiverEmail != $row->receiver_email && $receiverId != $row->receiver_email && $business != $row->receiver_email)
						{
							$isValid = false;
						}

						// Validate currency
						$receivedPaymentCurrency = strtoupper($this->notificationData['mc_currency']);

						if (strtoupper($receivedPaymentCurrency) != strtoupper($row->payment_currency))
						{
							$isValid = false;
						}

						// Validate payment amount
						if ($row->payment_made == 0)
						{
							if ($row->trial_payment_amount > 0)
							{
								$expectedPaymentAmount = $row->trial_payment_amount;
							}
							else
							{
								$expectedPaymentAmount = $row->payment_amount;
							}

							if (($expectedPaymentAmount - $amount) > 0.05)
							{
								$isValid = false;
							}
						}
						else
						{
							if (($row->payment_amount - $amount) > 0.01)
							{
								$isValid = false;
							}
						}

						if (!$isValid)
						{
							// Fake payment
							if ($row->payment_made == 0 && $row->published)
							{
								$row->published = 2;
								$row->store();

								//Trigger onMembershipExpire event
								JFactory::getApplication()->triggerEvent('onMembershipExpire', array($row));
							}

							return false;
						}
						else
						{
							// Store Transaction ID for the first payment
							if ($row->payment_made == 0)
							{
								$row->transaction_id = $transactionId;
								$row->store();
							}
						}
					}

					OSMembershipHelper::extendRecurringSubscription($id, $transactionId);
					break;
				case 'subscr_cancel':
					OSMembershipHelperSubscription::cancelRecurringSubscription($id);
					break;

			}
		}
	}

	/**
	 * Get list of supported currencies
	 *
	 * @return array
	 */
	public function getSupportedCurrencies()
	{
		return array(
			'AUD',
			'BRL',
			'CAD',
			'CZK',
			'DKK',
			'EUR',
			'HKD',
			'HUF',
			'ILS',
			'JPY',
			'MYR',
			'MXN',
			'NOK',
			'NZD',
			'PHP',
			'PLN',
			'GBP',
			'RUB',
			'SGD',
			'SEK',
			'CHF',
			'TWD',
			'THB',
			'TRY',
			'USD',
		);
	}

	/**
	 * Validate the post data from paypal to our server
	 *
	 * @return string
	 */
	protected function validate()
	{
		$errNum                 = "";
		$errStr                 = "";
		$urlParsed              = parse_url($this->url);
		$host                   = $urlParsed['host'];
		$path                   = $urlParsed['path'];
		$postString             = '';
		$response               = '';
		$this->notificationData = $_POST;

		foreach ($_POST as $key => $value)
		{
			$postString .= $key . '=' . urlencode(stripslashes($value)) . '&';
		}

		$postString .= 'cmd=_notify-validate';
		$fp = fsockopen($host, '80', $errNum, $errStr, 30);

		if (!$fp)
		{
			$response = 'Could not open SSL connection to ' . $this->url;
			$this->logGatewayData($response);

			return false;
		}

		fputs($fp, "POST $path HTTP/1.1\r\n");
		fputs($fp, "Host: $host\r\n");
		fputs($fp, "User-Agent: Membership Pro\r\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: " . strlen($postString) . "\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $postString . "\r\n\r\n");
		while (!feof($fp))
		{
			$response .= fgets($fp, 1024);
		}
		fclose($fp);
		$this->logGatewayData($response);

		if (!$this->mode || stristr($response, "VERIFIED"))
		{
			return true;
		}

		return false;
	}
}
