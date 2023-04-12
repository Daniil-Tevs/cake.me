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
		$this->arResult['RECIPE'] = \Up\Cake\Service\RecipeService::getRecipeDetailById(1);

		// 	'tag' => [
		// 		'выпечка',
		// 		'сладкое',
		// 	],
		// 	'ingredient' => [
		// 		['мука', 30, 'грамм'],
		// 		['яйца', 4, 'шт.'],
		// 		['какао', 1, 'чайная ложка']
		// 	],

	}
}