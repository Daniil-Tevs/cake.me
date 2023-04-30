<?php

namespace Up\Cake\Service;

use CFile;
use Up\Cake\Model\InstructionsTable;
use UP\Cake\Model\RecipeImageTable;
use UP\Cake\Model\RecipeIngredientTable;
use UP\Cake\Model\RecipeTagTable;
use UP\Cake\Model\RecipeTable;

class RecipeService
{
	public static function get(int $offset = 0, int $limit = 0, string $title = null, array $filter = null)
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

		if (!empty($filter))
		{
			$filter = array_map(fn($tag) => (int)mySqlHelper()->forSql($tag),$filter);
			$query = 'SELECT t1.RECIPE_ID FROM up_cake_recipe_tag t1 ';
			$conditional = ' WHERE ';
			$i=1;
			foreach ($filter as $tag)
			{
				if($i>1)
				{
					$query .= " INNER JOIN up_cake_recipe_tag t{$i} ";
					$conditional .= sprintf(' t%d.RECIPE_ID = t%d.RECIPE_ID AND ',$i-1,$i);
				}

				$conditional .= "t{$i}.TAG_ID = $tag";
				$conditional .= ($tag !== $filter[count($filter)-1])?" AND ":'';
				$i++;
			}
			$recipeIds = db() -> query($query . $conditional);

			$recipeIds = array_map(fn($tag)=>(int)$tag['RECIPE_ID'],$recipeIds->fetchAll());
			if(empty($recipeIds))
			{
				return [];
			}
			$recipes->whereIn('ID', $recipeIds);
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
			->setTime($newRecipe['RECIPE_TIME'])->setCalories($newRecipe['RECIPE_CALORIES'])
			->setPortionCount($newRecipe['RECIPE_PORTION'])->setUserId($newRecipe["RECIPE_USER"]);
		$result = $recipe->save();
		$recipeId = $result->getId();

		for ($i = 0, $iMax = count($newRecipe['RECIPE_IMAGES_MAIN']['error']); $i < $iMax; $i++)
		{
			if ($newRecipe['RECIPE_IMAGES_MAIN']['error'][$i] === 0)
			{
				$filePath = $newRecipe['RECIPE_IMAGES_MAIN']['tmp_name'][$i];
				$arFile = CFile::MakeFileArray($filePath);
				$imageId = \CFile::SaveFile($arFile, "tmp/main-images");

				$imageQuery = \UP\Cake\Model\RecipeImageTable::createObject();
				$imageQuery->setRecipeId($recipeId)->setImageId($imageId)->setIsMain(1)->setNumber($i+1)->save();
			}
		}

		foreach ($newRecipe['RECIPE_TAGS'] as $iTag => $tag)
		{
			$recipeTag = \UP\Cake\Model\RecipeTagTable::createObject();
			$tagQuery = \UP\Cake\Model\TagTable::query()->setSelect(['ID'])->whereLike('NAME', $tag)
				->fetchObject();
			if (empty($tagQuery))
			{
				continue;
			}
			$recipeTag->setRecipeId($recipeId)->setTagId($tagQuery->getId())->save();
		}


		for ($i = 0, $iMax = count($newRecipe['RECIPE_INGREDIENT']['NAME']); $i < $iMax; $i++)
		{
			$recipeIngredient = \UP\Cake\Model\RecipeIngredientTable::createObject();
			$IngredientQuery = \UP\Cake\Model\IngredientTable::query()->setSelect(['ID'])
				->whereLike('NAME', $newRecipe['RECIPE_INGREDIENT']['NAME'][$i])
				->fetchObject();

			if (empty($IngredientQuery))
			{
				continue;
			}
			$recipeIngredient->setRecipeId($recipeId)->setIngredientId($IngredientQuery->getId())
				->setCount($newRecipe['RECIPE_INGREDIENT']['VALUE'][$i])->setTypeId($newRecipe['RECIPE_INGREDIENT']['TYPE'][$i])->save();
		}

		foreach ($newRecipe['RECIPE_INSTRUCTION'] as $iStep => $instruction)
		{
			$instructionQuery = \UP\Cake\Model\InstructionsTable::createObject();


			if ($newRecipe['RECIPE_INSTRUCTION_IMAGES']['error'][$iStep] === 0)
			{
				$filePath = $newRecipe['RECIPE_INSTRUCTION_IMAGES']['tmp_name'][$iStep];
				$arFile = CFile::MakeFileArray($filePath);
				$imageId = \CFile::SaveFile($arFile, "tmp/instruction-images");

				$imageQuery = \UP\Cake\Model\RecipeImageTable::createObject();
				$imageQuery->setRecipeId($recipeId)->setImageId($imageId)->setIsMain(0)->setNumber($iStep+1)->save();

			}

			$instructionQuery->setDescription($instruction)->setStep($iStep+1)->setRecipeId($recipeId)->save();
		}
	}

