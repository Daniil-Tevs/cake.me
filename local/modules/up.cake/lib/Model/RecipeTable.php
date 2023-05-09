<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Type\DateTime;
use Up\Cake\Model\InstructionsTable;

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
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
				]
			),
			new StringField(
				'NAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateName'],
				]
			),
			new StringField(
				'DESCRIPTION',
				[
					'validation' => [__CLASS__, 'validateDescription'],
				]
			),
			new IntegerField(
				'TIME'
			),
			new IntegerField(
				'REACTION'
			),
			new IntegerField(
				'CALORIES'
			),
			new IntegerField(
				'PORTION_COUNT'
			),
			new IntegerField(
				'USER_ID',
				[
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
			new DatetimeField(
				'DATE_UPDATED'
			),

			'USER' => (new Reference(
				'USER',
				\Bitrix\Main\UserTable::class,
				Join::on('this.USER_ID','ref.ID')
			))->configureJoinType('inner'),

			'INSTRUCTIONS' => new OneToMany(
				'INSTRUCTIONS',
				InstructionsTable::class,
				'RECIPE'
			),

			(new ManyToMany(
				'TAGS',
				 TagTable::class)
			 )->configureTableName('up_cake_recipe_tag'),

			// (new ManyToMany(
			// 	'INGREDIENTS',
			// 	IngredientTable::class)
			// )->configureTableName('up_cake_recipe_ingredient'),

			(new OneToMany(
				'RECIPE_INGREDIENT',
				RecipeIngredientTable::class,
				'RECIPE')),

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
			new LengthValidator(null, 1000),
		];
	}
}