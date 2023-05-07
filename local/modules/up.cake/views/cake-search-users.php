<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Context;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Поиск пользователей");

global $USER;
$AuthResult = $APPLICATION->arAuthResult;

if (!$USER->IsAuthorized())
{
	LocalRedirect("/");
}

$APPLICATION->IncludeComponent("up:cake.searchUsers","", []);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");