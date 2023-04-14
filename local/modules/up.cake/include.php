<?php

use Bitrix\Main\Application;
use Bitrix\Main\DB\Connection;
use Bitrix\Main\Request;

function request(): Request
{
	return Application::getInstance()->getContext()->getRequest();
}

function db(): Connection
{
	return Application::getConnection();
}

function mySqlHelper(): \Bitrix\Main\DB\MysqliSqlHelper
{
	return new \Bitrix\Main\DB\MysqliSqlHelper(db());
}

if (file_exists(__DIR__ . '/module_updater.php'))
{
	include(__DIR__ . '/module_updater.php');
}

