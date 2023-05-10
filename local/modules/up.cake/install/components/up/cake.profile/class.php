<?php

use Bitrix\Main\Context;

/**
 * @global CUser $USER
 */

class CakeProfileComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUser();
		$this->getMessage();
		$this->includeComponentTemplate();
	}

	protected function getMessage(): void
	{
		$request = Context::getCurrent()->getRequest();
		if ($request->get("data_saved") === "Y")
		{
			$this->arResult['DATA_SAVED'] = true;
		}
	}

	public function fetchUser(): void
	{
		global $USER;

		$this->arResult['DEFAULT_IMAGE'] = false;

		$this->arResult['USER'] = CUser::GetByID($USER->GetID())->Fetch();
		if ($this->arResult['USER']['PERSONAL_PHOTO'] === null)
		{
				$this->arResult['DEFAULT_IMAGE'] = true;
		}
	}
}