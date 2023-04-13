<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

class TypeTable extends DataManager
{
	public static function getTableName()
	{
		return 'up_cake_type';
	}

	public static function getMap()
	{
		return [
			new StringField(
				'ID',
				[
					'primary' => true,
					'validation' => [__CLASS__, 'validateId'],
				]
			),
		];
	}

	public static function validateId()
	{
		return [
			new LengthValidator(null, 50),
		];
	}
}