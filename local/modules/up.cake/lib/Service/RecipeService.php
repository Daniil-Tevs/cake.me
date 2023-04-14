<?php

namespace Up\Cake\Service;

use Bitrix\Main\Entity\Query;
use http\QueryString;
use UP\Cake\Model\IngredientTable;
use UP\Cake\Model\RecipeIngredientTable;

class RecipeService
{
	public static function get()
	{
		return \UP\Cake\Model\RecipeTable::query()->setSelect(['*','USER'])->fetchCollection();
	}

	public static function getRecipeDetailById(int $id)
	{
		$recipe = \UP\Cake\Model\RecipeTable::query()
										 ->setSelect(['*','USER','INSTRUCTIONS', 'TAGS', 'RECIPE_INGREDIENT.RECIPE_ID'])
										 ->where('ID', $id)->fetchObject();

		$recipeId = [];
		foreach ($recipe->getRecipeIngredient() as $item)
		{
			$recipeId[] = $item->getRecipeId();
		}
		$ingredients = RecipeIngredientTable::query()->setSelect(['INGREDIENT.NAME', 'COUNT', 'TYPE_ID'])
													 ->whereIn('RECIPE_ID', $recipeId)->fetchCollection();


		$testArray = [$recipe, $ingredients];
		return $testArray;
	}
}