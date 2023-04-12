<?php
namespace Up\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;

Loc::loadMessages(__FILE__);

/**
 * Class RecipeIngredientTable
 *
 * Fields:
 * <ul>
 * <li> RECIPE_ID int optional
 * <li> INGREDIENT_ID int optional
 * </ul>
 *
 * @package Bitrix\Cake
 **/

class RecipeIngredientTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_cake_recipe_ingredient';
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
					'title' => Loc::getMessage('RECIPE_INGREDIENT_ENTITY_RECIPE_ID_FIELD')
				]
			),
			new IntegerField(
				'INGREDIENT_ID',
				[
					'title' => Loc::getMessage('RECIPE_INGREDIENT_ENTITY_INGREDIENT_ID_FIELD')
				]
			),
		];
	}
}