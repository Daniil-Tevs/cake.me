<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\BooleanField;

Loc::loadMessages(__FILE__);

class RecipeImageTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_recipe_image';
	}

	public static function getMap()
	{
		return [
			new IntegerField(
				'RECIPE_ID',
				[
					'primary' => true,
				]
			),
			new IntegerField(
				'IMAGE_ID',
				[
					'primary' => true,
				]
			),
			new BooleanField(
				'IS_MAIN',
				[
					'values' => [0, 1],
					'required' => true,
				]
			),
			new IntegerField(
				'NUMBER',
			),
		];
	}
}