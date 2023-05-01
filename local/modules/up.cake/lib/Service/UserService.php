<?php

namespace Up\Cake\Service;

use UP\Cake\Model\UserSubsTable;
use UP\Cake\Model\UserTable;

class UserService
{
	public static function checkUserId(int $recipeId): int
	{
		$userId = \UP\Cake\Model\RecipeTable::query()->setSelect(['USER_ID'])
			->where('ID', $recipeId)->fetch();

		return $userId['USER_ID'] ?? 0;
	}

	public static function checkSubs(int $userId, int $subId): bool
	{

		$query = UserSubsTable::query()->setSelect(['*'])->where('USER_ID', $userId)
			->where('SUB_ID', $subId)->fetch();

		if ($query === false)
		{
			return false;
		}

		return true;
	}

	public static function addSubs(int $userId, int $subId): bool
	{
		$subsTable = \UP\Cake\Model\UserSubsTable::createObject();
		$subsTable->setUserId($userId)->setSubId($subId);
		$result = $subsTable->save();

		return $result->isSuccess();
	}

	public static function createSubs($userId, $subId): bool
	{
		$query = UserSubsTable::query()->setSelect(['*'])->where('USER_ID', $userId)
			->where('SUB_ID', $subId)->fetchObject();
		$result = $query->delete();

		return $result->isSuccess();
	}
}