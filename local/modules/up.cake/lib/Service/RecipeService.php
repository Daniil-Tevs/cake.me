<?php

namespace Up\Cake\Service;

use CFile;
use UP\Cake\Model\RecipeImageTable;
use UP\Cake\Model\RecipeIngredientTable;

class RecipeService
{
	public static function get(int $offset = 0, int $limit = 0, string $title = null, $filter = null)
	{
		$recipes = \UP\Cake\Model\RecipeTable::query()->setSelect(
			[
				'ID','NAME',
				'DESCRIPTION',
				'TIME','REACTION',
				'CALORIES','PORTION_COUNT',
				'USER_ID',
				'DATE_ADDED','DATE_UPDATED',
				'USER',
			]
		);
		if ($title)
		{
			$title = mySqlHelper()->forSql('%' . $title . '%');
			$recipes->whereLike('NAME', $title);
		}
		if ($filter)
		{
			$filter = mySqlHelper()->convertToDbInteger($filter);
			$recipes->whereIn('TAGS.ID', $filter);
		}
		return $recipes->setOffset($offset)->setLimit($limit)->fetchAll();
	}

	public static function getRecipeByUserId(int $id,int $offset = 0, int $limit = 0)
	{
		return \UP\Cake\Model\RecipeTable::query()->setSelect(
			[
				'ID','NAME',
				'DESCRIPTION',
				'TIME','REACTION',
				'CALORIES','PORTION_COUNT',
				'USER_ID',
				'DATE_ADDED','DATE_UPDATED',
				'USER',
			]
		)->whereIn('USER_ID',$id)->setOffset($offset)->setLimit($limit)->fetchAll();
	}

	public static function getRecipeDetailById(int $id)
	{
		$recipe = \UP\Cake\Model\RecipeTable::query()->setSelect(
				['*', 'USER', 'INSTRUCTIONS', 'TAGS', 'RECIPE_INGREDIENT.RECIPE_ID']
			)->where('ID', $id)->fetchObject();

		$recipeId = [];
		foreach ($recipe->getRecipeIngredient() as $item)
		{
			$recipeId[] = $item->getRecipeId();
		}
		$ingredients = RecipeIngredientTable::query()->setSelect(['INGREDIENT.NAME', 'COUNT', 'TYPE_ID'])->whereIn(
				'RECIPE_ID',
				$recipeId
			)->fetchCollection();

		return [$recipe, $ingredients];
	}

	public static function addRecipe(array $newRecipe): void
	{
		$recipe = \UP\Cake\Model\RecipeTable::createObject();
		$recipe->setName($newRecipe['RECIPE_NAME'])->setDescription($newRecipe['RECIPE_DESC'])
			->setTime($newRecipe['RECIPE_TIME'])->setCalories(['RECIPE_CALORIES'])
			->setPortionCount(['RECIPE_PORTION'])->setUserId($newRecipe["RECIPE_USER"]);
		$result = $recipe->save();
		$recipeId = $result->getId();

		for ($i = 1, $iMax = count($newRecipe['RECIPE_IMAGES_MAIN']['error']); $i <= $iMax; $i++)
		{
			if ($newRecipe['RECIPE_IMAGES_MAIN']['error'][$i] === 0)
			{
				$filePath = $newRecipe['RECIPE_IMAGES_MAIN']['tmp_name'][$i];
				$arFile = CFile::MakeFileArray($filePath);
				$imageId = \CFile::SaveFile($arFile, "tmp/main-images");

				$imageQuery = \UP\Cake\Model\RecipeImageTable::createObject();
				$imageQuery->setRecipeId($recipeId)->setImageId($imageId)->setIsMain(1)->setNumber($i)->save();
			}
		}

		foreach ($newRecipe['RECIPE_TAGS'] as $iTag => $tag)
		{
			$recipeTag = \UP\Cake\Model\RecipeTagTable::createObject();
			$tagQuery = \UP\Cake\Model\TagTable::query()->setSelect(['ID'])->whereLike('NAME', $tag)
				->fetchObject();
			if (empty($tagQuery))
			{
				//TODO: добавить обработку нулевых значений
			}
			$recipeTag->setRecipeId($recipeId)->setTagId($tagQuery->getId())->save();
		}


		for ($i = 1, $iMax = count($newRecipe['RECIPE_INGREDIENT']['NAME']); $i <= $iMax; $i++)
		{
			$recipeIngredient = \UP\Cake\Model\RecipeIngredientTable::createObject();
			$IngredientQuery = \UP\Cake\Model\IngredientTable::query()->setSelect(['ID'])
				->whereLike('NAME', $newRecipe['RECIPE_INGREDIENT']['NAME'][$i])
				->fetchObject();

			if (empty($tagQuery))
			{
				//TODO: добавить обработку нулевых значений
			}
			$recipeIngredient->setRecipeId($recipeId)->setIngredientId($IngredientQuery->getId())
				->setCount($newRecipe['RECIPE_INGREDIENT']['VALUE'][$i])->setTypeId($newRecipe['RECIPE_INGREDIENT']['TYPE'][$i])->save();
		}

		foreach ($newRecipe['RECIPE_INSTRUCTION'] as $iStep => $instruction)
		{
			$instructionQuery = \UP\Cake\Model\InstructionsTable::createObject();

			//TODO: добавить добавление изображений

			if ($newRecipe['RECIPE_INSTRUCTION_IMAGES']['error'][$iStep] === 0)
			{
				$filePath = $newRecipe['RECIPE_INSTRUCTION_IMAGES']['tmp_name'][$iStep];
				$arFile = CFile::MakeFileArray($filePath);
				$imageId = \CFile::SaveFile($arFile, "tmp/instruction-images");

				$imageQuery = \UP\Cake\Model\RecipeImageTable::createObject();
				$imageQuery->setRecipeId($recipeId)->setImageId($imageId)->setIsMain(0)->setNumber($iStep)->save();

			}

			$instructionQuery->setDescription($instruction)->setStep($iStep)->setRecipeId($recipeId)->save();
		}

	}
}