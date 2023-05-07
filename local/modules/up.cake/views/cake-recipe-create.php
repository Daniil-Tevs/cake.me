<?php
/**
 * @var CMain $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Создать рецепт");

if (!$USER->IsAuthorized())
{
	LocalRedirect("/?authUser=N");
}

$APPLICATION->IncludeComponent('up:cake.createRecipe', '', [

]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");