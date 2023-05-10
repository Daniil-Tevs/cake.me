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
$addRecipeAuth = false;
$checkUsersAuth = false;

$request = Context::getCurrent()->getRequest();

 if ($request->get("success_reg") === "Y")
 {
	 $successReg = true;
 }

if ($request->get("auth_user") === "N")
{
	$addRecipeAuth = true;
}

if ($request->get("check_users") === "N")
{
	$checkUsersAuth = true;
}

$APPLICATION->IncludeComponent('bitrix:system.auth.authorize', 'flat',[
	'AUTH_RESULT' => $AuthResult,
	"REGISTER_URL" => "/register/",
	"FORGOT_PASSWORD_URL" => "",
	"PROFILE_URL" => "/profile/",
	"SHOW_ERRORS" => "Y",
	"SUCCESS_REG" => $successReg,
	"ERROR_AUTH_USER_ADD_RECIPE" => $addRecipeAuth,
	"ERROR_CHECK_USERS_AUTH" => $checkUsersAuth
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");