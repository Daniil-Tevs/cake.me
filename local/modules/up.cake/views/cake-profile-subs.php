<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Context;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Подписки");

global $USER;

if (!$USER->IsAuthorized())
{
	LocalRedirect("/");
}

$APPLICATION->IncludeComponent("up:cake.SubsList","", []);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");