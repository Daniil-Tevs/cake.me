<?php
namespace Up\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;

Loc::loadMessages(__FILE__);

/**
 * Class RecipeTagTable
 *
 * Fields:
 * <ul>
 * <li> RECIPE_ID int optional
 * <li> TAG_ID int optional
 * </ul>
 *
 * @package Bitrix\Cake
 **/

class RecipeTagTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_cake_recipe_tag';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'RECIPE_ID',
				[
					'title' => Loc::getMessage('RECIPE_TAG_ENTITY_RECIPE_ID_FIELD')
				]
			),
			new IntegerField(
				'TAG_ID',
				[
					'title' => Loc::getMessage('RECIPE_TAG_ENTITY_TAG_ID_FIELD')
				]
			),
		];
	}
}