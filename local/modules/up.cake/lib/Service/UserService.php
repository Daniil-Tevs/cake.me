<?php

namespace Up\Cake\Service;

use UP\Cake\Model\TypeTable;

class UserService
{
	public static function checkUserId(int $recipeId): int
	{
		$userId = \UP\Cake\Model\RecipeTable::query()->setSelect(['USER_ID'])
			->where('ID', $recipeId)->fetch();

		return $userId['USER_ID'];
	}
}