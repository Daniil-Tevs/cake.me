<?php

namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc, Bitrix\Main\ORM\Data\DataManager, Bitrix\Main\ORM\Fields\DatetimeField, Bitrix\Main\ORM\Fields\IntegerField, Bitrix\Main\ORM\Fields\StringField, Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);

class RecipeTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_recipe';
	}

	public static function getMap()
	{
		return [
			'ID' => new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
				]
			),
			'NAME' => new StringField(
				'NAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateName'],
				]
			),
			'DESCRIPTION' => new StringField(
				'DESCRIPTION',
				[
					'validation' => [__CLASS__, 'validateDescription'],
				]
			),
			'TIME' => new IntegerField(
				'TIME'
			),
			'REACTION' => new IntegerField(
				'REACTION'
			),
			'USER_ID' => new IntegerField(
				'USER_ID',
				[
					'required' => true,
				]
			),
			'DATE_ADDED' => new DatetimeField(
				'DATE_ADDED',
				[
					'default_value' => function() {
						return new DateTime();
					},
				]
			),
			'USER' => (new Reference(
				'USER',
				\Bitrix\Main\UserTable::class,
				Join::on('this.USER_ID','ref.ID')
			))->configureJoinType('inner'),
		];
	}

	public static function validateName()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	public static function validateDescription()
	{
		return [
			new LengthValidator(null, 510),
		];
	}
}