	public static function updateRecipe(array $updateRecipe, int $recipeId): void
	{
		//Изменение основной информации о рецепте
		$result = RecipeTable::getById($recipeId)->fetchObject()
			->setName($updateRecipe['RECIPE_NAME'])->setDescription('')
			->setDescription($updateRecipe['RECIPE_DESC'])->setTime($updateRecipe['RECIPE_TIME'])
			->setCalories($updateRecipe['RECIPE_CALORIES'])->setPortionCount($updateRecipe['RECIPE_PORTION'])->save();


		//Изменение тегов
		$tagDelete = RecipeTagTable::query()->setSelect(['*'])->where('RECIPE_ID', $recipeId)->fetchCollection();
		foreach ($tagDelete as $item)
		{
			$item->delete();
		}

		foreach ($updateRecipe['RECIPE_TAGS'] as $iTag => $tag)
		{

			$recipeTag = \UP\Cake\Model\RecipeTagTable::createObject();
			$tagQuery = \UP\Cake\Model\TagTable::query()->setSelect(['ID'])->whereLike('NAME', $tag)
											   ->fetchObject();
			if (empty($tagQuery))
			{
				continue;
			}
			$recipeTag->setRecipeId($recipeId)->setTagId($tagQuery->getId())->save();
		}

		//Изменение ингредиентов
		$ingredientDelete = RecipeIngredientTable::query()->setSelect(['RECIPE_ID'])
			->where('RECIPE_ID', $recipeId)->fetchCollection();

		foreach ($ingredientDelete as $item)
		{
			$item->delete();
		}

		for ($i = 0, $iMax = count($updateRecipe['RECIPE_INGREDIENT']['NAME']); $i < $iMax; $i++)
		{
			$recipeIngredient = \UP\Cake\Model\RecipeIngredientTable::createObject();
			$IngredientQuery = \UP\Cake\Model\IngredientTable::query()->setSelect(['ID'])
				->whereLike('NAME', $updateRecipe['RECIPE_INGREDIENT']['NAME'][$i])->fetchObject();

			if (empty($IngredientQuery))
			{
				continue;
			}

			$recipeIngredient->setRecipeId($recipeId)->setIngredientId($IngredientQuery->getId())
				->setCount($updateRecipe['RECIPE_INGREDIENT']['VALUE'][$i])
				->setTypeId($updateRecipe['RECIPE_INGREDIENT']['TYPE'][$i])->save();
		}

		//Изменение шагов
		$imageInstructIds = RecipeImageTable::query()->setSelect(['IMAGE_ID'])->where('RECIPE_ID', $recipeId)
			->where('IS_MAIN', 0)->fetchAll();

		for ($i = 0, $iMax = count($imageInstructIds); $i < $iMax; $i++)
		{

			if ($i <= count($updateRecipe['RECIPE_INSTRUCTION_IMAGES']['error']) &&
				(int)$updateRecipe['RECIPE_INSTRUCTION_IMAGES']['error'][$i] === 100)
			{
				continue;
			}

			CFile::Delete($imageInstructIds[$i]['IMAGE_ID']);
		}

		$ingredientDelete = InstructionsTable::query()->setSelect(['ID'])
			->where('RECIPE_ID', $recipeId)->fetchCollection();

		foreach ($ingredientDelete as $item)
		{
			$item->delete();
		}

		foreach ($updateRecipe['RECIPE_INSTRUCTION'] as $iStep => $instruction)
		{
			$instructionQuery = \UP\Cake\Model\InstructionsTable::createObject();

			if ($updateRecipe['RECIPE_INSTRUCTION_IMAGES']['error'][$iStep] === 0)
			{
				$filePath = $updateRecipe['RECIPE_INSTRUCTION_IMAGES']['tmp_name'][$iStep];
				$arFile = CFile::MakeFileArray($filePath);
				$imageId = \CFile::SaveFile($arFile, "tmp/instruction-images");

				$imageQuery = \UP\Cake\Model\RecipeImageTable::createObject();
				$imageQuery->setRecipeId($recipeId)->setImageId($imageId)->setIsMain(0)->setNumber($iStep+1)->save();
			}

			$instructionQuery->setDescription($instruction)->setStep($iStep+1)->setRecipeId($recipeId)->save();
		}

		//изменение главных изображений
		$imageIds = RecipeImageTable::query()->setSelect(['IMAGE_ID'])->where('RECIPE_ID', $recipeId)
			->where('IS_MAIN', 1)->fetchAll();

		for ($i = 0, $iMax = count($imageIds); $i < $iMax; $i++)
		{
			if ($i <= count($updateRecipe['RECIPE_IMAGES_MAIN']['error']) &&
				(int)$updateRecipe['RECIPE_IMAGES_MAIN']['error'][$i] === 100)
			{
				continue;
			}

			CFile::Delete($imageIds[$i]['IMAGE_ID']);
		}

		for ($i = 0, $iMax = count($updateRecipe['RECIPE_IMAGES_MAIN']['error']); $i < $iMax; $i++)
		{

			if ($updateRecipe['RECIPE_IMAGES_MAIN']['error'][$i] === 0)
			{
				$filePath = $updateRecipe['RECIPE_IMAGES_MAIN']['tmp_name'][$i];
				$arFile = CFile::MakeFileArray($filePath);
				$imageId = \CFile::SaveFile($arFile, "tmp/main-images");

				$imageQuery = \UP\Cake\Model\RecipeImageTable::createObject();
				$imageQuery->setRecipeId($recipeId)->setImageId($imageId)->setIsMain(1)->setNumber($i+1)->save();
			}
		}
	}
}