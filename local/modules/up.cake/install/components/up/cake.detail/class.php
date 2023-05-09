<?php

use Bitrix\Main\Context;

class CakeDetailComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchRecipeDetail();
		$this->fetchUser();
		$this->addSession();
		$this->getMessage();
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

	protected function getMessage(): void
	{

		$request = Context::getCurrent()->getRequest();

		if ($request->get("create_success") === "Y")
		{
			$this->arResult['CREATE_SUCCESS'] = true;
		}

		if ($request->get("update_success") === "Y")
		{
			$this->arResult['UPDATE_SUCCESS'] = true;
		}
	}

	protected function fetchRecipeDetail(): void
	{
		$imagesArray = \Up\Cake\Service\ImageService::getImageDetail($this->arParams['ID']);

		$this->arResult['RECIPE_MAIN_IMAGES'] = $imagesArray ['RECIPE_MAIN_IMAGES'];
		$this->arResult['RECIPE_INSTRUCTIONS_IMAGES'] = $imagesArray ['RECIPE_INSTRUCTIONS_IMAGES'];
		$recipe = \Up\Cake\Service\RecipeService::getRecipeDetailById($this->arParams['ID']);

		if (empty($recipe))
		{
			LocalRedirect('/');
		}

		$this->arResult['RECIPE'] = $recipe;
	}

	protected function addSession(): void
	{
		global $USER;

		$session = \Bitrix\Main\Application::getInstance()->getSession();

		if (!empty($session->get('recent_recipe')))
		{
			if ($session->get('recent_recipe')[0]['userId'] !== $USER->GetID())
			{
				$session->remove('recent_recipe');
			}
		}

		if ($session->get('recent_recipe') === null || empty($session->get('recent_recipe')))
		{
			$session->set('recent_recipe', [['userId' => $USER->GetID(), 'recipeId' => $this->arParams['ID']]]);

		}
		elseif (!empty($session->get('recent_recipe')))
		{
			$recentRecipe = $session->get('recent_recipe');

			$isRepeatRecipe = false;
			foreach ($recentRecipe as $item)
			{
				if ($item['recipeId'] === $this->arParams['ID'])
				{
					$isRepeatRecipe = true;
					break;
				}
			}

			if ($isRepeatRecipe === false)
			{
				array_unshift($recentRecipe, ['userId' => $USER->GetID(), 'recipeId' => $this->arParams['ID']]);

				if (count($recentRecipe) === 4)
				{
					array_pop($recentRecipe);
				}

				$session->remove('recent_recipe');
				$session->set('recent_recipe', $recentRecipe);
			}
		}
	}

	protected function fetchUser(): void
	{
		global $USER;

		$userId = (int)$this->arResult['RECIPE'][0]->getUserId();

		if ((int)$USER->GetID() === $userId)
		{
			$this->arResult['USER_AUTHOR'] = true;
		}

		$this->arResult['GENDER'] = '';

		$user = CUser::GetByID($userId)->Fetch();

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