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
										 ->setSelect(['*','USER','INSTRUCTIONS', 'TAGS', 'RECIPE_INGREDIENT'])
										 ->where('ID', $id)->fetchObject();
		$ingredients = [];
		foreach ($recipe->getRecipeIngredient() as $item)
		{
			$ingredientId = $item->getIngredientId();
			$ingredientName = IngredientTable::query()->setSelect(['NAME'])->fetchObject()->getName();
			$ingredients[] = [
				'NAME' => $ingredientName,
				'COUNT' => $item->getCount(),
				'TYPE' =>$item->getTypeId(),
			];
		}
		var_dump($ingredients); die;
		return $recipe;
	}
}