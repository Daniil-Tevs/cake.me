<?php

use Bitrix\Main\Context;

class CakeFavoritesComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		global $USER;
		$arParams['USER'] = $USER->getId() ?? 0;
		return $arParams;
	}
}