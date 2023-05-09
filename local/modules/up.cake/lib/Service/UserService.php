<?php

namespace Up\Cake\Service;

use Bitrix\Main\ORM\Query\Query;
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

	public static function createSubs(int $userId, int $subId): bool
	{
		$query = UserSubsTable::query()->setSelect(['*'])->where('USER_ID', $userId)
			->where('SUB_ID', $subId)->fetchObject();
		$result = $query->delete();

		return $result->isSuccess();
	}

	public static function getUserList(string $search): array
	{
		$search = mySqlHelper()->forSql($search);
		$userList = UserTable::query()
			->setSelect(['ID', 'LOGIN', 'NAME', 'LOGIN', 'LAST_NAME', 'PERSONAL_GENDER', 'PERSONAL_PHOTO', 'PERSONAL_NOTES']);

		if ($search[0] === '@')
		{
			$search = substr($search, 1);
			$search = mySqlHelper()->forSql($search);

			$userList = $userList->whereLike('LOGIN', $search)->setLimit(10)->fetchAll();

			return $userList;
		}

		$searchArray = explode(' ', $search);
		$queryArray = [];
		foreach ($searchArray as $item)
		{
			if ($item === '')
			{
				continue;
			}
			$item = mySqlHelper()->forSql($item);
			$queryArray[] = ['NAME', 'like', "%$item%"];
			$queryArray[] = ['LAST_NAME', 'like', "%$item%"];
			$queryArray[] = ['LOGIN', 'like', "%$item%"];
		}
		// echo '<pre>';
		// print_r($queryArray); die();

		$userList = $userList->where(Query::filter()->logic('or')->where($queryArray));

		$userList = $userList->setLimit(21)->fetchAll();

		return $userList;
	}

	public static function getUserSubsList(int $userId, int $limit = null): array
	{
		$subsList = UserSubsTable::query()->setSelect(['SUB_ID'])->where('USER_ID', $userId)->setLimit($limit)->fetchAll();

		$subsId = [];
		foreach ($subsList as $item)
		{
			$subsId[] = (int)$item['SUB_ID'];
		}

		if (empty($subsId))
		{
			return [];
		}
		$userList = UserTable::query()
			->setSelect(['ID', 'LOGIN', 'NAME', 'LOGIN', 'LAST_NAME', 'PERSONAL_GENDER', 'PERSONAL_PHOTO', 'PERSONAL_NOTES'])
			->whereIn('ID', $subsId)->fetchAll();

		return $userList;
	}

	public static function getUserSignList(int $userId, int $limit = null): array
	{
		$subsList = UserSubsTable::query()->setSelect(['USER_ID'])->where('SUB_ID', $userId)->setLimit($limit)->fetchAll();

		$subsId = [];
		foreach ($subsList as $item)
		{
			$subsId[] = (int)$item['USER_ID'];
		}

		if (empty($subsId))
		{
			return [];
		}
		$userList = UserTable::query()
							 ->setSelect(['ID', 'LOGIN', 'NAME', 'LOGIN', 'LAST_NAME', 'PERSONAL_GENDER', 'PERSONAL_PHOTO', 'PERSONAL_NOTES'])
							 ->whereIn('ID', $subsId)->fetchAll();

		return $userList;
	}
}