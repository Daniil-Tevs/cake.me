<?php

use Bitrix\Main\Context;

class CakeListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->getMessage();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		global $USER;
		$arParams['USER'] = $USER->getId() ?? 0;
		return $arParams;
	}

	protected function getMessage(): void
	{
		$successAuth = false;
		$errorAuthUser = false;

		$request = Context::getCurrent()->getRequest();
		if ($request->get("success_auth") === "Y")
		{
			$successAuth = true;
		}

		$this->arResult['SUCCESS_AUTH_MESSAGE'] = $successAuth;
		if ($request->get("authUser") === "N")
		{
			$errorAuthUser = true;
		}

		$this->arResult['ERROR_AUTH_USER'] = $errorAuthUser;

		if ($request->get("create_success") === "Y")
		{
			$this->arResult['CREATE_SUCCESS'] = true;
		}

		if ($request->get("update_success") === "Y")
		{
			$this->arResult['UPDATE_SUCCESS'] = true;
		}
	}
}