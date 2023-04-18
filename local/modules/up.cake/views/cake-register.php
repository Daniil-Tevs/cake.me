<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");

if ($USER->IsAuthorized())
{
	LocalRedirect("/");
}

$APPLICATION->IncludeComponent('bitrix:main.register', '', [
	"USER_PROPERTY_NAME" => "",
	"SEF_MODE" => "N",

	"SHOW_FIELDS" => [
		0 => "EMAIL",
		2 => "PERSONAL_GENDER",
		3 => "PERSONAL_NOTES",
	],
	"REQUIRED_FIELDS" => [
		0 => "EMAIL",
		2 => "PERSONAL_GENDER",
	],
	"AUTH" => "N",
	"USE_BACKURL" => "N",
	"SUCCESS_PAGE" => "/auth/",
	"SET_TITLE" => "N",
	"USER_PROPERTY" => [],

]);


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");