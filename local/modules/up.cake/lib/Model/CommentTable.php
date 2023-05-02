<?php

namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc, Bitrix\Main\ORM\Data\DataManager, Bitrix\Main\ORM\Fields\IntegerField, Bitrix\Main\ORM\Fields\StringField, Bitrix\Main\ORM\Fields\Validators\LengthValidator, Bitrix\Main\ORM\Fields\DatetimeField, Bitrix\Main\ORM\Fields\Relations\Reference, Bitrix\Main\ORM\Query\Join, Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);

class CommentTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_comment';
	}

	public static function getMap()
	{
		return [
			new IntegerField(
				'ID', [
						'primary' => true,
						'autocomplete' => true,
					]
			),
			new StringField(
				'TITLE', [
						   'required' => true,
						   'validation' => [__CLASS__, 'validateTitle'],
					   ]
			),
			new IntegerField(
				'USER_ID', [
							 'required' => true,
						 ]
			),
			new IntegerField(
				'RECIPE_ID', [
							   'required' => true,
						   ]
			),
			new DatetimeField(
				'DATE_ADDED', [
								'required' => true,
								'default_value' => function() {
									return new DateTime();
								},
							]
			),
			'USER' => (new Reference(
				'USER', \Bitrix\Main\UserTable::class, Join::on('this.USER_ID', 'ref.ID')
			))->configureJoinType('inner'),
			'RECIPE' => (new Reference(
				'RECIPE', \Bitrix\Main\UserTable::class, Join::on('this.RECIPE_ID', 'ref.ID')
			))->configureJoinType('inner'),
		];
	}

	public static function validateTitle()
	{
		return [
			new LengthValidator(null, 510),
		];
	}
}