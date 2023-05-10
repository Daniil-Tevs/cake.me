<?php

use Bitrix\Main\Context;

/**
 * @global CUser $USER
 */

class RecentRecipesComponent extends CBitrixComponent
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
		// $session->remove('recent_recipe'); die();
		if (!empty($recentRecipe))
		{
			$isDeleteRecipe = false;
			foreach ($recentRecipe as $i => $item)
			{
				if (!\Up\Cake\Service\RecipeService::checkRecentRecipes((int)$item['recipeId']))
				{
					unset($recentRecipe[$i]);
					$isDeleteRecipe = true;
					continue;
				}
				if((int)$item['userId'] === (int)$USER->GetID())
				{
					$recipeIds[] = (int)$item['recipeId'];
				}
			}

			$recentRecipe = array_values($recentRecipe);
			if ($isDeleteRecipe)
			{
				$session->remove('recent_recipe');
				$session->set('recent_recipe', $recentRecipe);
			}
		}
		return $recipeIds;
	}
}