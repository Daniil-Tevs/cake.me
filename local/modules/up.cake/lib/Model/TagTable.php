<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

Loc::loadMessages(__FILE__);

class TagTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_tag';
	}

	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('TAG_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'NAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateName'],
					'title' => Loc::getMessage('TAG_ENTITY_NAME_FIELD')
				]
			),

			(new ManyToMany(
				'RECIPES',
				RecipeTable::class)
			)->configureTableName('up_cake_recipe_tag'),
		];
	}

	public static function validateName()
	{
		return [
			new LengthValidator(null, 255),
		];
	}
}