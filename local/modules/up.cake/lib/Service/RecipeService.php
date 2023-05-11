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

		if ($title && mb_strlen(trim($title)) > 3)
		{
			$searchTitle = '';
			foreach (explode(' ',$title) as $word)
			{
				if($word === '') continue;
				$searchTitle .= mySqlHelper()->forSql($word) . '%';
			}
			$recipes->whereLike('NAME', '%'.$searchTitle.'%');
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

		return $recipes->setOffset($offset)->setLimit($limit)->setOrder(['DATE_ADDED'=>'DESC'])->fetchAll();
	}

	public static function deleteById(int $id): bool
	{
		return (RecipeTable::delete($id))->isSuccess();
	}

	public static function getRecipeByUserLikes(int $offset = 0, int $limit = 0, int $userId = 0, string $title = null, array $filter = null)
	{
		$recipeIds = array_map(fn($item)=>(int)$item['RECIPE_ID'],\UP\Cake\Model\ReactionTable::query()->setSelect(['RECIPE_ID'])->where('USER_ID',$userId)->fetchAll());
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
		)->whereIn('ID',$recipeIds);

		if ($title && strlen(trim($title)) > 3)
		{
			$searchTitle = '';
			foreach (explode(' ',$title) as $word)
			{
				if($word === '') continue;
				$searchTitle .= mySqlHelper()->forSql($word) . '%';
			}
			$recipes->whereLike('NAME', '%'.$searchTitle.'%');
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

		return $recipes->setOffset($offset)->setLimit($limit)->setOrder(['DATE_ADDED'=>'DESC'])->fetchAll();
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

	public static function getRecentRecipes(array $recipeIds): array
	{
		$recipes = [];
		foreach ($recipeIds as $id)
		{
			$id = (int)$id;
			$recipes[] = RecipeTable::query()->setSelect(['ID', 'NAME'])->where('ID', $id)->fetch();
		}
		return $recipes;
	}

	public static function checkRecentRecipes(int $recipeId)
	{
		return RecipeTable::getById($recipeId)->fetch();
	}

	public static function getRecipeDetailById(int $id): array
	{
		$recipe = \UP\Cake\Model\RecipeTable::query()->setSelect(
				['*', 'USER', 'INSTRUCTIONS', 'TAGS', 'RECIPE_INGREDIENT.RECIPE_ID']
			)->where('ID', $id)->fetchObject();

		if ($recipe === null)
		{
			return [];
		}

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

	public static function addRecipe(array $newRecipe): int
	{
		$recipe = \UP\Cake\Model\RecipeTable::createObject();
		$recipe->setName(mySqlHelper()->forSql($newRecipe['RECIPE_NAME']))->setDescription(mySqlHelper()->forSql($newRecipe['RECIPE_DESC']))
			->setTime((int)$newRecipe['RECIPE_TIME'])->setCalories((int)$newRecipe['RECIPE_CALORIES'])
			->setPortionCount((int)$newRecipe['RECIPE_PORTION'])->setUserId((int)$newRecipe["RECIPE_USER"]);
		$result = $recipe->save();
		$recipeId = $result->getId();

		for ($i = 0, $iMax = count($newRecipe['RECIPE_IMAGES_MAIN']['error']); $i < $iMax; $i++)
		{
			if ((int)$newRecipe['RECIPE_IMAGES_MAIN']['error'][$i] === 0)
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
			$tagQuery = \UP\Cake\Model\TagTable::query()->setSelect(['ID'])->whereLike('NAME', mySqlHelper()->forSql($tag))
				->fetchObject();
			if (empty($tagQuery))
			{
				continue;
			}
			$recipeTag->setRecipeId($recipeId)->setTagId($tagQuery->getId())->save();
		}


		for ($i = 0, $iMax = count($newRecipe['RECIPE_INGREDIENT']['NAME']); $i < $iMax; $i++)
		{
			$IngredientId = null;
			$recipeIngredient = \UP\Cake\Model\RecipeIngredientTable::createObject();
			$IngredientQuery = \UP\Cake\Model\IngredientTable::query()->setSelect(['ID'])
				->whereLike('NAME', mySqlHelper()->forSql($newRecipe['RECIPE_INGREDIENT']['NAME'][$i]))
				->fetchObject();

			if (empty($IngredientQuery))
			{
				$newRecipeIngredient = \UP\Cake\Model\IngredientTable::createObject();
				$newRecipeIngredient->setName(mySqlHelper()->forSql($newRecipe['RECIPE_INGREDIENT']['NAME'][$i]))->save();
				$IngredientId = $newRecipeIngredient->getId();
			}
			else
			{
				$IngredientId = $IngredientQuery->getId();
			}
			//TODO: дописать проверку на тип ингредиента
			$recipeIngredient->setRecipeId($recipeId)->setIngredientId($IngredientId)
				->setCount((float)$newRecipe['RECIPE_INGREDIENT']['VALUE'][$i])->setTypeId(mySqlHelper()->forSql($newRecipe['RECIPE_INGREDIENT']['TYPE'][$i]))->save();
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

			$instructionQuery->setDescription(mySqlHelper()->forSql($instruction))->setStep($iStep+1)->setRecipeId($recipeId)->save();
		}
		return (int)$recipeId;
	}

	public static function updateRecipe(array $updateRecipe, int $recipeId): void
	{
		//Изменение основной информации о рецепте
		$result = RecipeTable::getById($recipeId)->fetchObject()
			->setName(mySqlHelper()->forSql($updateRecipe['RECIPE_NAME']))->setDescription('')
			->setDescription(mySqlHelper()->forSql($updateRecipe['RECIPE_DESC']))->setTime((int)$updateRecipe['RECIPE_TIME'])
			->setCalories((int)$updateRecipe['RECIPE_CALORIES'])->setPortionCount((int)$updateRecipe['RECIPE_PORTION'])->save();


		//Изменение тегов
		$tagDelete = RecipeTagTable::query()->setSelect(['*'])->where('RECIPE_ID', $recipeId)->fetchCollection();
		foreach ($tagDelete as $item)
		{
			$item->delete();
		}

		foreach ($updateRecipe['RECIPE_TAGS'] as $iTag => $tag)
		{

			$recipeTag = \UP\Cake\Model\RecipeTagTable::createObject();
			$tagQuery = \UP\Cake\Model\TagTable::query()->setSelect(['ID'])->whereLike('NAME', mySqlHelper()->forSql($tag))
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
			$IngredientId = null;
			$recipeIngredient = \UP\Cake\Model\RecipeIngredientTable::createObject();
			$IngredientQuery = \UP\Cake\Model\IngredientTable::query()->setSelect(['ID'])
				->whereLike('NAME', mySqlHelper()->forSql($updateRecipe['RECIPE_INGREDIENT']['NAME'][$i]))->fetchObject();

			if (empty($IngredientQuery))
			{
				$newRecipeIngredient = \UP\Cake\Model\IngredientTable::createObject();
				$newRecipeIngredient->setName(mySqlHelper()->forSql($updateRecipe['RECIPE_INGREDIENT']['NAME'][$i]))->save();
				$IngredientId = $newRecipeIngredient->getId();
			}
			else
			{
				$IngredientId = (int)$IngredientQuery->getId();
			}

			$recipeIngredient->setRecipeId($recipeId)->setIngredientId($IngredientId)
				->setCount((float)$updateRecipe['RECIPE_INGREDIENT']['VALUE'][$i])
				->setTypeId(mySqlHelper()->forSql($updateRecipe['RECIPE_INGREDIENT']['TYPE'][$i]))->save();
		}

		//Изменение шагов
		$imageInstructIds = RecipeImageTable::query()->setSelect(['IMAGE_ID', 'NUMBER'])->where('RECIPE_ID', $recipeId)
			->where('IS_MAIN', 0)->addOrder('NUMBER', 'ASC')->fetchAll();


		$imageCount = $imageInstructIds[count($imageInstructIds)-1]['NUMBER'];
		$images = [];
		for ($i = 1; $i <= $imageCount; $i++)
		{
			foreach ($imageInstructIds as $image)
			{
				if ($i === (int)$image['NUMBER'])
				{
					$images[$i - 1] = ['IMAGE_ID' => $image['IMAGE_ID'], 'NUMBER' => $image['NUMBER']];
					break;
				}
			}
			if ($images[$i - 1] === null)
			{
				$images[$i - 1] = ['IMAGE_ID' => 0, 'NUMBER' => $i];
			}
		}

		$ingredientDelete = InstructionsTable::query()->setSelect(['ID'])
			->where('RECIPE_ID', $recipeId)->fetchCollection();

		foreach ($ingredientDelete as $item)
		{
			$item->delete();
		}

		if (count($images) > count($updateRecipe['RECIPE_INSTRUCTION']))
		{
			foreach ($images as $i => $image)
			{
				if ($i > count($updateRecipe['RECIPE_INSTRUCTION']) - 1)
				{
					CFile::Delete((int)$image['IMAGE_ID']);
				}
			}
		}

		foreach ($updateRecipe['RECIPE_INSTRUCTION'] as $iStep => $instruction)
		{
			$instructionQuery = \UP\Cake\Model\InstructionsTable::createObject();

			if ($updateRecipe['RECIPE_INSTRUCTION_IMAGES']['error'][$iStep] === 0)
			{
				if ($images[$iStep]['IMAGE_ID'] !== 0)
				{
					CFile::Delete((int)$images[$iStep]['IMAGE_ID']);
				}

				$filePath = $updateRecipe['RECIPE_INSTRUCTION_IMAGES']['tmp_name'][$iStep];
				$arFile = CFile::MakeFileArray($filePath);
				$imageId = \CFile::SaveFile($arFile, "tmp/instruction-images");

				$imageQuery = \UP\Cake\Model\RecipeImageTable::createObject();
				$imageQuery->setRecipeId($recipeId)->setImageId($imageId)->setIsMain(0)->setNumber($iStep+1)->save();
			}

			$instructionQuery->setDescription(mySqlHelper()->forSql($instruction))->setStep($iStep+1)->setRecipeId($recipeId)->save();
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

			if ((int)$updateRecipe['RECIPE_IMAGES_MAIN']['error'][$i] === 0)
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