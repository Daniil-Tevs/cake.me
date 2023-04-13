<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\FloatField,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

class RecipeIngredientTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_recipe_ingredient';
	}

	public static function getMap()
	{
		return [
			new IntegerField(
				'RECIPE_ID'
			),
			new IntegerField(
				'INGREDIENT_ID'
			),
			new FloatField(
				'COUNT'
			),
			new IntegerField(
				'TYPE_ID'
			),

			'INGREDIENT' => new Reference(
				'INGREDIENT',
				IngredientTable::class,
				Join::on('this.INGREDIENT_ID', 'ref.ID')
			),

			'RECIPE' => new Reference(
				'RECIPE',
				RecipeTable::class,
				Join::on('this.RECIPE_ID', 'ref.ID')
			),
		];
	}
}