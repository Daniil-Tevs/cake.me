<?php
/**
 * @var CMain $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Create recipe");

if (!$USER->IsAuthorized())
{
	LocalRedirect("/?authUser=N");
}

if ((int)$USER->GetID() !== \Up\Cake\Service\UserService::checkUserId((int)$_REQUEST['id']))
{
	LocalRedirect("/?errUserId=Y");
}

$APPLICATION->IncludeComponent('up:cake.updateRecipe', '', [
	'ID' => (int)$_REQUEST['id'],
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");