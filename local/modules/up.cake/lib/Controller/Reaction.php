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

	public function addLikeAction(int $userId = 0,int $recipeId = 0)
	{
		if(ReactionService::addLike($userId, $recipeId))
		{
			db()->query("UPDATE up_cake_recipe SET REACTION = REACTION + 1 WHERE ID = {$recipeId}");
			$this->reactionList[] = $recipeId;
		}
	}

	public function removeLikeAction(int $userId = 0,int $recipeId = 0): void
	{
		if(ReactionService::removeLike($userId, $recipeId))
		{
			db()->query("UPDATE up_cake_recipe SET REACTION = REACTION - 1 WHERE REACTION>0 AND ID = {$recipeId}");
			unset($this->reactionList[array_search($recipeId, $this->reactionList, true)]);
		}
	}

	public function addLikeThisUserAction(int $recipeId = 0)
	{
		global $USER;
		if($USER->IsAuthorized())
		{
			$this->addLikeAction($USER->GetID(), $recipeId);
		}
	}

	public function removeLikeThisUserAction(int $recipeId = 0): void
	{
		global $USER;
		if($USER->IsAuthorized())
		{
			$this->removeLikeAction($USER->GetID(), $recipeId);
		}
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