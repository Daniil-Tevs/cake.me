<?php
/**
 * @var CMain $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");

$APPLICATION->IncludeComponent('up:cake.search', '', [
	'COUNT_ELEMENTS' => 3,
	'LENGTH_DESCRIPTION' => 200,
	'ENCODING' => 'UTF-8',
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>