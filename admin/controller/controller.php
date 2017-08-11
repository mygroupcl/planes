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

use Joomla\Registry\Registry;

/**
 * Membership Pro controller
 *
 * @package        Joomla
 * @subpackage     Membership Pro
 */
class OSMembershipController extends MPFControllerAdmin
{
	/**
	 * Display information
	 */
	public function display($cachable = false, array $urlparams = array())
	{
		if ($this->app->isAdmin())
		{
			// Check and make sure only users with proper permission can access to the page
			$viewName = $this->input->get('view', $this->config['default_view']);
			$this->checkAccessPermission($viewName);

			$document = JFactory::getDocument();
			$rootUri  = JUri::root(true);
			$document->addStyleSheet($rootUri . '/administrator/components/com_osmembership/assets/css/style.css');

			JHtml::_('jquery.framework');
			JHtml::_('script', 'media/com_osmembership/assets/js/jquery-noconflict.js', false, false);
			$document->addScript($rootUri . '/media/com_osmembership/assets/js/ajaxupload.min.js');
			$document->addScriptDeclaration('var siteUrl="' . OSMembershipHelper::getSiteUrl() . '";');
		}

		parent::display($cachable, $urlparams);

		if ($this->app->isAdmin() && $this->input->getCmd('format', 'html') == 'html')
		{
			OSMembershipHelper::displayCopyRight();
		}
	}

	/**
	 * Check to see the installed version is up to date or not
	 *
	 * @return int 0 : error, 1 : Up to date, 2 : outof date
	 */
	public function check_update()
	{
		// Get the caching duration.
		$component     = JComponentHelper::getComponent('com_installer');
		$params        = $component->params;
		$cache_timeout = $params->get('cachetimeout', 6, 'int');
		$cache_timeout = 3600 * $cache_timeout;

		// Get the minimum stability.
		$minimum_stability = $params->get('minimum_stability', JUpdater::STABILITY_STABLE, 'int');

		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_installer/models');

		/** @var InstallerModelUpdate $model */
		$model = JModelLegacy::getInstance('Update', 'InstallerModel');

		$model->purge();

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('extension_id')
			->from('#__extensions')
			->where('`type` = "package"')
			->where('`element` = "pkg_osmembership"');
		$db->setQuery($query);
		$eid = (int) $db->loadResult();

		$result['status'] = 0;

		if ($eid)
		{
			$ret = JUpdater::getInstance()->findUpdates($eid, $cache_timeout, $minimum_stability);

			if ($ret)
			{
				$model->setState('list.start', 0);
				$model->setState('list.limit', 0);
				$model->setState('filter.extension_id', $eid);
				$updates          = $model->getItems();
				$result['status'] = 2;

				if (count($updates))
				{
					$result['message'] = JText::sprintf('OSM_UPDATE_CHECKING_UPDATEFOUND', $updates[0]->version);
				}
				else
				{
					$result['message'] = JText::sprintf('OSM_UPDATE_CHECKING_UPDATEFOUND', null);
				}
			}
			else
			{
				$result['status']  = 1;
				$result['message'] = JText::_('OSM_UPDATE_CHECKING_UPTODATE');
			}
		}

		echo json_encode($result);
		$this->app->close();
	}

	/**
	 * Download invoice
	 */
	public function download_invoice()
	{
		$id = $this->input->getInt('id');
		OSMembershipHelper::downloadInvoice($id);
	}

	/**
	 * Download file uploaded by subscriber
	 */
	public function download_file()
	{
		$filePath = 'media/com_osmembership/upload';
		$fileName = $this->input->getString('file_name', '');

		if (file_exists(JPATH_ROOT . '/' . $filePath . '/' . $fileName))
		{
			while (@ob_end_clean()) ;
			OSMembershipHelper::processDownload(JPATH_ROOT . '/' . $filePath . '/' . $fileName, $fileName, true);
			exit();
		}
		else
		{
			$this->setRedirect('index.php?option=com_osmembership', JText::_('OSM_FILE_NOT_EXIST'));
		}
	}

	/**
	 * Method to allow sharing language files for Events Booking
	 */
	public function share_translation()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('lang_code')
			->from('#__languages')
			->where('published = 1')
			->where('lang_code != "en-GB"')
			->order('ordering');
		$db->setQuery($query);
		$languages = $db->loadObjectList();

		if (count($languages))
		{
			$mailer   = JFactory::getMailer();
			$jConfig  = JFactory::getConfig();
			$mailFrom = $jConfig->get('mailfrom');
			$fromName = $jConfig->get('fromname');
			$mailer->setSender(array($mailFrom, $fromName));
			$mailer->addRecipient('tuanpn@joomdonation.com');
			$mailer->setSubject('Language Packages for Membership Pro shared by ' . JUri::root());
			$mailer->setBody('Dear Tuan \n. I am happy to share my language packages for Membership Pro.\n Enjoy!');
			foreach ($languages as $language)
			{
				$tag = $language->lang_code;
				if (file_exists(JPATH_ROOT . '/language/' . $tag . '/' . $tag . '.com_osmembership.ini'))
				{
					$mailer->addAttachment(JPATH_ROOT . '/language/' . $tag . '/' . $tag . '.com_osmembership.ini', $tag . '.com_osmembership.ini');
				}

				if (file_exists(JPATH_ADMINISTRATOR . '/language/' . $tag . '/' . $tag . '.com_osmembership.ini'))
				{
					echo JPATH_ADMINISTRATOR . '/language/' . $tag . '/' . $tag . '.com_osmembership.ini';
					$mailer->addAttachment(JPATH_ADMINISTRATOR . '/language/' . $tag . '/' . $tag . '.com_osmembership.ini', 'admin.' . $tag . '.com_osmembership.ini');
				}
			}

			require_once JPATH_COMPONENT . '/libraries/vendor/dbexporter/dumper.php';

			$tables = array($db->replacePrefix('#__eb_fields'), $db->replacePrefix('#__eb_messages'));

			try
			{

				$sqlFile = $tag . '.com_osmembership.sql';
				$options = array(
					'host'           => $jConfig->get('host'),
					'username'       => $jConfig->get('user'),
					'password'       => $jConfig->get('password'),
					'db_name'        => $jConfig->get('db'),
					'include_tables' => $tables,
				);
				$dumper  = Shuttle_Dumper::create($options);
				$dumper->dump(JPATH_ROOT . '/tmp/' . $sqlFile);

				$mailer->addAttachment(JPATH_ROOT . '/tmp/' . $sqlFile, $sqlFile);

			}
			catch (Exception $e)
			{
				//Do nothing
			}

			$mailer->Send();

			$msg = 'Thanks so much for sharing your language files to Membership Pro Community';
		}
		else
		{
			$msg = 'Thanks so willing to share your language files to Membership Pro Community. However, you don"t have any none English language file to share';
		}

