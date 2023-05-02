<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;


Loc::loadMessages(__FILE__);

class UserSubsTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_user_subs';
	}

	public static function getMap()
	{
		return [
			new IntegerField(
				'USER_ID',
				[
					'primary' => true,
				]
			),
			new IntegerField(
				'SUB_ID',
				[
					'primary' => true,
				]
			),

			'USER' => (new Reference(
				'USER',
				UserTable::class,
				Join::on('this.RECIPE_ID','ref.ID')
			))->configureJoinType('inner')
		];
	}
}