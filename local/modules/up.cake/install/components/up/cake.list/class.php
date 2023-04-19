<?php

use Bitrix\Main\Context;

class CakeListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->getMessage();
		$this->fetchRecipes();
		$this->includeComponentTemplate();


	}

	protected function getMessage(): void
	{
		$successAuth = false;
		$request = Context::getCurrent()->getRequest();

		if ($request->get("success_auth") === "Y")
		{
			$successAuth = true;
		}

		$this->arResult['AUTH_MESSAGE'] = $successAuth;
	}

	protected function fetchRecipes(): void
	{
		$this->arResult['RECIPES'] = \Up\Cake\Service\RecipeService::get();
		$this->arResult['IMAGES'] = \Up\Cake\Service\ImageService::get();
	}
}