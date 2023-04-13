<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

class RecipeTagTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_recipe_tag';
	}

	public static function getMap()
	{
		return [
			new IntegerField(
				'RECIPE_ID'
			),
			new IntegerField(
				'TAG_ID'
			),

			'TAG' => new Reference(
				'TAG',
				TagTable::class,
				Join::on('this.TAG_ID', 'ref.ID')
			),

			'RECIPE' => new Reference(
				'RECIPE',
				RecipeTable::class,
				Join::on('this.RECIPE_ID', 'ref.ID')
			),

		];
	}
}