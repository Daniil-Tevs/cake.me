<?php

class CakeSearchComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchResultSearch();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams): array
	{
		$arParams['TITLE'] = request()->get('search-string');
		$arParams['FILTER'] = request()->get('filter');
		return $arParams;
	}

	protected function fetchResultSearch(): void
	{
		$this->arResult['RECIPES'] = \Up\Cake\Service\RecipeService::get($this->arParams['TITLE'],$this->arParams['FILTER']);
		$this->arResult['IMAGES'] = \Up\Cake\Service\ImageService::get();
	}
}