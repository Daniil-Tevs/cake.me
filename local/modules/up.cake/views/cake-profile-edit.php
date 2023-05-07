<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Context;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Редактировать профиль");

$AuthResult = $APPLICATION->arAuthResult;

if (!$USER->IsAuthorized())
{
	LocalRedirect("/");
}

$APPLICATION->IncludeComponent("bitrix:main.profile","flat", [
	"USER_PROPERTY_NAME" => "",
	"SET_TITLE" => "Y",
	"AJAX_MODE" => "N",
	"USER_PROPERTY" => Array(),
	"SEND_INFO" => "N",
	"CHECK_RIGHTS" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N"
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");