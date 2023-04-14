<?php

namespace Up\Cake\Service;

use UP\Cake\Model\RecipeIngredientTable;

class TagService
{
	public static function get()
	{
		return \UP\Cake\Model\TagTable::query()->setSelect(['*'])->fetchCollection();
	}
}