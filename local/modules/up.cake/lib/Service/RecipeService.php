<?php

namespace Up\Cake\Service;

use UP\Cake\Model\RecipeIngredientTable;

class RecipeService
{
	public static function get(string $title = null, $filter = null)
	{
		$recipes = \UP\Cake\Model\RecipeTable::query()->setSelect(['*','USER','TAGS']);
		if($title)
		{
			$title = mySqlHelper()->forSql('%' . $title . '%');
			$recipes->whereLike('NAME',$title);
		}
		if($filter)
		{
			$filter = mySqlHelper()->convertToDbInteger($filter);
			$recipes->whereIn('TAGS.ID',$filter);
		}
		return $recipes->fetchCollection();
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

		return [$recipe, $ingredients];
	}
}