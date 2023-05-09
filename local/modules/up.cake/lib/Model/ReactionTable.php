<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);


class ReactionTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_reaction';
	}

	public static function getMap()
	{
		return [
			new IntegerField(
				'USER_ID',
				[
					'primary' => true,
					'unique' => true,
					'required' => true,
				]
			),
			new IntegerField(
				'RECIPE_ID',
				[
					'primary' => true,
					'unique' => true,
					'required' => true,
				]
			),
			new DatetimeField(
				'DATE_ADDED',
				[
					'required' => true,
					'default_value' => function() {
						return new DateTime();
					}
				]),
			'USER' => (new Reference(
				'USER', \Bitrix\Main\UserTable::class, Join::on('this.USER_ID', 'ref.ID')
			))->configureJoinType('inner'),
			'RECIPE' => (new Reference(
				'RECIPE', \Bitrix\Main\UserTable::class, Join::on('this.RECIPE_ID', 'ref.ID')
			))->configureJoinType('inner'),
		];
	}
}