		$this->setRedirect('index.php?option=com_osmembership&view=dashboard', $msg);
	}

	/**
	 * Reset SEF urls
	 */
	public function reset_urls()
	{
		$db = JFactory::getDbo();
		$db->truncateTable('#__osmembership_sefurls');
		$this->setRedirect('index.php?option=com_osmembership&view=dashboard', JText::_('SEF urls has successfully been reset'));
	}

	/**
	 * Get profile data of the subscriber, using for json format
	 */
	public function get_profile_data()
	{
		$config = OSMembershipHelper::getConfig();
		$input  = JFactory::getApplication()->input;
		$userId = $input->getInt('user_id', 0);
		$planId = $input->getInt('plan_id');
		$data   = array();

		if ($userId && $planId)
		{
			$rowFields = OSMembershipHelper::getProfileFields($planId, true);
			$db        = JFactory::getDbo();
			$query     = $db->getQuery(true);
			$query->select('*')
				->from('#__osmembership_subscribers')
				->where('user_id = ' . $userId . ' AND plan_id = ' . $planId);
			$db->setQuery($query);
			$rowProfile = $db->loadObject();

			if (!$rowProfile)
			{
				$query->clear()
					->select('*')
					->from('#__osmembership_subscribers')
					->where('user_id=' . $userId . ' AND is_profile=1');
				$db->setQuery($query);
				$rowProfile = $db->loadObject();
			}

			if (!$rowProfile)
			{
				$query->clear()
					->select('*')
					->from('#__osmembership_subscribers')
					->where('user_id = ' . $userId)
					->order('id DESC');
				$db->setQuery($query);
				$rowProfile = $db->loadObject();
			}

			$data       = array();

			if ($rowProfile)
			{
				$data = OSMembershipHelper::getProfileData($rowProfile, $planId, $rowFields);
			}
			else
			{
				// Trigger plugin to get data
				$mappings = array();

				foreach ($rowFields as $rowField)
				{
					if ($rowField->field_mapping)
					{
						$mappings[$rowField->name] = $rowField->field_mapping;
					}
				}

				JPluginHelper::importPlugin('osmembership');
				$dispatcher = JEventDispatcher::getInstance();
				$results    = $dispatcher->trigger('onGetProfileData', array($userId, $mappings));

				if (count($results))
				{
					foreach ($results as $res)
					{
						if (is_array($res) && count($res))
						{
							$data = $res;
							break;
						}
					}
				}
			}

			if (!count($data) && JPluginHelper::isEnabled('user', 'profile') && !$config->cb_integration)
			{
				$syncronizer = new RADSynchronizerJoomla();
				$mappings    = array();

				foreach ($rowFields as $rowField)
				{
					if ($rowField->profile_field_mapping)
					{
						$mappings[$rowField->name] = $rowField->profile_field_mapping;
					}
				}
				$data = $syncronizer->getData($userId, $mappings);
			}
		}

		if ($userId && !isset($data['first_name']))
		{
			//Load the name from Joomla default name
			$user = JFactory::getUser($userId);
			$name = $user->name;
			if ($name)
			{
				$pos = strpos($name, ' ');
				if ($pos !== false)
				{
					$data['first_name'] = substr($name, 0, $pos);
					$data['last_name']  = substr($name, $pos + 1);
				}
				else
				{
					$data['first_name'] = $name;
					$data['last_name']  = '';
				}
			}
		}

		if ($userId && !isset($data['email']))
		{
			$user          = JFactory::getUser($userId);
			$data['email'] = $user->email;
		}

		echo json_encode($data);

		JFactory::getApplication()->close();
	}

	/**
	 * Build EU tax rules
	 */
	public function build_eu_tax_rules()
	{
		$db = JFactory::getDbo();
		$db->truncateTable('#__osmembership_taxes');
		$defaultCountry     = OSmembershipHelper::getConfigValue('default_country');
		$defaultCountryCode = OSMembershipHelper::getCountryCode($defaultCountry);
		// Without VAT number, use local tax rate
		foreach (OSMembershipHelperEuvat::$europeanUnionVATInformation as $countryCode => $vatInfo)
		{
			$countryName    = $db->quote($vatInfo[0]);
			$countryTaxRate = OSMembershipHelperEuvat::getEUCountryTaxRate($countryCode);
			$sql            = "INSERT INTO #__osmembership_taxes(plan_id, country, rate, vies, published) VALUES(0, $countryName, $countryTaxRate, 0, 1)";
			$db->setQuery($sql);
			$db->execute();

			if ($countryCode == $defaultCountryCode)
			{
				$localTaxRate = OSMembershipHelperEuvat::getEUCountryTaxRate($defaultCountryCode);
				$sql          = "INSERT INTO #__osmembership_taxes(plan_id, country, rate, vies, published) VALUES(0, $countryName, $localTaxRate, 1, 1)";
				$db->setQuery($sql);
				$db->execute();
			}
		}

		$this->setRedirect('index.php?option=com_osmembership&view=taxes', JText::_('EU Tax Rules were successfully created'));
	}

	/**
	 * Update db scheme when users upgrade from old version to new version
	 */
	public function upgrade()
	{
		error_reporting(0);
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');

		require_once JPATH_ROOT . '/components/com_osmembership/helper/helper.php';

		$db = JFactory::getDbo();

		//First, we will need to create additional database tables which was not available in old version
		$createTablesSql = JPATH_ADMINISTRATOR . '/components/com_osmembership/sql/createifnotexists.osmembership.sql';
		$sql             = file_get_contents($createTablesSql);
		$queries         = $db->splitSql($sql);

		if (count($queries))
		{
			foreach ($queries as $query)
			{
				$query = trim($query);

				if ($query != '' && $query{0} != '#')
				{
					$db->setQuery($query);
					$db->execute();
				}
			}
		}

		$sql = 'SELECT COUNT(*) FROM #__osmembership_field_plan';
		$db->setQuery($sql);
		$total = $db->loadResult();

		if ($total == 0)
		{
			//Need to migrate data here
			$sql = 'INSERT INTO #__osmembership_field_plan(field_id, plan_id)
                SELECT id, plan_id FROM #__osmembership_fields WHERE plan_id > 0
                ';
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE #__osmembership_fields SET plan_id=1 WHERE plan_id > 0';
			$db->setQuery($sql);
			$db->execute();
		}

		$sql = 'SELECT COUNT(*) FROM #__osmembership_states';
		$db->setQuery($sql);
		$total = $db->loadResult();

		if ($total == 0)
		{
			$statesSql = JPATH_ADMINISTRATOR . '/components/com_osmembership/sql/states.osmembership.sql';
			$sql       = file_get_contents($statesSql);
			$queries   = $db->splitSql($sql);

			if (count($queries))
			{
				foreach ($queries as $query)
				{
					$query = trim($query);

					if ($query != '' && $query{0} != '#')
					{
						$db->setQuery($query);
						$db->execute();
					}
				}
			}
		}

		$configSql = JPATH_ADMINISTRATOR . '/components/com_osmembership/sql/menus.osmembership.sql';
		$sql       = JFile::read($configSql);
		$queries   = $db->splitSql($sql);
		if (count($queries))
		{
			foreach ($queries as $query)
			{
				$query = trim($query);
				if ($query != '' && $query{0} != '#')
				{
					$db->setQuery($query);
					$db->execute();
				}
			}
		}

		$sql = 'SELECT COUNT(*) FROM #__osmembership_configs';
		$db->setQuery($sql);
		$total = $db->loadResult();
		if (!$total)
		{
			$configSql = JPATH_ADMINISTRATOR . '/components/com_osmembership/sql/config.osmembership.sql';
			$sql       = JFile::read($configSql);
			$queries   = $db->splitSql($sql);
			if (count($queries))
			{
				foreach ($queries as $query)
				{
					$query = trim($query);
					if ($query != '' && $query{0} != '#')
					{
						$db->setQuery($query);
						$db->execute();
					}
				}
			}
		}

		//Change coupon code data type
		$sql = 'ALTER TABLE  `#__osmembership_coupons` CHANGE  `valid_from`	`valid_from` datetime DEFAULT NULL;';
		$db->setQuery($sql);
		$db->execute();

		$sql = "ALTER TABLE  `#__osmembership_coupons` CHANGE  `valid_to`	`valid_to` datetime DEFAULT NULL;";
		$db->setQuery($sql);
		$db->execute();

		$sql = 'SELECT COUNT(*) FROM #__osmembership_plugins';
		$db->setQuery($sql);
		$total = $db->loadResult();

		if (!$total)
		{
			$pluginsSql = JPATH_ADMINISTRATOR . '/components/com_osmembership/sql/plugins.osmembership.sql';
			$sql        = JFile::read($pluginsSql);
			$queries    = $db->splitSql($sql);

			if (count($queries))
			{
				foreach ($queries as $query)
				{
					$query = trim($query);
					if ($query != '' && $query{0} != '#')
					{
						$db->setQuery($query);
						$db->execute();
					}
				}
			}
		}

		//Invoice data
		$sql = 'SELECT COUNT(*) FROM #__osmembership_configs WHERE config_key="invoice_format"';
		$db->setQuery($sql);
		$total = $db->loadResult();
		if (!$total)
		{
			$configSql = JPATH_ADMINISTRATOR . '/components/com_osmembership/sql/config.invoice.sql';
			$sql       = JFile::read($configSql);
			$queries   = $db->splitSql($sql);
			if (count($queries))
			{
				foreach ($queries as $query)
				{
					$query = trim($query);
					if ($query != '' && $query{0} != '#')
					{
						$db->setQuery($query);
						$db->execute();
					}
				}
			}
		}

		$sql = "SELECT COUNT(*) FROM #__osmembership_currencies WHERE currency_code='RUB'";
		$db->setQuery($sql);
		$total = $db->loadResult();
		if (!$total)
		{
			$sql = "INSERT INTO #__osmembership_currencies(currency_code, currency_name) VALUES('RUB', 'Russian Rubles')";
			$db->setQuery($sql);
			$db->execute();
		}

		$fields = array_keys($db->getTableColumns('#__osmembership_countries'));
		if (!in_array('id', $fields))
		{
			//Change the name of the name of column from country_id to ID
			$sql = 'ALTER TABLE `#__osmembership_countries` CHANGE `country_id` `id` INT(11) NOT NULL AUTO_INCREMENT;';
			$db->setQuery($sql);
			$db->execute();

			//Add country ID column back for BC
			$sql = "ALTER TABLE  `#__osmembership_countries` ADD  `country_id` INT(11) NOT NULL DEFAULT '0';";
			$db->setQuery($sql);
			$db->execute();

			//Set country_id value the same with id
			$sql = 'UPDATE #__osmembership_countries SET country_id=id';
			$db->setQuery($sql);
			$db->execute();

		}

		$fields = array_keys($db->getTableColumns('#__osmembership_states'));

		if (!in_array('published', $fields))
		{
			$db->setQuery("ALTER TABLE `#__osmembership_states` ADD `published` TINYINT( 4 ) NOT NULL DEFAULT '1'");
			$db->execute();
			$db->setQuery("UPDATE `#__osmembership_states` SET `published` = 1");
			$db->execute();
		}
		if (!in_array('id', $fields))
		{
			//Change the name of the name of column from country_id to ID
			$sql = 'ALTER TABLE `#__osmembership_states` CHANGE `state_id` `id` INT(11) NOT NULL AUTO_INCREMENT;';
			$db->setQuery($sql);
			$db->execute();

			//Add country ID column back for BC
			$sql = "ALTER TABLE  `#__osmembership_states` ADD  `state_id` INT(11) NOT NULL DEFAULT '0';";
			$db->setQuery($sql);
			$db->execute();

			//Set country_id value the same with id
			$sql = 'UPDATE #__osmembership_states SET state_id=id';
			$db->setQuery($sql);
			$db->execute();
		}
		#Custom Fields table
		$fields = array_keys($db->getTableColumns('#__osmembership_fields'));
		if (!in_array('hide_on_membership_renewal', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `hide_on_membership_renewal` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('hide_on_email', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `hide_on_email` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('hide_on_export', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `hide_on_export` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('show_on_members_list', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `show_on_members_list` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('updated_date', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `updated_date` DATETIME DEFAULT NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		$sql = 'SELECT COUNT(*) FROM #__osmembership_fields WHERE show_on_members_list = 1';
		$db->setQuery($sql);
		$total = $db->loadResult();

		if (!$total)
		{
			$defaultShowedFields = array("first_name", "last_name", "email", "organization");
			$sql                 = 'UPDATE #__osmembership_fields SET show_on_members_list = 1 WHERE name IN ("' . implode('","', $defaultShowedFields) . '")';
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('fee_field', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `fee_field` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}
		if (!in_array('fee_values', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `fee_values` TEXT NULL;";
			$db->setQuery($sql);
			$db->execute();
		}
		if (!in_array('fee_formula', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `fee_formula` VARCHAR( 255 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('profile_field_mapping', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `profile_field_mapping` VARCHAR( 50 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('depend_on_field_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `depend_on_field_id` INT NOT NULL DEFAULT '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('depend_on_options', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `depend_on_options` TEXT NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('joomla_group_ids', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `joomla_group_ids` TEXT NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('max_length', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `max_length` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('place_holder', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD   `place_holder` VARCHAR( 255 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}
		if (!in_array('multiple', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `multiple` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('validation_rules', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `validation_rules` VARCHAR( 255 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('validation_error_message', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `validation_error_message` VARCHAR( 255 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('modify_subscription_duration', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `modify_subscription_duration` TEXT NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		$replace = false;
		if (!in_array('fieldtype', $fields))
		{
			$replace = true;
			$sql     = "ALTER TABLE  `#__osmembership_fields` ADD  `fieldtype` VARCHAR( 50 ) NULL;";
			$db->setQuery($sql);
			$db->execute();

			//Update field type , change it to something meaningful
			$typeMapping = array(
				0 => 'Text',
				1 => 'Textarea',
				2 => 'List',
				3 => 'Checkboxes',
				4 => 'Radio',
				5 => 'Date',
				6 => 'Heading',
				7 => 'Message',
				9 => 'File',);

			foreach ($typeMapping as $key => $value)
			{
				$sql = "UPDATE #__osmembership_fields SET fieldtype='$value' WHERE field_type='$key'";
				$db->setQuery($sql);
				$db->execute();
			}

			$sql = "UPDATE #__osmembership_fields SET fieldtype='List', multiple=1 WHERE field_type='8'";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE #__osmembership_fields SET fieldtype="countries" WHERE name="country"';
			$db->setQuery($sql);
			$db->execute();
			//MySql, convert data to Json
			$sql = 'SELECT id, field_value FROM #__osmembership_field_value WHERE field_id IN (SELECT id FROM #__osmembership_fields WHERE field_type=3 OR field_type=8)';
			$db->setQuery($sql);
			$rowFieldValues = $db->loadObjectList();
			if (count($rowFieldValues))
			{
				foreach ($rowFieldValues as $rowFieldValue)
				{
					$fieldValue = $rowFieldValue->field_value;
					if (strpos($fieldValue, ',') !== false)
					{
						$fieldValue = explode(',', $fieldValue);
					}
					$fieldValue = json_encode($fieldValue);
					$sql        = 'UPDATE #__osmembership_field_value SET field_value=' . $db->quote($fieldValue) . ' WHERE id=' . $rowFieldValue->id;
					$db->setQuery($sql);
					$db->execute();
				}
			}
		}

		########1.6.3, migrate data to new fields API ###############################################
		$sql = 'SELECT COUNT(*) FROM #__osmembership_fields';
		$db->setQuery($sql);
		$total = $db->loadResult();
		if ($total)
		{

			$sql = 'SELECT name, published FROM #__osmembership_fields WHERE is_core=1';
			$db->setQuery($sql);
			$coreFields = $db->loadObjectList('name');
		}
		if (!$total || $replace)
		{
			$coreFieldsSql = JPATH_ADMINISTRATOR . '/components/com_osmembership/sql/fields.osmembership.sql';
			$sql           = JFile::read($coreFieldsSql);
			$queries       = $db->splitSql($sql);
			if (count($queries))
			{
				foreach ($queries as $query)
				{
					$query = trim($query);
					if ($query != '' && $query{0} != '#')
					{
						$db->setQuery($query);
						$db->execute();
					}
				}
			}
		}

		if ($replace && $total)
		{
			foreach ($coreFields as $name => $field)
			{
				$sql = 'UPDATE #__osmembership_fields SET published=' . (int) $field->published . ' WHERE name=' . $db->quote($name);
				$db->setQuery($sql);
				$db->execute();
			}
		}

		$sql = "SELECT id, validation_rules FROM #__osmembership_fields WHERE required = 1";
		$db->setQuery($sql);
		$fields = $db->loadObjectList();
		foreach ($fields as $field)
		{
			if (empty($field->validation_rules))
			{
				$sql = 'UPDATE #__osmembership_fields SET validation_rules = "validate[required]" WHERE id=' . $field->id;
				$db->setQuery($sql);
				$db->execute();
			}
		}

		// Allow access level for custom field


		$fields = array_keys($db->getTableColumns('#__osmembership_fields'));

		if (!in_array('populate_from_group_admin', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `populate_from_group_admin` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('access', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_fields` ADD  `access` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE  #__osmembership_fields SET `access` = 1';
			$db->setQuery($sql);
			$db->execute();
		}

		####This code below is used for fixing the bugs in with not required fields in initial released of version 1.6.3##########
		$sql = "SELECT id, validation_rules FROM #__osmembership_fields WHERE required = 0";
		$db->setQuery($sql);
		$fields = $db->loadObjectList();
		foreach ($fields as $field)
		{
			if ($field->validation_rules == 'validate[required]')
			{
				$sql = 'UPDATE #__osmembership_fields SET validation_rules = "" WHERE id=' . $field->id;
				$db->setQuery($sql);
				$db->execute();
			}
		}

		$fields = array_keys($db->getTableColumns('#__osmembership_categories'));

		if (!in_array('exclusive_plans', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_categories` ADD  `exclusive_plans` TINYINT( 4 ) NOT NULL DEFAULT '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('access', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_categories` ADD  `access` TINYINT NOT NULL DEFAULT  '1';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE #__osmembership_categories SET `access`=1';
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('ordering', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_categories` ADD  `ordering` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE #__osmembership_categories SET `ordering`=id';
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('parent_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_categories` ADD  `parent_id` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('level', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_categories` ADD  `level` TINYINT( 4 ) NOT NULL DEFAULT '1';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('alias', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_categories` ADD  `alias` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'SELECT id, title FROM #__osmembership_categories';
			$db->setQuery($sql);
			$rows = $db->loadObjectList();
			if (count($rows))
			{
				foreach ($rows as $row)
				{
					$alias = JApplication::stringURLSafe($row->title);
					$sql   = 'UPDATE #__osmembership_categories SET `alias`="' . $alias . '" WHERE id=' . $row->id;
					$db->setQuery($sql);
					$db->execute();
				}
			}
		}
		#Subscription plans table
		$fields = array_keys($db->getTableColumns('#__osmembership_plans'));
		if (!in_array('subscription_length_unit', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `subscription_length_unit` CHAR(1) NULL;";
			$db->setQuery($sql);
			$db->execute();

			//Need to update the length to reflect new unit
			$sql = 'SELECT id, subscription_length FROM #__osmembership_plans';
			$db->setQuery($sql);
			$rowPlans = $db->loadObjectList();
			for ($i = 0, $n = count($rowPlans); $i < $n; $i++)
			{
				$rowPlan = $rowPlans[$i];
				list($frequency, $length) = OSMembershipHelper::getRecurringSettingOfPlan($rowPlan->subscription_length);
				$sql = 'UPDATE #__osmembership_plans SET subscription_length=' . (int) $length . ', subscription_length_unit="' . $frequency . '" WHERE id=' . $rowPlan->id;
				$db->setQuery($sql);
				$db->execute();
			}
		}
		if (!in_array('access', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `access` TINYINT NOT NULL DEFAULT  '1';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE #__osmembership_plans SET `access`=1';
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('lifetime_membership', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `lifetime_membership` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('expired_date', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `expired_date` DATETIME NULL AFTER  `price` ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('recurring_subscription', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `recurring_subscription` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('enable_renewal', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `enable_renewal` TINYINT NOT NULL DEFAULT  '1';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE `#__osmembership_plans` SET `enable_renewal`=1 ';
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('trial_amount', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `trial_amount` DECIMAL( 10, 2 ) NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('trial_duration', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `trial_duration` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('trial_duration_unit', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `trial_duration_unit` CHAR(1) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('number_payments', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `number_payments` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('subscription_complete_url', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `subscription_complete_url` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('category_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `category_id` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('send_third_reminder', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `send_third_reminder` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('alias', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `alias` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'SELECT id, title FROM #__osmembership_plans';
			$db->setQuery($sql);
			$rows = $db->loadObjectList();
			if (count($rows))
			{
				foreach ($rows as $row)
				{
					$alias = JApplication::stringURLSafe($row->title);
					$sql   = 'UPDATE #__osmembership_plans SET `alias`="' . $alias . '" WHERE id=' . $row->id;
					$db->setQuery($sql);
					$db->execute();
				}
			}
		}
		if (!in_array('tax_rate', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `tax_rate` DECIMAL( 10, 2 ) NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
			//Set tax rate for the plan from configuration
			$taxRate = (float) OSMembershipHelper::getConfigValue('tax_rate');
			if ($taxRate > 0)
			{
				$sql = 'UPDATE #__osmembership_plans SET tax_rate=' . $taxRate;
				$db->setQuery($sql);
				$db->execute();
			}
		}

		if (!in_array('notification_emails', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `notification_emails` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('paypal_email', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `paypal_email` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('terms_and_conditions_article_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `terms_and_conditions_article_id` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('payment_methods', $fields))
		{
			$sql = "ALTER TABLE `#__osmembership_plans` ADD `payment_methods` VARCHAR( 255 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('number_group_members', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `number_group_members` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'SELECT id, `params` FROM #__osmembership_plans';
			$db->setQuery($sql);
			$rowPlans = $db->loadObjectList();
			if (count($rowPlans))
			{
				foreach ($rowPlans as $rowPlan)
				{
					$params             = new Registry($rowPlan->params);
					$numberGroupMembers = (int) $params->get('max_number_group_members', 0);
					$sql                = 'UPDATE #__osmembership_plans SET number_group_members = ' . $numberGroupMembers . ' WHERE id = ' . $rowPlan->id;
					$db->setQuery($sql);
					$db->execute();
				}
			}
		}

		if (!in_array('login_redirect_menu_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `login_redirect_menu_id` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('currency', $fields))
		{
			$sql = "ALTER TABLE `#__osmembership_plans` ADD `currency` VARCHAR( 10 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('currency_symbol', $fields))
		{
			$sql = "ALTER TABLE `#__osmembership_plans` ADD `currency_symbol` VARCHAR( 20 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}
		//Change data type of short description to text, avoid support

		$sql = 'ALTER TABLE  `#__osmembership_plans` CHANGE  `short_description`  `short_description` MEDIUMTEXT  NULL DEFAULT NULL';
		$db->setQuery($sql);
		$db->execute();

		$sql = 'ALTER TABLE  `#__osmembership_fields` CHANGE  `description`  `description` MEDIUMTEXT  NULL DEFAULT NULL';
		$db->setQuery($sql);
		$db->execute();

		// Custom messages per plan
		if (!in_array('subscription_form_message', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `subscription_form_message` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('user_email_subject', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `user_email_subject` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('user_email_body', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `user_email_body` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('user_email_body_offline', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `user_email_body_offline` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('subscription_approved_email_subject', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `subscription_approved_email_subject` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('subscription_approved_email_body', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `subscription_approved_email_body` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('thanks_message', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `thanks_message` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('thanks_message_offline', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `thanks_message_offline` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('user_renew_email_subject', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `user_renew_email_subject` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('user_renew_email_body', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `user_renew_email_body` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		// Reminder email messages
		if (!in_array('first_reminder_email_subject', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `first_reminder_email_subject` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('first_reminder_email_body', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `first_reminder_email_body` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('second_reminder_email_subject', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `second_reminder_email_subject` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('second_reminder_email_body', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `second_reminder_email_body` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('third_reminder_email_subject', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `third_reminder_email_subject` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('third_reminder_email_body', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `third_reminder_email_body` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('user_renew_email_body_offline', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `user_renew_email_body_offline` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('user_upgrade_email_body', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `user_upgrade_email_body` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('user_upgrade_email_body_offline', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `user_upgrade_email_body_offline` TEXT NULL ;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('setup_fee', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `setup_fee` DECIMAL( 10, 2 ) NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('prorated_signup_cost', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `prorated_signup_cost` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('subscription_quotas', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plans` ADD  `subscription_quotas` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		// Renewal rates
		$fields = array_keys($db->getTableColumns('#__osmembership_renewrates'));
		if (!in_array('renew_option_length', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_renewrates` ADD  `renew_option_length` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			$sql = "ALTER TABLE  `#__osmembership_renewrates` ADD  `renew_option_length_unit` CHAR(1) NULL;";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'SELECT id, number_days FROM #__osmembership_renewrates';
			$db->setQuery($sql);
			$rowRenewOptions = $db->loadObjectList();
			for ($i = 0, $n = count($rowRenewOptions); $i < $n; $i++)
			{
				$rowRenewOption = $rowRenewOptions[$i];
				list($frequency, $length) = OSMembershipHelper::getRecurringSettingOfPlan($rowRenewOption->number_days);
				$sql = 'UPDATE #__osmembership_renewrates SET renew_option_length=' . (int) $length . ', renew_option_length_unit="' . $frequency . '" WHERE id=' . $rowRenewOption->id;
				$db->setQuery($sql);
				$db->execute();
			}
		}

		// Upgrade rules
		$fields = array_keys($db->getTableColumns('#__osmembership_upgraderules'));

		if (!in_array('upgrade_prorated', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_upgraderules` ADD  `upgrade_prorated` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		// Subscribers table
		$fields = array_keys($db->getTableColumns('#__osmembership_subscribers'));

		if (!in_array('tax_rate', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `tax_rate` DECIMAL( 10, 6 ) NULL DEFAULT '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('parent_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `parent_id` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('trial_payment_amount', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `trial_payment_amount` DECIMAL( 10, 6 ) NULL DEFAULT '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('payment_amount', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `payment_amount` DECIMAL( 10, 6 ) NULL DEFAULT '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('payment_currency', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `payment_currency` VARCHAR( 15 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('receiver_email', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `receiver_email` VARCHAR( 255 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('avatar', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `avatar` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('payment_made', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `payment_made` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('params', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `params` TEXT NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('recurring_profile_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `recurring_profile_id` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();
		}

		$insertCancelRecurringMessages = false;
		if (!in_array('subscription_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `subscription_id` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();

			$insertCancelRecurringMessages = true;
		}

		if (!in_array('recurring_subscription_cancelled', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `recurring_subscription_cancelled` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('renewal_count', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `renewal_count` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('from_plan_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `from_plan_id` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'SELECT id, from_plan_id FROM #__osmembership_upgraderules WHERE published = 1';
			$db->setQuery($sql);
			$upgradeRules = $db->loadObjectList();
			foreach ($upgradeRules as $rule)
			{
				$sql = 'UPDATE #__osmembership_subscribers SET from_plan_id = ' . $rule->from_plan_id . ' WHERE upgrade_option_id=' . $rule->id;
				$db->setQuery($sql);
				$db->execute();
			}
		}

		if (!in_array('membership_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `membership_id` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			//Update membership Id field
			$sql = 'SELECT id FROM #__osmembership_subscribers ORDER BY id';
			$db->setQuery($sql);
			$rows = $db->loadObjectList();
			if (count($rows))
			{
				$start = 1000;
				foreach ($rows as $row)
				{
					$sql = 'UPDATE #__osmembership_subscribers SET membership_id=' . $start . ' WHERE id=' . $row->id;
					$db->setQuery($sql);
					$db->execute();
					$start++;
				}
			}
		}

		if (!in_array('invoice_year', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `invoice_year` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE #__osmembership_subscribers SET `invoice_year` = YEAR(`created_date`)';
			$db->setQuery($sql);
			$db->execute();
		}
		if (!in_array('is_profile', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `is_profile` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'SELECT MIN(id) AS id FROM #__osmembership_subscribers WHERE user_id > 0 GROUP BY user_id';
			$db->setQuery($sql);
			$profileIds = $db->loadColumn();
			if (count($profileIds))
			{
				$sql = 'UPDATE #__osmembership_subscribers SET is_profile=1 WHERE id IN (' . implode(',', $profileIds) . ')';
				$db->setQuery($sql);
				$db->execute();
			}

			$sql = 'SELECT MIN(id) AS id FROM #__osmembership_subscribers WHERE user_id = 0 AND is_profile=0 GROUP BY email';
			$db->setQuery($sql);
			$profileIds = $db->loadColumn();
			if (count($profileIds))
			{
				$sql = 'UPDATE #__osmembership_subscribers SET is_profile=1 WHERE id IN (' . implode(',', $profileIds) . ')';
				$db->setQuery($sql);
				$db->execute();
			}
		}

		if (!in_array('invoice_number', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `invoice_number` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			//Update membership Id field
			$sql = 'SELECT id FROM #__osmembership_subscribers ORDER BY id';
			$db->setQuery($sql);
			$rows = $db->loadObjectList();
			if (count($rows))
			{
				$start = 1;
				foreach ($rows as $row)
				{
					$sql = 'UPDATE #__osmembership_subscribers SET invoice_number=' . $start . ' WHERE id=' . $row->id;
					$db->setQuery($sql);
					$db->execute();
					$start++;
				}
			}
		}

		if (!in_array('profile_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `profile_id` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'SELECT id, user_id, email FROM #__osmembership_subscribers WHERE is_profile=1';
			$db->setQuery($sql);
			$rowSubscribers = $db->loadObjectList();
			if (count($rowSubscribers))
			{
				foreach ($rowSubscribers as $rowSubscriber)
				{
					if ($rowSubscriber->user_id > 0)
					{
						$sql = 'UPDATE #__osmembership_subscribers SET profile_id=' . $rowSubscriber->id . ' WHERE email=' . $db->quote($rowSubscriber->email) . ' OR user_id=' . $rowSubscriber->user_id;
					}
					else
					{
						$sql = 'UPDATE #__osmembership_subscribers SET profile_id=' . $rowSubscriber->id . ' WHERE email=' . $db->quote($rowSubscriber->email);
					}
					$db->setQuery($sql);
					$db->execute();
				}
			}
		}

		if (!in_array('language', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `language` VARCHAR( 10 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('username', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `username` VARCHAR( 50 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('user_password', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `user_password` VARCHAR(255) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('payment_processing_fee', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `payment_processing_fee` DECIMAL( 10, 2 ) NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('group_admin_id', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `group_admin_id` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('third_reminder_sent', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `third_reminder_sent` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('first_reminder_sent_at', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `first_reminder_sent_at` DATETIME NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('second_reminder_sent_at', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `second_reminder_sent_at` DATETIME NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('third_reminder_sent_at', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `third_reminder_sent_at` DATETIME NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		$needToMigrateData = false;
		if (!in_array('plan_main_record', $fields))
		{
			$needToMigrateData = true;
			$sql               = "ALTER TABLE  `#__osmembership_subscribers` ADD  `plan_main_record` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('plan_subscription_status', $fields))
		{
			$needToMigrateData = true;
			$sql               = "ALTER TABLE  `#__osmembership_subscribers` ADD  `plan_subscription_status` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('plan_subscription_from_date', $fields))
		{
			$needToMigrateData = true;

			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `plan_subscription_from_date` DATETIME NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('plan_subscription_to_date', $fields))
		{
			$needToMigrateData = true;

			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `plan_subscription_to_date` DATETIME NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('setup_fee', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_subscribers` ADD  `setup_fee` DECIMAL( 10, 2 ) NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('plan_subscription_quotas', $fields))
		{
			$needToMigrateData = true;
			$sql               = "ALTER TABLE  `#__osmembership_subscribers` ADD  `plan_subscription_quotas` INT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		#Payment Plugins table
		$fields = array_keys($db->getTableColumns('#__osmembership_plugins'));
		if (!in_array('support_recurring_subscription', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plugins` ADD  `support_recurring_subscription` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('access', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_plugins` ADD  `access` TINYINT NOT NULL DEFAULT  '1';";
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE `#__osmembership_plugins` SET `access` = 1';
			$db->setQuery($sql);
			$db->execute();
		}

		$fields = array_keys($db->getTableColumns('#__osmembership_coupons'));

		if (!in_array('apply_for', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_coupons` ADD  `apply_for` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		$fields = array_keys($db->getTableColumns('#__osmembership_urls'));

		if (!in_array('title', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_urls` ADD  `title` VARCHAR( 255 ) NULL;";
			$db->setQuery($sql);
			$db->execute();
		}

		$recurringSupportedPlugins = array('os_paypal', 'os_authnet');
		$sql                       = 'UPDATE #__osmembership_plugins SET support_recurring_subscription=1 WHERE name IN ("' . implode('","', $recurringSupportedPlugins) . '")';
		$db->setQuery($sql);
		$db->execute();

		$sql = 'SELECT COUNT(*) FROM #__osmembership_messages';
		$db->setQuery($sql);
		$total = $db->loadResult();

		if (!$total)
		{
			$pluginsSql = JPATH_ADMINISTRATOR . '/components/com_osmembership/sql/install.messages.sql';
			$sql        = JFile::read($pluginsSql);
			$queries    = $db->splitSql($sql);
			if (count($queries))
			{
				foreach ($queries as $query)
				{
					$query = trim($query);
					if ($query != '' && $query{0} != '#')
					{
						$db->setQuery($query);
						$db->execute();
					}
				}
			}
		}

		if ($insertCancelRecurringMessages)
		{
			// Insert the cancel recurring messages to database
			$sql = "INSERT INTO `#__osmembership_messages` (`message_key`, `message`) VALUES
				('recurring_subscription_cancel_message', '<p>Your subscription for the subscription <strong>[PLAN_TITLE]</strong> has just been cancelled. Your subscription won''t be renewed anymore and will be expired at <strong>[SUBSCRIPTION_END_DATE]</strong></p>\r\n<p>Regards,</p>\r\n<p>Company Name</p>'),
				('user_recurring_subscription_cancel_subject', 'Recurring subscription cancelled confirmation'),
				('user_recurring_subscription_cancel_body', '<p>Dear <strong>[FIRST_NAME] [LAST_NAME]</strong></p>\r\n<p>Your recurring subscription for plan <strong>[PLAN_TITLE]</strong> has just been cancelled. Your subscription won''t be renewed anymore and will be expired at <strong>[SUBSCRIPTION_END_DATE]</strong></p>\r\n<p>Regards,</p>\r\n<p>Company Name</p>'),
				('admin_recurring_subscription_cancel_subject', 'Recurring subscription cancelled'),
				('admin_recurring_subscription_cancel_body', '<p>Dear Administrator</p>\r\n<p>User <strong>[FIRST_NAME] [LAST_NAME]</strong> has just cancelled his recurring subscription for <strong>[PLAN_TITLE]</strong>. His subscription will be expired at <strong>[SUBSCRIPTION_END_DATE]</strong></p>\r\n<p>Regards,</p>\r\n<p>Company Name</p>\r\n<p> </p>');
				";
			$db->setQuery($sql);
			$db->execute();
		}
		//Delete some files
		if (JFolder::exists(JPATH_ROOT . '/administrator/components/com_osmembership/libraries/legacy'))
		{
			JFolder::delete(JPATH_ROOT . '/administrator/components/com_osmembership/libraries/legacy');
		}
		if (JFile::exists(JPATH_ROOT . '/administrator/components/com_osmembership/libraries/factory.php'))
		{
			JFile::delete(JPATH_ROOT . '/administrator/components/com_osmembership/libraries/factory.php');
		}

		$publishedItems = array(
			'system' => array(
				'osmembershipreminder',
				'osmembershipupdatestatus',
				'membershippro',
			),
		);

		foreach ($publishedItems as $folder => $plugins)
		{
			foreach ($plugins as $plugin)
			{
				$query = "SELECT COUNT(*) FROM  #__extensions WHERE element=" . $db->Quote($plugin) . " AND folder=" . $db->Quote($folder);
				$db->setQuery($query);
				$count = $db->loadResult();
				if ($count)
				{
					$query = "UPDATE #__extensions SET enabled=1 WHERE element=" . $db->Quote($plugin) . " AND folder=" . $db->Quote($folder);
					$db->setQuery($query);
					$db->execute();
				}
			}
		}

		$fields = array_keys($db->getTableColumns('#__osmembership_taxes'));

		if (!in_array('vies', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_taxes` ADD  `vies` TINYINT NOT NULL DEFAULT  '0';";
			$db->setQuery($sql);
			$db->execute();
		}

		if (!in_array('state', $fields))
		{
			$sql = "ALTER TABLE  `#__osmembership_taxes` ADD  `state` VARCHAR(255) DEFAULT '';";
			$db->setQuery($sql);
			$db->execute();

			$sql = "UPDATE #__osmembership_taxes SET `state` = ''";
			$db->setQuery($sql);
			$db->execute();
		}

		$sql = 'SELECT COUNT(*) FROM #__osmembership_taxes';
		$db->setQuery($sql);
		$total = $db->loadResult();

		if (!$total)
		{
			$sql = 'SELECT id, tax_rate FROM #__osmembership_plans WHERE tax_rate > 0';
			$db->setQuery($sql);
			$taxRates = $db->loadObjectList();
			if (count($taxRates) > 0)
			{
				foreach ($taxRates as $taxRate)
				{
					$sql = "INSERT INTO #__osmembership_taxes(plan_id, country, rate, vies, published) VALUES($taxRate->id, '', $taxRate->tax_rate, 0, 1)";
					$db->setQuery($sql);
					$db->execute();
				}
			}

			$sql = 'UPDATE #__osmembership_plans SET `tax_rate` = 0';
			$db->setQuery($sql);
			$db->execute();
		}

		// Move coupons data to new structure
		$sql = 'SELECT COUNT(*) FROM #__osmembership_coupon_plans';
		$db->setQuery($sql);
		$total = $db->loadResult();

		if ($total == 0)
		{
			//Need to migrate data here
			$sql = 'INSERT INTO #__osmembership_coupon_plans(coupon_id, plan_id)
                SELECT id, plan_id FROM #__osmembership_coupons WHERE plan_id > 0
                ';
			$db->setQuery($sql);
			$db->execute();

			$sql = 'UPDATE #__osmembership_coupons SET plan_id = 1 WHERE plan_id > 0';
			$db->setQuery($sql);
			$db->execute();
		}

		// Uninstall the old plugins which is not needed from version 2.4.0
		$installer = new JInstaller();

		$plugins = array(
			array('osmembership', 'urls'),
			array('osmembership', 'articles'),
			array('osmembership', 'k2'),
			array('osmembership', 'account'),
			array('osmembership', 'invoice'),
			array('osmembership', 'membershipid'),
			array('osmembership', 'user'),
			array('osmembership', 'processrenewal'),
			array('content', 'articlerestriction'),
		);

		$query = $db->getQuery(true);
		foreach ($plugins as $plugin)
		{
			$query->clear()
				->select('extension_id')
				->from('#__extensions')
				->where($db->quoteName('folder') . ' = ' . $db->quote($plugin[0]))
				->where($db->quoteName('element') . ' = ' . $db->quote($plugin[1]));
			$db->setQuery($query);
			$id = $db->loadResult();
			if ($id)
			{
				try
				{
					$installer->uninstall('plugin', $id, 0);
				}
				catch (\Exception $e)
				{

				}
			}
		}

		$query->clear()
			->update('#__extensions')
			->set('enabled = 1')
			->where('element = "membershippro"')
			->where('folder = "installer"');
		$db->setQuery($query)
			->execute();

		// Try to delete the file com_osmembership.zip from tmp folder
		$tmpFolder = JFactory::getConfig()->get('tmp_path');
		if (!JFolder::exists($tmpFolder))
		{
			$tmpFolder = JPATH_ROOT . '/tmp';
		}
		if (file_exists($tmpFolder . '/com_osmembership.zip'))
		{
			JFile::delete($tmpFolder . '/com_osmembership.zip');
		}

		// Try to clean tmp folders
		$folders = JFolder::folders($tmpFolder);
		if (count($folders))
		{
			foreach ($folders as $installFolder)
			{
				if (strpos($installFolder, 'install_') !== false)
				{
					JFolder::delete($tmpFolder . '/' . $installFolder);
				}
			}
		}

		// Migrate currency code from plugin param to configuration
		$config = OSMembershipHelper::getConfig();
		if (empty($config->currency_code))
		{
			$query = $db->getQuery(true);
			$query->select('name, params')
				->from('#__osmembership_plugins')
				->where('published = 1');
			$db->setQuery($query);
			$plugins = $db->loadObjectList('name');

			if (isset($plugins['os_paypal']))
			{
				$params       = new Registry($plugins['os_paypal']->params);
				$currencyCode = $params->get('paypal_currency', 'USD');
			}
			elseif (isset($plugins['os_paypal_pro']))
			{
				$params       = new Registry($plugins['os_paypal_pro']->params);
				$currencyCode = $params->get('paypal_pro_currency', 'USD');
			}
			elseif ($plugins['os_payflowpro'])
			{
				$params       = new Registry($plugins['os_payflowpro']->params);
				$currencyCode = $params->get('payflow_currency', 'USD');
			}
			else
			{
				$currencyCode = 'USD';
			}

			$query->clear();
			$query->delete('#__osmembership_configs')
				->where('config_key = "currency_code"');
			$db->setQuery($query);
			$db->execute();

			$query->clear();
			$query->insert('#__osmembership_configs')
				->columns('config_key, config_value')
				->values('"currency_code", "' . $currencyCode . '"');
			$db->setQuery($query);
			$db->execute();
		}

		if (JLanguageMultilang::isEnabled())
		{
			try
			{
				OSMembershipHelper::setupMultilingual();
			}
			catch (Exception $e)
			{
				// Do nothing
			}
		}

		//Migrating permissions name, fixing bugs causes by Joomla 3.5.0
		$asset = JTable::getInstance('asset');
		$asset->loadByName('com_osmembership');
		if ($asset)
		{
			$rules        = $asset->rules;
			$rules        = str_replace('core.view_members', 'core.viewmembers', $rules);
			$asset->rules = $rules;
			$asset->store();
		}

		if (JFile::exists(JPATH_ADMINISTRATOR . '/manifests/packages/pkg_osmembership.xml'))
		{
			// Insert update site
			$tmpInstaller = new JInstaller;
			$tmpInstaller->setPath('source', JPATH_ADMINISTRATOR . '/manifests/packages');
			$file     = JPATH_ADMINISTRATOR . '/manifests/packages/pkg_osmembership.xml';
			$manifest = $tmpInstaller->isManifest($file);

			if (!is_null($manifest))
			{
				$query = $db->getQuery(true)
					->select($db->quoteName('extension_id'))
					->from($db->quoteName('#__extensions'))
					->where($db->quoteName('name') . ' = ' . $db->quote($manifest->name))
					->where($db->quoteName('type') . ' = ' . $db->quote($manifest['type']))
					->where($db->quoteName('state') . ' != -1');
				$db->setQuery($query);

				$eid = (int) $db->loadResult();

				if ($eid && $manifest->updateservers)
				{
					// Set the manifest object and path
					$tmpInstaller->manifest = $manifest;
					$tmpInstaller->setPath('manifest', $file);

					// Load the extension plugin (if not loaded yet).
					JPluginHelper::importPlugin('extension', 'joomla');

					// Fire the onExtensionAfterUpdate
					JEventDispatcher::getInstance()->trigger('onExtensionAfterUpdate', array('installer' => $tmpInstaller, 'eid' => $eid));
				}
			}
		}

		$app         = JFactory::getApplication();
		$installType = $this->input->getString('install_type', 'install');

		if ($needToMigrateData)
		{
			$query->clear()
				->select('COUNT(*)')
				->from('#__osmembership_subscribers');
			$db->setQuery($query);
			$total = (int) $db->loadResult();
			if ($total)
			{
				JFactory::getSession()->set('mp_install_type', $installType);
				$app->redirect('index.php?option=com_osmembership&task=datamigration.process');

				return;
			}
		}

		if ($installType == 'install')
		{
			$msg = JText::_('The extension was successfully installed');
		}
		else
		{
			$msg = JText::_('The extension was successfully updated');
		}

		//Redirecting users to dashboard
		$app->redirect('index.php?option=com_osmembership&view=dashboard', $msg);
	}

	/**
	 * Check and make sure only user with proper permischeckAccessPermissionsion can access to certain view
	 *
	 * @param $view
	 */
	protected function checkAccessPermission($view)
	{
		if (!OSMembershipHelper::canAccessThisView($view))
		{
			$this->app->redirect('index.php?option=com_osmembership&view=dashboard', "You don't have permission to access to this section of Membership Pro");
		}
	}
	
	/**
	 * Fix "Row size too large" issue
	 */
	public function fix_row_size()
	{
		$db = JFactory::getDbo();
		$db->setQuery('ALTER TABLE `#__osmembership_plans` ENGINE = MYISAM ROW_FORMAT = DYNAMIC');
		$db->execute();
	}
}
