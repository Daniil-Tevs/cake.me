<?php

use Bitrix\Main\Context;

class CakeDetailComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$request = Context::getCurrent()->getRequest();

		$this->getTags();
		$this->getTypes();
		$this->fetchRecipeDetail();

		if ($request->isPost())
		{
			$this->updateRecipe($request);

		}

		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		$arParams['ID'] = (int)$arParams['ID'];
		if ($arParams['ID'] <= 0)
		{
			throw new Exception('Invalid recipe ID');
		}
		return $arParams;
	}

	protected function getTags(): void
	{
		$this->arResult['TAGS'] = \Up\Cake\Service\TagService::get();
	}

	protected function getTypes(): void
	{
		$this->arResult['TYPES'] = \Up\Cake\Service\TypeService::get();
	}

	protected function updateRecipe($request): void
	{
		global $USER;

		$imageList = [];
		foreach ($this->arResult['RECIPE_MAIN_IMAGES'] as $image)
		{
			$imageList[] = CFile::MakeFileArray($image["IMAGE_ID"]);
		}

		for ($i = 0, $iMax = count($_FILES['RECIPE_IMAGES_MAIN']['error']); $i < $iMax; $i++)
		{
			if ( $i >= count($imageList))
			{
				break;
			}

			if ($_FILES['RECIPE_IMAGES_MAIN']['error'][$i] === 4)
			{
				$_FILES['RECIPE_IMAGES_MAIN']['error'][$i] = 100;
			}
		}

		$imageList = [];
		foreach ($this->arResult['RECIPE_INSTRUCTIONS_IMAGES'] as $image)
		{
			$imageList[] = CFile::MakeFileArray($image["IMAGE_ID"]);
		}

		for ($i = 0, $iMax = count($_FILES['RECIPE_INSTRUCTION_IMAGES']['error']); $i < $iMax; $i++)
		{
			if ( $i >= count($imageList))
			{
				break;
			}

			if ($_FILES['RECIPE_INSTRUCTION_IMAGES']['error'][$i] === 4)
			{
				$_FILES['RECIPE_INSTRUCTION_IMAGES']['error'][$i] = 100;
			}
		}
		// echo '<pre>';
		// print_r($_FILES['RECIPE_IMAGES_MAIN']); die();
		$updateRecipe = [
			"RECIPE_NAME" => $request['RECIPE_NAME'],
			"RECIPE_IMAGES_MAIN" => $_FILES['RECIPE_IMAGES_MAIN'],
			"RECIPE_DESC" => $request['RECIPE_DESC'],
			"RECIPE_PORTION" => (int)$request['RECIPE_PORTION'],
			"RECIPE_TIME" => (int)$request['RECIPE_TIME'],
			"RECIPE_CALORIES" => (int)$request['RECIPE_CALORIES'],
			"RECIPE_TAGS" => $request['RECIPE_TAGS'],
			"RECIPE_INGREDIENT" => $request['RECIPE_INGREDIENT'],
			"RECIPE_INSTRUCTION" => $request['RECIPE_INSTRUCTION'],
			"RECIPE_INSTRUCTION_IMAGES" => $_FILES['RECIPE_INSTRUCTION_IMAGES'],
			"RECIPE_USER" => $USER->GetID(),
		];

		if (count($updateRecipe['RECIPE_TAGS']) !== count(array_unique($updateRecipe['RECIPE_TAGS'])))
		{
			LocalRedirect("/recipe/update/{$this->arParams['ID']}/?duplicate=Y");
		}
		if (count($updateRecipe['RECIPE_INGREDIENT']['NAME']) !== count(array_unique($updateRecipe['RECIPE_INGREDIENT']['NAME'])))
		{
			LocalRedirect("/recipe/update/{$this->arParams['ID']}/?duplicate=Y");
		}
		foreach ($updateRecipe["RECIPE_INSTRUCTION"] as $item)
		{
			if (trim($item) === '')
			{
				LocalRedirect("/recipe/update/{$this->arParams['ID']}/?errInstruction=Y");
			}
		}

		\Up\Cake\Service\RecipeService::updateRecipe($updateRecipe, $this->arParams['ID']);
		LocalRedirect('/?updateSuccess=Y');
	}

	protected function fetchRecipeDetail(): void
	{
		$imagesArray = \Up\Cake\Service\ImageService::getImageDetail($this->arParams['ID']);

		$this->arResult['RECIPE_MAIN_IMAGES'] = $imagesArray ['RECIPE_MAIN_IMAGES'];
		$this->arResult['RECIPE_INSTRUCTIONS_IMAGES'] = $imagesArray ['RECIPE_INSTRUCTIONS_IMAGES'];
		$this->arResult['RECIPE'] = \Up\Cake\Service\RecipeService::getRecipeDetailById($this->arParams['ID']);
	}
}