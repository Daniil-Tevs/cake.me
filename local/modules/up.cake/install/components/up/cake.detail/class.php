<?php

class CakeDetailComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchRecipeDetail();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		$arParams['ID'] = (int)$arParams['ID'];
		if ($arParams['ID'] <= 0)
		{
			throw new Exception('Invalid recipe ID');
		}
		return $arParams;
	}

	protected function fetchRecipeDetail(): void
	{
		$this->arResult['RECIPE'] = \Up\Cake\Service\RecipeService::getRecipeDetailById($this->arParams['ID']);
		$this->arResult['IMAGES'] = \Up\Cake\Service\ImageService::getById($this->arParams['ID']);
	}
}