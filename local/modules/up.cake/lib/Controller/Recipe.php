<?php

namespace UP\Cake\Controller;

use Up\Cake\Service\ImageService;
use Up\Cake\Service\RecipeService;

class Recipe extends \Bitrix\Main\Engine\Controller
{
	protected const COUNT_RECIPE_ON_PAGE = 4;

	public function getListAction(int $step = 1): array
	{
		$recipeList = array_map(function($recipe) {
			return array_map(function($data) {
				return \CUtil::JSEscape($data);
			}, $recipe);
		},RecipeService::get(0,$step * self::COUNT_RECIPE_ON_PAGE));

		$imageList = array_map(function($img) {
			return \CUtil::JSEscape($img);
		},ImageService::getByIdIn(array_map(fn($recipe) => $recipe['ID'], $recipeList)));

		return [
			'recipeList' => $recipeList,
			'imageList' => $imageList,
		];
	}

	protected function getDefaultPreFilters()
	{
		return [
			new \Bitrix\Main\Engine\ActionFilter\HttpMethod(
				[
					\Bitrix\Main\Engine\ActionFilter\HttpMethod::METHOD_GET,
					\Bitrix\Main\Engine\ActionFilter\HttpMethod::METHOD_POST
				],
			),
			new \Bitrix\Main\Engine\ActionFilter\Csrf(),];
	}

}