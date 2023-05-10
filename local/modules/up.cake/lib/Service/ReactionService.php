<?php

namespace Up\Cake\Service;

use UP\Cake\Model\ReactionTable;

class ReactionService
{

	public static function getByUserId(int $userId): array
	{
		return ReactionTable::query()->setSelect(['RECIPE_ID'])->where('USER_ID', mySqlHelper()->convertToDbInteger($userId))->fetchAll();
	}

	public static function chekUserReactionByRecipeId(int $userId,int $recipeId):bool
	{
		$result = ReactionTable::query()->setSelect(['*'])->where('USER_ID', mySqlHelper()->convertToDbInteger($userId))->where('RECIPE_ID', mySqlHelper()->convertToDbInteger($recipeId))->fetchAll();
		return !empty($result);

	}

	public static function addLike(int $userId, int $recipeId): bool
	{
		$recipeId = (int)mySqlHelper()->convertToDbInteger($recipeId);

		return ReactionTable::add([
			'USER_ID' => mySqlHelper()->convertToDbInteger($userId),
			'RECIPE_ID' => $recipeId,])->isSuccess();
	}
	public static function removeLike(int $userId, int $recipeId): bool
	{
		$userId = (int)mySqlHelper()->convertToDbInteger($userId);
		$recipeId = (int)mySqlHelper()->convertToDbInteger($recipeId);
		return ReactionTable::delete(['USER_ID'=>$userId,'RECIPE_ID'=>$recipeId])->isSuccess();
	}
}