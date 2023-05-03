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

		$this->getMessage($request);

		$this->includeComponentTemplate();
	}

	protected function getMessage($request)
	{
		$errorDuplicate = false;
		$errorEmptyInstruction = false;
		$errorEmptyBlocks = false;

		if ($request->get("duplicate") === "Y")
		{
			$errorDuplicate = true;
			$this->arResult['ERROR_MESSAGE'][0] = $errorDuplicate;
		}

		if ($request->get("emptyInstruction") === "Y")
		{
			$errorEmptyInstruction = true;
			$this->arResult['ERROR_MESSAGE'][1] = $errorEmptyInstruction;
		}

		if ($request->get("emptyBlocks") === "Y")
		{
			$errorEmptyBlocks = true;
			$this->arResult['ERROR_MESSAGE'][2] = $errorEmptyBlocks;
		}

	if ($request->get("error_update") === "Y")
	{
		$this->arResult['ERROR_MESSAGE'][3] = true;
	}
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

		$updateRecipe = [
			"RECIPE_NAME" => trim($request['RECIPE_NAME']),
			"RECIPE_IMAGES_MAIN" => $_FILES['RECIPE_IMAGES_MAIN'],
			"RECIPE_DESC" => trim($request['RECIPE_DESC']),
			"RECIPE_PORTION" => (int)$request['RECIPE_PORTION'],
			"RECIPE_TIME" => (int)$request['RECIPE_TIME'],
			"RECIPE_CALORIES" => (int)$request['RECIPE_CALORIES'],
			"RECIPE_TAGS" => $request['RECIPE_TAGS'],
			"RECIPE_INGREDIENT" => $request['RECIPE_INGREDIENT'],
			"RECIPE_INSTRUCTION" => $request['RECIPE_INSTRUCTION'],
			"RECIPE_INSTRUCTION_IMAGES" => $_FILES['RECIPE_INSTRUCTION_IMAGES'],
			"RECIPE_USER" => $USER->GetID(),
		];

		foreach ($updateRecipe['RECIPE_INGREDIENT']['NAME'] as $i => $name)
		{
			$updateRecipe['RECIPE_INGREDIENT']['NAME'][$i] = mb_strtolower(trim($name));
		}

		$errorParams = '?';

		if (empty($updateRecipe['RECIPE_INGREDIENT']) || empty($updateRecipe['RECIPE_INSTRUCTION']))
		{
			$errorParams .= 'emptyBlocks=Y';
		}

		if (count($updateRecipe['RECIPE_TAGS']) !== count(array_unique($updateRecipe['RECIPE_TAGS'])) ||
			count($updateRecipe['RECIPE_INGREDIENT']['NAME']) !== count(array_unique($updateRecipe['RECIPE_INGREDIENT']['NAME'])))
		{
			$errorParams .= "&duplicate=Y";
		}

		if (!empty($updateRecipe["RECIPE_INSTRUCTION"]))
		{
		foreach ($updateRecipe["RECIPE_INSTRUCTION"] as $item)
			{
				if (trim($item) === '')
				{
					$errorParams .= '&emptyInstruction=Y';
				}
			}
		}

		if ($errorParams !== '?')
		{
			LocalRedirect("/recipe/edit/{$this->arParams['ID']}/" . $errorParams);
		}

		if ($updateRecipe["RECIPE_NAME"] === '' || $updateRecipe["RECIPE_PORTION"] <= 0 || $updateRecipe["RECIPE_TIME"] <= 0 ||
			$updateRecipe["RECIPE_CALORIES"] < 0 || empty($updateRecipe["RECIPE_TAGS"]) || empty($updateRecipe["RECIPE_INGREDIENT"]) ||
			empty($updateRecipe["RECIPE_INSTRUCTION"]) || empty($updateRecipe["RECIPE_IMAGES_MAIN"]))
		{
			LocalRedirect("/recipe/edit/{$this->arParams['ID']}/?error_update=Y");
		}

		\Up\Cake\Service\RecipeService::updateRecipe($updateRecipe, $this->arParams['ID']);
		LocalRedirect('/?update_success=Y');
	}

	protected function fetchRecipeDetail(): void
	{
		$imagesArray = \Up\Cake\Service\ImageService::getImageDetail($this->arParams['ID']);

		$this->arResult['RECIPE_MAIN_IMAGES'] = $imagesArray ['RECIPE_MAIN_IMAGES'];
		$this->arResult['RECIPE_INSTRUCTIONS_IMAGES'] = $imagesArray ['RECIPE_INSTRUCTIONS_IMAGES'];
		$this->arResult['RECIPE'] = \Up\Cake\Service\RecipeService::getRecipeDetailById($this->arParams['ID']);
	}
}