<?php

use Bitrix\Main\Context;

/**
 * @global CUser $USER
 */

class SubscribeListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->getUserSubsList();

		$this->includeComponentTemplate();
	}

	protected function getUserSubsList(): void
	{
		global $USER;
		$userList = \Up\Cake\Service\UserService::getUserSubsList((int)$USER->GetID());

		$this->arResult['USERS'] = $userList;
	}
}