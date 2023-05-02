<?php

namespace Up\Cake\Service;

use UP\Cake\Model\CommentTable;

class CommentService
{
	public static function getByRecipeId(int $id, int $limit = null): array
	{
		return CommentTable::query()->setSelect(['*','USER'])->where('RECIPE_ID', (int)mySqlHelper()->forSql($id))
			->setOrder(['DATE_ADDED'=>'DESC'])->setLimit($limit)->fetchAll();
	}

	public static function add(int $recipeId, int $userId, string $title): bool
	{
		return CommentTable::add([
			'RECIPE_ID' => (int)mySqlHelper()->forSql($recipeId),
			'USER_ID' => (int)mySqlHelper()->forSql($userId),
			'TITLE' => mySqlHelper()->forSql(trim($title)),
		])->isSuccess();
	}
}