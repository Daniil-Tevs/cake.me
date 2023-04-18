<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Context;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");

$AuthResult = $APPLICATION->arAuthResult;

 if ($USER->IsAuthorized())
 {
	 if($AuthResult === true)
	 {
		 LocalRedirect("/?success_auth=Y");
	 }

	 LocalRedirect("/");
 }

$successReg = false;
$request = Context::getCurrent()->getRequest();

 if ($request->get("success_reg") === "Y")
 {
	 $successReg = true;
 }

$APPLICATION->IncludeComponent('bitrix:system.auth.authorize', 'flat',[
	'AUTH_RESULT' => $AuthResult,
	"REGISTER_URL" => "/register/",
	"FORGOT_PASSWORD_URL" => "",
	"PROFILE_URL" => "/profile/",
	"SHOW_ERRORS" => "Y",
	"SUCCESS_REG" => $successReg,
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");