<?php

use Bitrix\Main\Context;

/**
 * @global CUser $USER
 */

class CakeProfile extends CBitrixComponent
{
	public function executeComponent()
	{
		$request = Context::getCurrent()->getRequest();
		$this->arResult['USER_REQUEST'] = false;

		if (trim($request->get("search_name")) !== '' || trim($request->get("search_last")) !== '')
		{
			$searchName = trim($request->get("search_name"));
			$searchLastName = trim($request->get("search_last"));

			$this->getUserList($searchName, $searchLastName);
		}

		$this->includeComponentTemplate();
	}

	protected function getUserList(string $searchName, string $searchLastName): void
	{
		global $USER;
		$userList = \Up\Cake\Service\UserService::getUserList($searchName, $searchLastName);

		// убираем из выборки текущего авторизованного пользователя
		foreach ($userList as $i => $user)
		{
			if ((int)$user['ID'] === (int)$USER->GetID())
			{
				unset($userList[$i]);
				break;
			}
		}

		$this->arResult['USER_REQUEST'] = true;
		$this->arResult['USERS'] = $userList;
	}
}