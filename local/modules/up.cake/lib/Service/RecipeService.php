<?php

namespace Up\Cake\Service;

use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\Type\DateTime;
use UP\Cake\Model\RecipeTable;

class RecipeService
{
	public static function getRecipeDetailById(int $id) : array
	{

		$recipe = RecipeTable::query()
						  ->setSelect(['*'])
						  ->where('ID', $id)
						  ->fetchCollection();

		$recipeArray = [];
		$recipe->fillInstructions();

		foreach ($recipe as $item)
		{
			echo $item->getId();
			$item->getInstructions()->getStep();
			// $recipeArray[] = [
			// 	'ID' => $item->getId(),
			// 	'NAME' => $item->getName(),
			// 	'INSTRUCTIONS_STEP' => $item->getInstructions()->getDescription(),
			// ];
		}
		echo '<pre>';
		print_r($recipeArray);
		die();

		return $recipeArray;
	}
}