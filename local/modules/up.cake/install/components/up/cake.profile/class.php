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
		$this->arResult['USER'] = CUser::GetByID($USER->GetID())->Fetch();
	}
}