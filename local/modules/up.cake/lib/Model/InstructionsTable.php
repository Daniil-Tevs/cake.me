<?php
namespace Up\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class InstructionsTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> DESCRIPTION string(510) mandatory
 * <li> STEP int mandatory
 * <li> RECIPE_ID int optional
 * </ul>
 *
 * @package Bitrix\Cake
 **/

class InstructionsTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_cake_instructions';
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
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('INSTRUCTIONS_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'DESCRIPTION',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateDescription'],
					'title' => Loc::getMessage('INSTRUCTIONS_ENTITY_DESCRIPTION_FIELD')
				]
			),
			new IntegerField(
				'STEP',
				[
					'required' => true,
					'title' => Loc::getMessage('INSTRUCTIONS_ENTITY_STEP_FIELD')
				]
			),
			new IntegerField(
				'RECIPE_ID',
				[
					'title' => Loc::getMessage('INSTRUCTIONS_ENTITY_RECIPE_ID_FIELD')
				]
			),

			'RECIPE' => (new Reference(
				'RECIPE',
				RecipeTable::class,
				Join::on('this.RECIPE_ID','ref.ID')
			))->configureJoinType('inner')
		];
	}

	/**
	 * Returns validators for DESCRIPTION field.
	 *
	 * @return array
	 */
	public static function validateDescription()
	{
		return [
			new LengthValidator(null, 510),
		];
	}
}