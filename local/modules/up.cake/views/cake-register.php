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
		0 => "NAME",
		1 => "LAST_NAME",
		2 => "PERSONAL_GENDER",
		3 => "PERSONAL_NOTES",
		4 => "PERSONAL_CITY",
		5 => "EMAIL",

	],
	"REQUIRED_FIELDS" => [
		0 => "NAME",
		1 => "LAST_NAME",
		2 => "PERSONAL_GENDER",
		5 => "EMAIL",
	],
	"AUTH" => "N",
	"USE_BACKURL" => "N",
	"SUCCESS_PAGE" => "/auth/?success_reg=Y",
	"SET_TITLE" => "N",
	"USER_PROPERTY" => [],

]);


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");