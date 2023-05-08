<?php

namespace UP\Cake\Controller;

/**
 * @global \CUser $USER
 */

use Up\Cake\Service\CommentService;
use Up\Cake\Service\UserService;

class Subs extends \Bitrix\Main\Engine\Controller
{
	protected const COUNT_COMMENTS = 10;

	public function getListAction(int $step = 1, int $userId = null, int $subs2 = null): array
	{
		if ($subs2)
		{
			$users = UserService::getUserSignList($userId, $step * self::COUNT_COMMENTS);
		}
		else
		{
			$users = UserService::getUserSubsList($userId,$step * self::COUNT_COMMENTS);
		}


		$userList = array_map(function($user) {
			$title = str_replace('\n','<br>',htmlspecialchars_decode($user['PERSONAL_NOTES']));
			$user = array_map(function($data) {
				return \CUtil::JSEscape($data);
			}, $user);
			$user['PERSONAL_NOTES'] = $title;
			return $user;
		},$users);

		$userList = array_map(function($user) {
			$user['PERSONAL_PHOTO'] = \CUtil::JSEscape(\CFile::GetPath($user['PERSONAL_PHOTO']));
			return $user;
		},$userList);
		return [
			'userList' => $userList,
		];
	}

	// public function addCommentAction(int $recipeId, string $title): bool
	// {
	// 	global $USER;
	// 	return CommentService::add($recipeId,$USER->getId(),$title);
	// }

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