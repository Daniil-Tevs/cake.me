<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Context;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Понравившиеся");

$AuthResult = $APPLICATION->arAuthResult;

if (!$USER->IsAuthorized())
{
	LocalRedirect("/");
}

$APPLICATION->IncludeComponent("up:cake.favorites","", []);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");