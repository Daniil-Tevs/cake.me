<?php
/**
 * @global CUser $USER
 */

class CakeProfile extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUser();
		$this->includeComponentTemplate();
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