<?php

use Bitrix\Main\Context;

/**
 * @global CUser $USER
 */

class CakeSearchUsersComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$request = Context::getCurrent()->getRequest();
		$this->arResult['USER_REQUEST'] = false;

		if (trim($request->get("search")) !== '')
		{
			$search = trim($request->get("search"));

			$this->getUserList($search);
		}

		$this->includeComponentTemplate();
	}

	protected function getUserList(string $search): void
	{
		global $USER;

		$userList = \Up\Cake\Service\UserService::getUserList($search, (int)$USER->GetID());

		// убираем из выборки текущего авторизованного пользователя
		if (!empty($userList))
		{
			foreach ($userList as $i => $user)
			{
				if ((int)$user['ID'] === (int)$USER->GetID())
				{
					unset($userList[$i]);
					break;
				}
			}
		}

		$this->arResult['USER_REQUEST'] = true;
		$this->arResult['USERS'] = $userList;
	}
}