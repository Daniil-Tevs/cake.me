<?php

use Bitrix\Main\Context;

class CakeUpdateComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$request = Context::getCurrent()->getRequest();

		$this->getTags();
		$this->getTypes();
		$this->fetchRecipeDetail();

		if ($request->isPost())
		{
			if (!check_bitrix_sessid())
			{
				LocalRedirect('/?session_error=Y');
			}
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

		if ($request->get("image_error") === "Y")
		{
			$this->arResult['IMAGE_ERROR'] = true;
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
				if (strlen(trim($item)) >= 2000)
				{
					LocalRedirect("/recipe/edit/{$this->arParams['ID']}/?error_update=Y");
				}
			}
		}

		if ($errorParams !== '?')
		{
			LocalRedirect("/recipe/edit/{$this->arParams['ID']}/" . $errorParams);
		}

		if ($updateRecipe["RECIPE_NAME"] === '' || $updateRecipe["RECIPE_PORTION"] <= 0 || $updateRecipe["RECIPE_TIME"] <= 0 ||
			$updateRecipe["RECIPE_CALORIES"] < 0 || empty($updateRecipe["RECIPE_TAGS"]) || empty($updateRecipe["RECIPE_INGREDIENT"]) ||
			empty($updateRecipe["RECIPE_INSTRUCTION"]) || empty($updateRecipe["RECIPE_IMAGES_MAIN"])  ||
			strlen($updateRecipe["RECIPE_NAME"]) >= 255 || strlen($updateRecipe["RECIPE_DESC"]) >= 2000)
		{
			LocalRedirect("/recipe/edit/{$this->arParams['ID']}/?error_update=Y");
		}

		$this->imageValidate($updateRecipe['RECIPE_IMAGES_MAIN']);
		$this->imageValidate($updateRecipe['RECIPE_INSTRUCTION_IMAGES']);

		\Up\Cake\Service\RecipeService::updateRecipe($updateRecipe, $this->arParams['ID']);
		LocalRedirect("/detail/{$this->arParams['ID']}/?update_success=Y");
	}

	protected function fetchRecipeDetail(): void
	{
		$imagesArray = \Up\Cake\Service\ImageService::getImageDetail($this->arParams['ID']);
		$this->arResult['RECIPE'] = \Up\Cake\Service\RecipeService::getRecipeDetailById($this->arParams['ID']);

		$images = $this->prepareInstructionImages($imagesArray['RECIPE_INSTRUCTIONS_IMAGES']);

		$this->arResult['RECIPE_MAIN_IMAGES'] = $imagesArray ['RECIPE_MAIN_IMAGES'];
		$this->arResult['RECIPE_INSTRUCTIONS_IMAGES'] = $images;

	}

	private function prepareInstructionImages(array $imageArray): array
	{
		$imageNumber = 0;
		foreach ($imageArray as $item)
		{
			if ($item['NUMBER'] >= $imageNumber)
			{
				$imageNumber = $item['NUMBER'];
			}
		}

		$images = [];
		for ($i = 1; $i <= $imageNumber; $i++)
		{
			foreach ($imageArray as $image)
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
		return $images;
	}

	private function imageValidate(array $imageArray): void
	{
		for ($i = 0, $iMax = count($imageArray['name']); $i < $iMax; $i++)
		{
			$arrImage = [];
			if ($imageArray['error'][$i] === 4 || $imageArray['error'][$i] === 100)
			{
				continue;
			}

			$arrImage = [
				'name' => $imageArray['name'][$i],
				'size' => $imageArray['size'][$i],
				'tmp_name' => $imageArray['tmp_name'][$i],
				'type' => $imageArray['type'][$i],
				"del" => "",
				"MODULE_ID" => ""
			];

			$res = CFile::CheckImageFile($arrImage, 10485760);
			if ($res !== null)
			{
				LocalRedirect("/recipe/edit/{$this->arParams['ID']}/?image_error=Y");
			}
		}
	}
}