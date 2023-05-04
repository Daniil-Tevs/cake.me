<?php

namespace UP\Cake\Controller;

use Up\Cake\Service\ReactionService;

class Reaction extends \Bitrix\Main\Engine\Controller
{
	private array $reactionList = [];
	public function getLikesOfUserAction(int $userId = 0): array
	{
		return array_map(fn($reaction) => \CUtil::JSEscape($reaction['RECIPE_ID']), ReactionService::getByUserId($userId));
	}

	public function addLikeAction(int $userId = 0,int $recipeId = 0): bool
	{
		if(!in_array($recipeId, $this->reactionList, true))
		{
			db()->query("UPDATE up_cake_recipe SET REACTION = REACTION + 1 WHERE ID = {$recipeId}");
			$this->reactionList[] = $recipeId;
		}
		return ReactionService::addLike($userId, $recipeId);
	}

	public function removeLikeAction(int $userId = 0,int $recipeId = 0): void
	{
		db()->query("UPDATE up_cake_recipe SET REACTION = REACTION - 1 WHERE REACTION>0 AND ID = {$recipeId}");
		unset($this->reactionList[array_search($recipeId, $this->reactionList, true)]);
		ReactionService::removeLike($userId, $recipeId);
	}

	protected function getDefaultPreFilters()
	{
		return [
			new \Bitrix\Main\Engine\ActionFilter\HttpMethod(
				[
					\Bitrix\Main\Engine\ActionFilter\HttpMethod::METHOD_GET,
					\Bitrix\Main\Engine\ActionFilter\HttpMethod::METHOD_POST
				],
			),
			new \Bitrix\Main\Engine\ActionFilter\Csrf(),];
	}
}