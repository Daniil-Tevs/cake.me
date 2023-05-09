<?php

namespace UP\Cake\Controller;


use Up\Cake\Service\IngredientService;

class Ingredient extends \Bitrix\Main\Engine\Controller
{
	public function getListAction(): array
	{
		return  array_map(fn($ingredient) =>htmlspecialcharsbx(\CUtil::JSEscape($ingredient['NAME'])), IngredientService::get());
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