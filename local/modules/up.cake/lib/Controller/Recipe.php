<?php

namespace UP\Cake\Controller;

use Up\Cake\Service\ImageService;
use Up\Cake\Service\RecipeService;
use Up\Cake\Service\UserService;

class Recipe extends \Bitrix\Main\Engine\Controller
{
	protected const COUNT_RECIPE_ON_PAGE = 4;

	public function getListAction(int $step = 1, int $userId = null,string $title = '', array $filters = []): array
	{
		if($userId !== null)
		{
			$recipeList = array_map(function($recipe) {
				return array_map(function($data) {
					return \CUtil::JSEscape($data);
				}, $recipe);
			},RecipeService::getRecipeByUserId($userId,0,$step * self::COUNT_RECIPE_ON_PAGE));
		}
		else
		{
			$recipes = RecipeService::get(0,$step * self::COUNT_RECIPE_ON_PAGE,$title,$filters);

			$recipeList = array_map(function($recipe) {
				return array_map(function($data) {
					return \CUtil::JSEscape($data);
				}, $recipe);
			},$recipes);
		}

		$imageList = [];
		$recipeId = null;
		foreach (ImageService::getByIdIn(array_map(fn($recipe) => $recipe['ID'], $recipeList)) as $img)
		{
			if($recipeId === $img['RECIPE_ID']) continue;
			$recipeId = $img['RECIPE_ID'];
			$imageList[$recipeId] = \CUtil::JSEscape(\CFile::GetPath((int)$img['IMAGE_ID']));
		}

		return [
			'recipeList' => $recipeList,
			'imageList' => $imageList,
		];
	}

	public function deleteRecipeAction(int $id,int $userId):void
	{
		if($userId === UserService::checkUserId($id))
		{
			RecipeService::deleteById($id);
		}
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