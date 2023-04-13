<?php

namespace Up\Cake\Service;

class RecipeService
{
	public static function get()
	{
		return \UP\Cake\Model\RecipeTable::query()->setSelect(['*','USER'])->fetchCollection();
	}

	public static function getRecipeDetailById(int $id)
	{
		return \UP\Cake\Model\RecipeTable::query()->setSelect(['*','USER','INSTRUCTIONS', 'TAGS'])
												  ->where('ID', $id)->fetchObject();
	}
}