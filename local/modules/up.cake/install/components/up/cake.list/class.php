<?php

class TaskListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTasks($this->arParams['title']);
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		$arParams['title'] = (trim(request()->get('title')) !== '') ? trim(request()->get('title')) : null;
		$arParams['DATE_FORMAT'] = $arParams['DATE_FORMAT'] ?? 'H:i d-m-Y';

		return $arParams;
	}


	protected function fetchTasks($title)
	{
		$this->arResult['TASKS'] = \UP\Tasks\API\TaskList::get($title);
	}
}