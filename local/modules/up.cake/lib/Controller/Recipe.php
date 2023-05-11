<?php

namespace UP\Cake\Controller;

use Up\Cake\Service\ImageService;
use Up\Cake\Service\ReactionService;
use Up\Cake\Service\RecipeService;
use Up\Cake\Service\UserService;

class Recipe extends \Bitrix\Main\Engine\Controller
{
	protected const COUNT_RECIPE_ON_PAGE = 6;

	public function getListAction(int $step = 1,string $type = null, int $userId = null, int $anotherUserId = null,string $title = '', array $filters = []): array
	{
		if($type === 'anotherProfile' && $anotherUserId !== null)
		{
			$recipes = RecipeService::getRecipeByUserId($anotherUserId,($step-1) * self::COUNT_RECIPE_ON_PAGE,$step * self::COUNT_RECIPE_ON_PAGE);
		}
		elseif ($type === 'profile' && $userId !== null)
		{
			$recipes = RecipeService::getRecipeByUserId($userId,($step-1) * self::COUNT_RECIPE_ON_PAGE,$step * self::COUNT_RECIPE_ON_PAGE);
		}
		elseif ($type === 'reaction' && $userId !== null)
		{
			$recipes = RecipeService::getRecipeByUserLikes(($step-1) * self::COUNT_RECIPE_ON_PAGE,$step * self::COUNT_RECIPE_ON_PAGE,$userId,$title,$filters);
		}
		else
		{
			$recipes = RecipeService::get(($step-1) * self::COUNT_RECIPE_ON_PAGE,$step * self::COUNT_RECIPE_ON_PAGE,$title,$filters);
		}

		$recipeList = array_map(function($recipe) {
			return array_map(function($data) {
				return str_replace(['\n','\&quot;'],[' ','"'],htmlspecialcharsbx(\CUtil::JSEscape($data)));
			}, $recipe);
		},$recipes);
		$imageList = [];
		$recipeId = null;
		foreach (ImageService::getByIdIn(array_map(fn($recipe) => $recipe['ID'], $recipeList)) as $img)
		{
			if($recipeId === $img['RECIPE_ID']) continue;
			$recipeId = $img['RECIPE_ID'];
			$imageList[$recipeId] = \CUtil::JSEscape(\CFile::GetPath((int)$img['IMAGE_ID']));
		}

		static $userReactions = [];
		if(empty($userReactions))
		{
			$userReactions = array_map(fn($reaction) => (int)\CUtil::JSEscape($reaction['RECIPE_ID']), ReactionService::getByUserId($userId));
		}

		return [
			'recipeList' => $recipeList,
			'imageList' => $imageList,
			'userReactions' => $userReactions
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