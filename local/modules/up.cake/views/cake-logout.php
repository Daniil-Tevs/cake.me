<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");

if ($USER->IsAuthorized())
{
	$USER->Logout();
	LocalRedirect("/");
}


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");