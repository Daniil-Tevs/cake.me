<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\FloatField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
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
				'RECIPE_ID',
				[
					'primary' => true,
					'title' => Loc::getMessage('RECIPE_INGREDIENT_ENTITY_RECIPE_ID_FIELD')
				]
			),
			new IntegerField(
				'INGREDIENT_ID',
				[
					'primary' => true,
					'title' => Loc::getMessage('RECIPE_INGREDIENT_ENTITY_INGREDIENT_ID_FIELD')
				]
			),
			new FloatField(
				'COUNT',
				[
					'title' => Loc::getMessage('RECIPE_INGREDIENT_ENTITY_COUNT_FIELD')
				]
			),
			new StringField(
				'TYPE_ID',
				[
					'validation' => [__CLASS__, 'validateTypeId'],
					'title' => Loc::getMessage('RECIPE_INGREDIENT_ENTITY_TYPE_ID_FIELD')
				]
			),

			// 'INGREDIENT' => new Reference(
			// 	'INGREDIENT',
			// 	IngredientTable::class,
			// 	Join::on('this.INGREDIENT_ID', 'ref.ID')
			// ),
			//
			// 'RECIPE' => new Reference(
			// 	'RECIPE',
			// 	RecipeTable::class,
			// 	Join::on('this.RECIPE_ID', 'ref.ID')
			// ),

			(new Reference(
				'INGREDIENT',
				IngredientTable::class,
				Join::on('this.INGREDIENT_ID', 'ref.ID')
			))->configureJoinType('inner'),

			(new Reference(
				'RECIPE',
				RecipeTable::class,
				Join::on('this.RECIPE_ID', 'ref.ID')
			))->configureJoinType('inner'),

			// 'TYPE' => (new Reference(
			// 	'TYPE',
			// 	TypeTable::class,
			// 	Join::on('this.TYPE_ID','ref.ID')
			// ))->configureJoinType('inner')
		];
	}

	public static function validateTypeId()
	{
		return [
			new LengthValidator(null, 50),
		];
	}
}