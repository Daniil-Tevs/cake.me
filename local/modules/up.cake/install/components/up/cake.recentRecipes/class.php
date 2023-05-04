<?php

use Bitrix\Main\Context;

/**
 * @global CUser $USER
 */

class RecentRecipes extends CBitrixComponent
{
	public function executeComponent()
	{
		$session = \Bitrix\Main\Application::getInstance()->getSession();

		$recipeIds = $this->getSession($session);
		if (!empty($recipeIds))
		{
			$this->getRecipes($recipeIds);
		}
		$this->includeComponentTemplate();
	}

	protected function getRecipes($recipeIds): void
	{
		$this->arResult['RECIPES'] = \Up\Cake\Service\RecipeService::getRecentRecipes($recipeIds);
		$this->arResult['IMAGES'] = \Up\Cake\Service\ImageService::getRecentImages($recipeIds);
	}

	protected function getSession($session): array
	{
		global $USER;

		$recentRecipe = $session->get('recent_recipe');
		$recipeIds = [];

		if (!empty($recentRecipe))
		{
			foreach ($recentRecipe as $item)
			{
				if((int)$item['userId'] === (int)$USER->GetID())
				{
					$recipeIds[] = (int)$item['recipeId'];
				}
			}
		}
		return $recipeIds;
		// $this->arResult['USER_REQUEST'] = true;
		// $this->arResult['USERS'] = $userList;
	}
}