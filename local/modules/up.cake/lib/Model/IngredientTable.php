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
				]
			),
			new StringField(
				'NAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateName'],
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
}