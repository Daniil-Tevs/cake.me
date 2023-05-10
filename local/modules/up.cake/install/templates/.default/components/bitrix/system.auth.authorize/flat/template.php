<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

CJSCore::Init(array('ajax', 'window'));

if ($arParams["SUCCESS_REG"] === true): ?>
	<div class="notification is-primary is-light reg-success-message">
		<p><?=GetMessage("REG_SUCCESS_INFO")?></p>
	</div>
<?php endif; ?>

<?php if(!empty($arParams["~AUTH_RESULT"])):
	$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
?>
	<div class="notification is-danger is-light auth-error-message">
		<h3><?=nl2br(htmlspecialcharsbx($text))?></h3>
	</div>
<?endif?>

<?
if($arResult['ERROR_MESSAGE'] <> ''):
	$text = str_replace(array("<br>", "<br />"), "\n", $arResult['ERROR_MESSAGE']);
?>
	<div class="notification is-danger is-light auth-error-message">
		<h3><?=nl2br(htmlspecialcharsbx($text))?></h3>
	</div>
<?endif?>

<style> .recently,.search-container,.filter {display: none;}</style>

<div class="content">

	<div class="field is-grouped is-grouped-centered">
		<div class="image image-auth-form">
			<img class="auth-img" src="/local/modules/up.cake/install/templates/cake/images/login.png" alt="/">
		</div>
	<form id="auth-user" class="box box-reg box-auth" name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<label class="label label-reg-name label-auth is-size-3"><?=GetMessage("AUTH_CAKE_TITLE")?></label>

		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />

		<?if ($arResult["BACKURL"] <> ''):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>

		<div class="field">
			<label class="label input-login-field"><?=GetMessage("AUTH_LOGIN")?>: </label>
			<div class="control">
				<input class="input input-login-field" type="text" name="USER_LOGIN" maxlength="255" placeholder=""
					   value="<?=$arResult["LAST_LOGIN"]?>" />
			</div>
		</div>

		<div class="field">
			<label class="label input-login-field"><?=GetMessage("AUTH_PASSWORD")?>: </label>
			<div class="control">
				<input class="input input-login-field" type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off"/>
			</div>
		</div>

		<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
			<div class="field">
				<div class="control">
					<label class="checkbox">
						<input class="input-login-field" type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y">
						<span class=""><?=GetMessage("AUTH_REMEMBER_ME")?></span>
					</label>
				</div>
			</div>
		<?endif?>

		<div class="field is-grouped is-grouped-centered is-reg-buttons">
			<div class="control">
				<input class="button is-link" type="submit" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>">
			</div>
			<div class="control">
				<a href="/" class="button is-link is-light"><?=GetMessage("LOGIN_BUTTON_CANCEL")?></a>
			</div>
		</div>

		<?if($arParams["NOT_SHOW_LINKS"] !== "Y" && $arResult["NEW_USER_REGISTRATION"] === "Y" && $arParams["AUTHORIZE_REGISTRATION"] !== "Y"):?>

			<div class="block block-redirect-auth">
				<p><?=GetMessage("AUTH_FIRST_ONE")?> <a href="<?=$arResult["AUTH_REGISTER_URL"]?>"><?=GetMessage("AUTH_REGISTER")?></a></p>
			</div>
		<?endif?>
	</form>
	</div>
</div>

<script>
	let form = document.getElementById('auth-user');
	form.addEventListener('submit', getNotification);
	const formData = new FormData(form);

	function getNotification(event)
	{
		BX.ajax.runAction('up:cake.notification.getList', {
				data: {
					userLogin: formData.get('USER_LOGIN'),
				},
			})
	}
</script>