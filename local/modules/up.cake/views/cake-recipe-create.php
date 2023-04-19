<?php
/**
 * @var CMain $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Create recipe");

$APPLICATION->IncludeComponent('up:cake.createRecipe', '', [

]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");