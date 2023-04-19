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
		$errorAuthUser = false;

		$request = Context::getCurrent()->getRequest();

		if ($request->get("success_auth") === "Y")
		{
			$successAuth = true;
		}

		$this->arResult['SUCCESS_AUTH_MESSAGE'] = $successAuth;

		if ($request->get("authUser") === "N")
		{
			$errorAuthUser = true;
		}

		$this->arResult['ERROR_AUTH_USER'] = $errorAuthUser;
	}

	protected function fetchRecipes(): void
	{
		$this->arResult['RECIPES'] = \Up\Cake\Service\RecipeService::get();
		$this->arResult['IMAGES'] = \Up\Cake\Service\ImageService::get();
	}
}