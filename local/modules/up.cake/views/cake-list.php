<?php
/**
 * @var CMain $APPLICATION
 */
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Tasks");

$APPLICATION->IncludeComponent('up:cake.list', '', [
	'DATE_FORMAT' => 'd.M H:i',
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>