<?php

use Bitrix\Main\Context;

class CakeDetailComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$request = Context::getCurrent()->getRequest();

		$this->getTags();
		$this->getTypes();

		$this->getMessages($request);

		if ($request->isPost())
		{
			$this->createRecipe($request);

		}

		$this->includeComponentTemplate();
	}
	protected function getMessages($request): void
	{
		if ($request->get("error_create") === "Y")
		{
			$this->arResult['ERROR_CREATE'] = true;
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

	protected function createRecipe($request): void
	{
		global $USER;
		$newRecipe = [
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

		if ($newRecipe["RECIPE_NAME"] === '' || $newRecipe["RECIPE_PORTION"] <= 0 || $newRecipe["RECIPE_TIME"] <= 0 ||
			$newRecipe["RECIPE_CALORIES"] < 0 || empty($newRecipe["RECIPE_TAGS"]) || empty($newRecipe["RECIPE_INGREDIENT"]) ||
			empty($newRecipe["RECIPE_INSTRUCTION"]) || empty($newRecipe["RECIPE_IMAGES_MAIN"]) ||
			strlen($newRecipe["RECIPE_NAME"]) >= 255 || strlen($newRecipe["RECIPE_DESC"]) >= 510)
		{
			LocalRedirect('/recipe/create/?error_create=Y');
		}

		$this->imageValidate($newRecipe['RECIPE_IMAGES_MAIN']);
		$this->imageValidate($newRecipe['RECIPE_INSTRUCTION_IMAGES']);

		foreach ($newRecipe['RECIPE_INGREDIENT']['NAME'] as $i => $name)
		{
			$newRecipe['RECIPE_INGREDIENT']['NAME'][$i] = mb_strtolower(trim($name));
		}

		$recipeId = \Up\Cake\Service\RecipeService::addRecipe($newRecipe);

		LocalRedirect("/detail/{$recipeId}/?create_success=Y");
	}

	private function imageValidate(array $imageArray): void
	{
		for ($i = 0, $iMax = count($imageArray['name']); $i < $iMax; $i++)
		{
			$arrImage = [];
			if ($imageArray['error'][$i] === 4)
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
				LocalRedirect('/recipe/create/?image_error=Y');
			}
		}
	}
}