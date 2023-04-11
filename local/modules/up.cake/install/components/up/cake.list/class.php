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
		$this->arResult['RECIPES'] = \UP\Cake\Model\RecipeTable::query()->setSelect(['*','USER'])->fetchCollection();
	}
}