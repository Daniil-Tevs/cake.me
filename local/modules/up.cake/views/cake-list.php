<?php
/**
 * @var CMain $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Cake");

$APPLICATION->IncludeComponent('up:cake.list', '', [
	'COUNT_ELEMENTS' => 3,
	'LENGTH_DESCRIPTION' => 200,
	'ENCODING' => 'UTF-8',
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>