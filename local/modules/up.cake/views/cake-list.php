<?php
/**
 * @var CMain $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Cake.Me");

$APPLICATION->IncludeComponent('up:cake.list', '', []);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>