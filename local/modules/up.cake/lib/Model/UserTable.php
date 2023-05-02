<?php
namespace UP\Cake\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\BooleanField,
	Bitrix\Main\ORM\Fields\DateField,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\TextField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Up\Cake\Model\InstructionsTable;
use UP\Cake\Model\UserSubsTable;

Loc::loadMessages(__FILE__);

class UserTable extends DataManager
{
	public static function getTableName()
	{
		return 'b_user';
	}

	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('USER_ENTITY_ID_FIELD')
				]
			),
			new DatetimeField(
				'TIMESTAMP_X',
				[
					'title' => Loc::getMessage('USER_ENTITY_TIMESTAMP_X_FIELD')
				]
			),
			new StringField(
				'LOGIN',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateLogin'],
					'title' => Loc::getMessage('USER_ENTITY_LOGIN_FIELD')
				]
			),
			new StringField(
				'PASSWORD',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validatePassword'],
					'title' => Loc::getMessage('USER_ENTITY_PASSWORD_FIELD')
				]
			),
			new StringField(
				'CHECKWORD',
				[
					'validation' => [__CLASS__, 'validateCheckword'],
					'title' => Loc::getMessage('USER_ENTITY_CHECKWORD_FIELD')
				]
			),
			new BooleanField(
				'ACTIVE',
				[
					'values' => array('N', 'Y'),
					'default' => 'Y',
					'title' => Loc::getMessage('USER_ENTITY_ACTIVE_FIELD')
				]
			),
			new StringField(
				'NAME',
				[
					'validation' => [__CLASS__, 'validateName'],
					'title' => Loc::getMessage('USER_ENTITY_NAME_FIELD')
				]
			),
			new StringField(
				'LAST_NAME',
				[
					'validation' => [__CLASS__, 'validateLastName'],
					'title' => Loc::getMessage('USER_ENTITY_LAST_NAME_FIELD')
				]
			),
			new StringField(
				'EMAIL',
				[
					'validation' => [__CLASS__, 'validateEmail'],
					'title' => Loc::getMessage('USER_ENTITY_EMAIL_FIELD')
				]
			),
			new DatetimeField(
				'LAST_LOGIN',
				[
					'title' => Loc::getMessage('USER_ENTITY_LAST_LOGIN_FIELD')
				]
			),
			new DatetimeField(
				'DATE_REGISTER',
				[
					'required' => true,
					'title' => Loc::getMessage('USER_ENTITY_DATE_REGISTER_FIELD')
				]
			),
			new StringField(
				'LID',
				[
					'validation' => [__CLASS__, 'validateLid'],
					'title' => Loc::getMessage('USER_ENTITY_LID_FIELD')
				]
			),
			new StringField(
				'PERSONAL_PROFESSION',
				[
					'validation' => [__CLASS__, 'validatePersonalProfession'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_PROFESSION_FIELD')
				]
			),
			new StringField(
				'PERSONAL_WWW',
				[
					'validation' => [__CLASS__, 'validatePersonalWww'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_WWW_FIELD')
				]
			),
			new StringField(
				'PERSONAL_ICQ',
				[
					'validation' => [__CLASS__, 'validatePersonalIcq'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_ICQ_FIELD')
				]
			),
			new StringField(
				'PERSONAL_GENDER',
				[
					'validation' => [__CLASS__, 'validatePersonalGender'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_GENDER_FIELD')
				]
			),
			new StringField(
				'PERSONAL_BIRTHDATE',
				[
					'validation' => [__CLASS__, 'validatePersonalBirthdate'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_BIRTHDATE_FIELD')
				]
			),
			new IntegerField(
				'PERSONAL_PHOTO',
				[
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_PHOTO_FIELD')
				]
			),
			new StringField(
				'PERSONAL_PHONE',
				[
					'validation' => [__CLASS__, 'validatePersonalPhone'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_PHONE_FIELD')
				]
			),
			new StringField(
				'PERSONAL_FAX',
				[
					'validation' => [__CLASS__, 'validatePersonalFax'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_FAX_FIELD')
				]
			),
			new StringField(
				'PERSONAL_MOBILE',
				[
					'validation' => [__CLASS__, 'validatePersonalMobile'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_MOBILE_FIELD')
				]
			),
			new StringField(
				'PERSONAL_PAGER',
				[
					'validation' => [__CLASS__, 'validatePersonalPager'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_PAGER_FIELD')
				]
			),
			new TextField(
				'PERSONAL_STREET',
				[
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_STREET_FIELD')
				]
			),
			new StringField(
				'PERSONAL_MAILBOX',
				[
					'validation' => [__CLASS__, 'validatePersonalMailbox'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_MAILBOX_FIELD')
				]
			),
			new StringField(
				'PERSONAL_CITY',
				[
					'validation' => [__CLASS__, 'validatePersonalCity'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_CITY_FIELD')
				]
			),
			new StringField(
				'PERSONAL_STATE',
				[
					'validation' => [__CLASS__, 'validatePersonalState'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_STATE_FIELD')
				]
			),
			new StringField(
				'PERSONAL_ZIP',
				[
					'validation' => [__CLASS__, 'validatePersonalZip'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_ZIP_FIELD')
				]
			),
			new StringField(
				'PERSONAL_COUNTRY',
				[
					'validation' => [__CLASS__, 'validatePersonalCountry'],
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_COUNTRY_FIELD')
				]
			),
			new TextField(
				'PERSONAL_NOTES',
				[
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_NOTES_FIELD')
				]
			),
			new StringField(
				'WORK_COMPANY',
				[
					'validation' => [__CLASS__, 'validateWorkCompany'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_COMPANY_FIELD')
				]
			),
			new StringField(
				'WORK_DEPARTMENT',
				[
					'validation' => [__CLASS__, 'validateWorkDepartment'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_DEPARTMENT_FIELD')
				]
			),
			new StringField(
				'WORK_POSITION',
				[
					'validation' => [__CLASS__, 'validateWorkPosition'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_POSITION_FIELD')
				]
			),
			new StringField(
				'WORK_WWW',
				[
					'validation' => [__CLASS__, 'validateWorkWww'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_WWW_FIELD')
				]
			),
			new StringField(
				'WORK_PHONE',
				[
					'validation' => [__CLASS__, 'validateWorkPhone'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_PHONE_FIELD')
				]
			),
			new StringField(
				'WORK_FAX',
				[
					'validation' => [__CLASS__, 'validateWorkFax'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_FAX_FIELD')
				]
			),
			new StringField(
				'WORK_PAGER',
				[
					'validation' => [__CLASS__, 'validateWorkPager'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_PAGER_FIELD')
				]
			),
			new TextField(
				'WORK_STREET',
				[
					'title' => Loc::getMessage('USER_ENTITY_WORK_STREET_FIELD')
				]
			),
			new StringField(
				'WORK_MAILBOX',
				[
					'validation' => [__CLASS__, 'validateWorkMailbox'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_MAILBOX_FIELD')
				]
			),
			new StringField(
				'WORK_CITY',
				[
					'validation' => [__CLASS__, 'validateWorkCity'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_CITY_FIELD')
				]
			),
			new StringField(
				'WORK_STATE',
				[
					'validation' => [__CLASS__, 'validateWorkState'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_STATE_FIELD')
				]
			),
			new StringField(
				'WORK_ZIP',
				[
					'validation' => [__CLASS__, 'validateWorkZip'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_ZIP_FIELD')
				]
			),
			new StringField(
				'WORK_COUNTRY',
				[
					'validation' => [__CLASS__, 'validateWorkCountry'],
					'title' => Loc::getMessage('USER_ENTITY_WORK_COUNTRY_FIELD')
				]
			),
			new TextField(
				'WORK_PROFILE',
				[
					'title' => Loc::getMessage('USER_ENTITY_WORK_PROFILE_FIELD')
				]
			),
			new IntegerField(
				'WORK_LOGO',
				[
					'title' => Loc::getMessage('USER_ENTITY_WORK_LOGO_FIELD')
				]
			),
			new TextField(
				'WORK_NOTES',
				[
					'title' => Loc::getMessage('USER_ENTITY_WORK_NOTES_FIELD')
				]
			),
			new TextField(
				'ADMIN_NOTES',
				[
					'title' => Loc::getMessage('USER_ENTITY_ADMIN_NOTES_FIELD')
				]
			),
			new StringField(
				'STORED_HASH',
				[
					'validation' => [__CLASS__, 'validateStoredHash'],
					'title' => Loc::getMessage('USER_ENTITY_STORED_HASH_FIELD')
				]
			),
			new StringField(
				'XML_ID',
				[
					'validation' => [__CLASS__, 'validateXmlId'],
					'title' => Loc::getMessage('USER_ENTITY_XML_ID_FIELD')
				]
			),
			new DateField(
				'PERSONAL_BIRTHDAY',
				[
					'title' => Loc::getMessage('USER_ENTITY_PERSONAL_BIRTHDAY_FIELD')
				]
			),
			new StringField(
				'EXTERNAL_AUTH_ID',
				[
					'validation' => [__CLASS__, 'validateExternalAuthId'],
					'title' => Loc::getMessage('USER_ENTITY_EXTERNAL_AUTH_ID_FIELD')
				]
			),
			new DatetimeField(
				'CHECKWORD_TIME',
				[
					'title' => Loc::getMessage('USER_ENTITY_CHECKWORD_TIME_FIELD')
				]
			),
			new StringField(
				'SECOND_NAME',
				[
					'validation' => [__CLASS__, 'validateSecondName'],
					'title' => Loc::getMessage('USER_ENTITY_SECOND_NAME_FIELD')
				]
			),
			new StringField(
				'CONFIRM_CODE',
				[
					'validation' => [__CLASS__, 'validateConfirmCode'],
					'title' => Loc::getMessage('USER_ENTITY_CONFIRM_CODE_FIELD')
				]
			),
			new IntegerField(
				'LOGIN_ATTEMPTS',
				[
					'title' => Loc::getMessage('USER_ENTITY_LOGIN_ATTEMPTS_FIELD')
				]
			),
			new DatetimeField(
				'LAST_ACTIVITY_DATE',
				[
					'title' => Loc::getMessage('USER_ENTITY_LAST_ACTIVITY_DATE_FIELD')
				]
			),
			new StringField(
				'AUTO_TIME_ZONE',
				[
					'validation' => [__CLASS__, 'validateAutoTimeZone'],
					'title' => Loc::getMessage('USER_ENTITY_AUTO_TIME_ZONE_FIELD')
				]
			),
			new StringField(
				'TIME_ZONE',
				[
					'validation' => [__CLASS__, 'validateTimeZone'],
					'title' => Loc::getMessage('USER_ENTITY_TIME_ZONE_FIELD')
				]
			),
			new IntegerField(
				'TIME_ZONE_OFFSET',
				[
					'title' => Loc::getMessage('USER_ENTITY_TIME_ZONE_OFFSET_FIELD')
				]
			),
			new StringField(
				'TITLE',
				[
					'validation' => [__CLASS__, 'validateTitle'],
					'title' => Loc::getMessage('USER_ENTITY_TITLE_FIELD')
				]
			),
			new StringField(
				'BX_USER_ID',
				[
					'validation' => [__CLASS__, 'validateBxUserId'],
					'title' => Loc::getMessage('USER_ENTITY_BX_USER_ID_FIELD')
				]
			),
			new StringField(
				'LANGUAGE_ID',
				[
					'validation' => [__CLASS__, 'validateLanguageId'],
					'title' => Loc::getMessage('USER_ENTITY_LANGUAGE_ID_FIELD')
				]
			),
			new BooleanField(
				'BLOCKED',
				[
					'values' => array('N', 'Y'),
					'default' => 'N',
					'title' => Loc::getMessage('USER_ENTITY_BLOCKED_FIELD')
				]
			),
			new BooleanField(
				'PASSWORD_EXPIRED',
				[
					'values' => array('N', 'Y'),
					'default' => 'N',
					'title' => Loc::getMessage('USER_ENTITY_PASSWORD_EXPIRED_FIELD')
				]
			),

			'USER_SUBS' => new OneToMany(
				'USER_SUBS',
				UserSubsTable::class,
				'USER'
			),
		];
	}

	/**
	 * Returns validators for LOGIN field.
	 *
	 * @return array
	 */
	public static function validateLogin()
	{
		return [
			new LengthValidator(null, 50),
		];
	}

	/**
	 * Returns validators for PASSWORD field.
	 *
	 * @return array
	 */
	public static function validatePassword()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for CHECKWORD field.
	 *
	 * @return array
	 */
	public static function validateCheckword()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for NAME field.
	 *
	 * @return array
	 */
	public static function validateName()
	{
		return [
			new LengthValidator(null, 50),
		];
	}

	/**
	 * Returns validators for LAST_NAME field.
	 *
	 * @return array
	 */
	public static function validateLastName()
	{
		return [
			new LengthValidator(null, 50),
		];
	}

	/**
	 * Returns validators for EMAIL field.
	 *
	 * @return array
	 */
	public static function validateEmail()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for LID field.
	 *
	 * @return array
	 */
	public static function validateLid()
	{
		return [
			new LengthValidator(null, 2),
		];
	}

	/**
	 * Returns validators for PERSONAL_PROFESSION field.
	 *
	 * @return array
	 */
	public static function validatePersonalProfession()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_WWW field.
	 *
	 * @return array
	 */
	public static function validatePersonalWww()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_ICQ field.
	 *
	 * @return array
	 */
	public static function validatePersonalIcq()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_GENDER field.
	 *
	 * @return array
	 */
	public static function validatePersonalGender()
	{
		return [
			new LengthValidator(null, 1),
		];
	}

	/**
	 * Returns validators for PERSONAL_BIRTHDATE field.
	 *
	 * @return array
	 */
	public static function validatePersonalBirthdate()
	{
		return [
			new LengthValidator(null, 50),
		];
	}

	/**
	 * Returns validators for PERSONAL_PHONE field.
	 *
	 * @return array
	 */
	public static function validatePersonalPhone()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_FAX field.
	 *
	 * @return array
	 */
	public static function validatePersonalFax()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_MOBILE field.
	 *
	 * @return array
	 */
	public static function validatePersonalMobile()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_PAGER field.
	 *
	 * @return array
	 */
	public static function validatePersonalPager()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_MAILBOX field.
	 *
	 * @return array
	 */
	public static function validatePersonalMailbox()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_CITY field.
	 *
	 * @return array
	 */
	public static function validatePersonalCity()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_STATE field.
	 *
	 * @return array
	 */
	public static function validatePersonalState()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_ZIP field.
	 *
	 * @return array
	 */
	public static function validatePersonalZip()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PERSONAL_COUNTRY field.
	 *
	 * @return array
	 */
	public static function validatePersonalCountry()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_COMPANY field.
	 *
	 * @return array
	 */
	public static function validateWorkCompany()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_DEPARTMENT field.
	 *
	 * @return array
	 */
	public static function validateWorkDepartment()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_POSITION field.
	 *
	 * @return array
	 */
	public static function validateWorkPosition()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_WWW field.
	 *
	 * @return array
	 */
	public static function validateWorkWww()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_PHONE field.
	 *
	 * @return array
	 */
	public static function validateWorkPhone()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_FAX field.
	 *
	 * @return array
	 */
	public static function validateWorkFax()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_PAGER field.
	 *
	 * @return array
	 */
	public static function validateWorkPager()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_MAILBOX field.
	 *
	 * @return array
	 */
	public static function validateWorkMailbox()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_CITY field.
	 *
	 * @return array
	 */
	public static function validateWorkCity()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_STATE field.
	 *
	 * @return array
	 */
	public static function validateWorkState()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_ZIP field.
	 *
	 * @return array
	 */
	public static function validateWorkZip()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for WORK_COUNTRY field.
	 *
	 * @return array
	 */
	public static function validateWorkCountry()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for STORED_HASH field.
	 *
	 * @return array
	 */
	public static function validateStoredHash()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for XML_ID field.
	 *
	 * @return array
	 */
	public static function validateXmlId()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for EXTERNAL_AUTH_ID field.
	 *
	 * @return array
	 */
	public static function validateExternalAuthId()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for SECOND_NAME field.
	 *
	 * @return array
	 */
	public static function validateSecondName()
	{
		return [
			new LengthValidator(null, 50),
		];
	}

	/**
	 * Returns validators for CONFIRM_CODE field.
	 *
	 * @return array
	 */
	public static function validateConfirmCode()
	{
		return [
			new LengthValidator(null, 8),
		];
	}

	/**
	 * Returns validators for AUTO_TIME_ZONE field.
	 *
	 * @return array
	 */
	public static function validateAutoTimeZone()
	{
		return [
			new LengthValidator(null, 1),
		];
	}

	/**
	 * Returns validators for TIME_ZONE field.
	 *
	 * @return array
	 */
	public static function validateTimeZone()
	{
		return [
			new LengthValidator(null, 50),
		];
	}

	/**
	 * Returns validators for TITLE field.
	 *
	 * @return array
	 */
	public static function validateTitle()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for BX_USER_ID field.
	 *
	 * @return array
	 */
	public static function validateBxUserId()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for LANGUAGE_ID field.
	 *
	 * @return array
	 */
	public static function validateLanguageId()
	{
		return [
			new LengthValidator(null, 2),
		];
	}
}