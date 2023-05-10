<?php
/**
 * @var CMain $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Создать рецепт");

if (!$USER->IsAuthorized())
{
	LocalRedirect("/auth/?auth_user=N");
}

$APPLICATION->IncludeComponent('up:cake.createRecipe', '', [

]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");