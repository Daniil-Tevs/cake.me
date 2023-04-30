<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;

function __cakeMigrate(int $nextVersion, callable $callback)
{
	global $DB;
	$moduleId = 'up.cake';

	if (!ModuleManager::isModuleInstalled($moduleId))
	{
		return;
	}

	$currentVersion = (int)Option::get($moduleId, '~database_schema_version', 0);

	if ($currentVersion < $nextVersion)
	{
		include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/update_class.php');
		$updater = new \CUpdater();
		$updater->Init('', 'mysql', '', '', $moduleId, 'DB');

		$callback($updater, $DB, 'mysql');
		Option::set($moduleId, '~database_schema_version', $nextVersion);
	}
}


__cakeMigrate(10, function($updater, $DB)
{
	$DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/local/modules/up.cake/install/db/test_data.sql');
});
__cakeMigrate(12, function($updater, $DB)
{
	\Up\Cake\Service\TestImageData::addTestData();
});
