<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Context;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");

$AuthResult = $APPLICATION->arAuthResult;

if (!$USER->IsAuthorized())
{
	LocalRedirect("/");
}

$APPLICATION->IncludeComponent("up:cake.profile","", []);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");