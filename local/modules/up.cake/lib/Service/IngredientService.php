<?php

namespace Up\Cake\Service;

use UP\Cake\Model\IngredientTable;

class IngredientService
{
	public static function get(): array
	{
		return IngredientTable::query()->setSelect(['NAME'])->fetchAll();
	}
}