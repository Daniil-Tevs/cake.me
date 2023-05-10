<?php

use Bitrix\Main\Context;

/**
 * @global CUser $USER
 */

class CakeUsersComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		global $USER;
		$userId = (int)$USER->GetID();
		$subId = (int)$this->arParams['ID'];

		$request = Context::getCurrent()->getRequest();

		$checkSub = $this->checkSub($userId, $subId);
		if ($checkSub === false && $request->get("subs") === "Y")
		{
			$this->createSubs($userId, $subId);
		}

		elseif ($request->get("subs") === "Y")
		{
			$this->getMessages($request);
		}

		if ($checkSub === true && $request->get("subsDel") === "Y")
		{
			$this->deleteSubs($userId, $subId);
		}

		$this->getMessages($request);
		$this->fetchUser();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		global $USER;
		$arParams['USER'] = $USER->getId() ?? 0;
		return $arParams;
	}

	protected function getMessages($request): void
	{
		$this->arResult['SUBS_ERROR'] = false;
		if ($request->get("subs") === "Y")
		{
			$this->arResult['SUBS_ERROR'] = true;
		}

		if ($request->get("subs_success") === "Y")
		{
			$this->arResult['SUBS_SUCCESS'] = true;
		}
		elseif ($request->get("subs_success") === "N")
		{
			$this->arResult['SUBS_SUCCESS'] = false;
		}

		if ($request->get("delete_success") === "Y")
		{
			$this->arResult['DELETE_SUCCESS'] = true;
		}
		elseif ($request->get("delete_success") === "N")
		{
			$this->arResult['DELETE_SUCCESS'] = false;
		}
	}

	protected function checkSub($userId, $subId): bool
	{
		if ($userId === $subId)
		{
			LocalRedirect('/profile/');
		}
		$checkSub = \Up\Cake\Service\UserService::checkSubs($userId, $subId);

		if ($checkSub)
		{
			$this->arResult['SUB_CHECK_SUCCESS'] = true;
		}

		return $checkSub;
	}

	protected function createSubs($userId, $subId): void
	{

		$result = \Up\Cake\Service\UserService::addSubs($userId, $subId);
		if ($result)
		{
			LocalRedirect("/users/{$this->arParams['ID']}/?subs_success=Y");
		}

		LocalRedirect("/users/{$this->arParams['ID']}/?subs_success=N");
	}

	protected function deleteSubs($userId, $subId): void
	{
		$result = \Up\Cake\Service\UserService::createSubs($userId, $subId);
		if ($result)
		{
			LocalRedirect("/users/{$this->arParams['ID']}/?delete_success=Y");
		}

		LocalRedirect("/users/{$this->arParams['ID']}/?delete_success=N");
	}

	protected function fetchUser(): void
	{
		$userId = ($this->arParams['ID']);

		$user = CUser::GetByID($userId)->Fetch();
		if (!$user)
		{
			LocalRedirect('/');
		}

		$this->arResult['USER'] = $user;
	}
}