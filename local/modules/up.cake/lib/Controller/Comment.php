<?php

namespace UP\Cake\Controller;

/**
 * @global \CUser $USER
 */

use Up\Cake\Service\CommentService;

class Comment extends \Bitrix\Main\Engine\Controller
{
	protected const COUNT_COMMENTS = 10;

	public function getListAction(int $step = 1, int $recipeId = null): array
	{
		$comments = CommentService::getByRecipeId($recipeId,$step * self::COUNT_COMMENTS);

		$commentList = array_map(function($comment) {
			$title = str_replace(['\n','\&quot;'],[' ','"'],htmlspecialcharsbx(($comment['TITLE'])));
			$comment = array_map(function($data) {
				return htmlspecialcharsbx(\CUtil::JSEscape($data));
			}, $comment);
			$comment['TITLE'] = $title;
			return $comment;
		},$comments);

		$commentList = array_map(function($comment) {
			$comment['UP_CAKE_MODEL_COMMENT_USER_PERSONAL_PHOTO'] = \CUtil::JSEscape(\CFile::GetPath($comment['UP_CAKE_MODEL_COMMENT_USER_PERSONAL_PHOTO']));
			return $comment;
			},$commentList);
		return [
			'commentList' => $commentList,
		];
	}

	public function addCommentAction(int $recipeId, string $title): bool
	{
		global $USER;
		return CommentService::add($recipeId,$USER->getId(),$title);
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