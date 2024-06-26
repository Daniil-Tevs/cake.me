<?php
/**
 * @var CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Context;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Страница пользователя");

global $USER;
$AuthResult = $APPLICATION->arAuthResult;

if (!$USER->IsAuthorized())
{
	LocalRedirect("/auth/?check_users=N");
}

if ((int)$USER->GetID() === (int)$_REQUEST['id'])
{
	LocalRedirect("/profile/");
}

$APPLICATION->IncludeComponent("up:cake.users","", [
	'ID' => (int)$_REQUEST['id'],
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");