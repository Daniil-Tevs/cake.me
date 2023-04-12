<?php

class CakeListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchRecipes();
		$this->includeComponentTemplate();
	}

	protected function fetchRecipes(): void
	{
		$this->arResult['RECIPES'] = \Up\Cake\Service\RecipeService::get();
	}
}