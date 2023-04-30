<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

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
			new IntegerField(
				'CATEGORY_ID',
				[
					'required' => true,
				]
			),

			(new ManyToMany(
				'RECIPES',
				RecipeTable::class)
			)->configureTableName('up_cake_recipe_tag'),


			'CATEGORY' => (new Reference(
				'CATEGORY',
				CategoryTable::class,
				Join::on('this.CATEGORY_ID','ref.ID')
			)),
		];
	}

	public static function validateName()
	{
		return [
			new LengthValidator(null, 255),
		];
	}
}