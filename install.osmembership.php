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

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class com_osmembershipInstallerScript
{

	public static $languageFiles = array('en-GB.com_osmembership.ini');

	private $installType = null;

	/**
	 * Method to run before installing the component. Using to backup language file in this case
	 */
	public function preflight($type, $parent)
	{
		//Backup the old language file
		foreach (self::$languageFiles as $languageFile)
		{
			if (JFile::exists(JPATH_ROOT . '/language/en-GB/' . $languageFile))
			{
				JFile::copy(JPATH_ROOT . '/language/en-GB/' . $languageFile, JPATH_ROOT . '/language/en-GB/bak.' . $languageFile);
			}
		}

		$deleteFolders = array(
			JPATH_ROOT . '/components/com_osmembership/assets/validate',
			JPATH_ROOT . '/components/com_osmembership/assets/models',
			JPATH_ROOT . '/components/com_osmembership/assets/views',
			JPATH_ROOT . '/components/com_osmembership/assets/libraries',
			JPATH_ROOT . '/components/com_osmembership/views',
			JPATH_ROOT . '/components/com_osmembership/view/common',
			JPATH_ROOT . '/components/com_osmembership/emailtemplates',
			JPATH_ADMINISTRATOR . '/components/com_osmembership/controllers',
			JPATH_ADMINISTRATOR . '/components/com_osmembership/models',
			JPATH_ADMINISTRATOR . '/components/com_osmembership/views',
			JPATH_ADMINISTRATOR . '/components/com_osmembership/tables',
			JPATH_ADMINISTRATOR . '/components/com_osmembership/libraries',
			JPATH_ADMINISTRATOR . '/components/com_osmembership/view',
		);

		$deleteFiles = array(
			JPATH_ROOT . '/components/com_osmembership/helper/fields.php',
			JPATH_ROOT . '/components/com_osmembership/ipn_logs.txt',
			JPATH_ROOT . '/components/com_osmembership/views/complete/metadata.xml',
			JPATH_ROOT . '/components/com_osmembership/controller.php',
			JPATH_ADMINISTRATOR . '/components/com_osmembership/controller.php'

		);

		foreach($deleteFolders as $folder)
		{
			if (JFolder::exists($folder))
			{
				JFolder::delete($folder);
			}
		}

		foreach($deleteFiles as $file)
		{
			if (JFile::exists($file))
			{
				JFile::delete($file);
			}
		}
	}

	/**
	 * method to install the component
	 *
	 * @return void
	 */
	public function install($parent)
	{
		$this->installType = 'install';

	}

	public function update($parent)
	{
		$this->installType = 'upgrade';

	}

	/**
	 * Method to run after installing the component
	 */
	public function postflight($type, $parent)
	{
		//Restore the modified language strings by merging to language files
		$registry = new Registry();

		foreach (self::$languageFiles as $languageFile)
		{
			$backupFile  = JPATH_ROOT . '/language/en-GB/bak.' . $languageFile;
			$currentFile = JPATH_ROOT . '/language/en-GB/' . $languageFile;

			if (JFile::exists($currentFile) && JFile::exists($backupFile))
			{
				$registry->loadFile($currentFile, 'INI');
				$currentItems = $registry->toArray();
				$registry->loadFile($backupFile, 'INI');
				$backupItems = $registry->toArray();
				$items       = array_merge($currentItems, $backupItems);
				$content     = "";
				foreach ($items as $key => $value)
				{
					$content .= "$key=\"$value\"\n";
				}
				JFile::write($currentFile, $content);
			}
		}

		if (JFile::exists(JPATH_ROOT . '/components/com_osmembership/assets/css/custom.css'))
		{
			JFile::move(JPATH_ROOT . '/components/com_osmembership/com_osmembership/assets/css/custom.css', JPATH_ROOT . '/media/com_osmembership/assets/css/custom.css');
		}

		if (JFolder::exists(JPATH_ROOT . '/components/com_osmembership/assets'))
		{
			JFolder::delete(JPATH_ROOT . '/components/com_osmembership/assets');
		}

		$customCss = JPATH_ROOT . '/media/com_osmembership/assets/css/custom.css';
		if (!file_exists($customCss))
		{
			$fp = fopen($customCss, 'w');
			fclose($fp);
			@chmod($customCss, 0777);
		}		
	}
}