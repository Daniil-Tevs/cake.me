<?php
/**
 * @var CMain $APPLICATION
 */
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("DetailPage");

$APPLICATION->IncludeComponent('up:cake.detail', '', [
	'ID' => (int)$_REQUEST['id'],
]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");