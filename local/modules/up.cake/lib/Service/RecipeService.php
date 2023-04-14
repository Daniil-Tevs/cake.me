<?php

namespace Up\Cake\Service;

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
										 ->setSelect(['*','USER','INSTRUCTIONS', 'TAGS', 'RECIPE_INGREDIENT'])
										 ->where('ID', $id)->fetchObject();
		$ingredientsIds = array_map(function($item) {return $item->getRecipeId();}, $recipe->getRecipeIngredient());
		$ingredients = RecipeIngredientTable::query()->setSelect(['INGREDIENT.NAME', 'COUNT', 'TYPE_ID'])
													 ->whereIn('RECIPE_ID', $ingredientsIds)->fetchCollection();
		return [$recipe, $ingredients];
	}
}