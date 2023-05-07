<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class LikeTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> USER_ID int mandatory
 * <li> RECIPE_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Cake
 **/

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
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
				]
			),
			new IntegerField(
				'USER_ID',
				[
					'unique' => true,
					'required' => true,
				]
			),
			new IntegerField(
				'RECIPE_ID',
				[
					'unique' => true,
					'required' => true,
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
}