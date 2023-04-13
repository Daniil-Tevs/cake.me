<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

Loc::loadMessages(__FILE__);

class IngredientTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_ingredient';
	}

	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('INGREDIENT_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'NAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateName'],
					'title' => Loc::getMessage('INGREDIENT_ENTITY_NAME_FIELD')
				]
			),
			new StringField(
				'TYPE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateType'],
					'title' => Loc::getMessage('INGREDIENT_ENTITY_TYPE_FIELD')
				]
			),
			new IntegerField(
				'CALORIES',
				[
					'title' => Loc::getMessage('INGREDIENT_ENTITY_CALORIES_FIELD')
				]
			),

			(new ManyToMany(
				'RECIPES',
				RecipeTable::class)
			)->configureTableName('up_cake_recipe_ingredient'),
		];
	}

	public static function validateName()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	public static function validateType()
	{
		return [
			new LengthValidator(null, 100),
		];
	}
}