<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");

 if ($USER->IsAuthorized())
 {
	 LocalRedirect("/");
 }

$APPLICATION->IncludeComponent('bitrix:system.auth.authorize', 'flat',[
	// 'AUTH_RESULT' => $APPLICATION->arAuthResult,
	"REGISTER_URL" => "/register/",
	"FORGOT_PASSWORD_URL" => "",
	"PROFILE_URL" => "/profile/",
	"SHOW_ERRORS" => "Y",
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");