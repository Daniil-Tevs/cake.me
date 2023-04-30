<?php

class CakeDetailComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchRecipeDetail();
		$this->fetchUser();
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

	protected function fetchRecipeDetail(): void
	{
		// \Up\Cake\Service\TestImageData::addTestData();
		$imagesArray = \Up\Cake\Service\ImageService::getImageDetail($this->arParams['ID']);

		$this->arResult['RECIPE_MAIN_IMAGES'] = $imagesArray ['RECIPE_MAIN_IMAGES'];
		$this->arResult['RECIPE_INSTRUCTIONS_IMAGES'] = $imagesArray ['RECIPE_INSTRUCTIONS_IMAGES'];
		$this->arResult['RECIPE'] = \Up\Cake\Service\RecipeService::getRecipeDetailById($this->arParams['ID']);
		// $this->arResult['IMAGES'] = \Up\Cake\Service\ImageService::getById($this->arParams['ID']);
	}

	public function fetchUser(): void
	{
		global $USER;

		$this->arResult['GENDER'] = '';

		$user = CUser::GetByID($USER->GetID())->Fetch();
		if ($user['PERSONAL_PHOTO'] === null)
		{
			if ($user['PERSONAL_GENDER'] === 'M')
			{

				$this->arResult['GENDER'] = 'M';
			}
			else
			{
				$this->arResult['GENDER'] = 'F';
			}
		}

		$this->arResult['PERSONAL_PHOTO'] = $user['PERSONAL_PHOTO'];
	}
}