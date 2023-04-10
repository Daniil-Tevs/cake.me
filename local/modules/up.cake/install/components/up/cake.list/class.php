<?php

class CakeListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchRecepies();
		$this->includeComponentTemplate();
	}

	protected function fetchRecepies()
	{
		$this->arResult['RECEPIES'] = [
			'1' => [
				'NAME' => 'name',
				'DESCRIPTION' => 'asdasda',
			]
		];
	}
}