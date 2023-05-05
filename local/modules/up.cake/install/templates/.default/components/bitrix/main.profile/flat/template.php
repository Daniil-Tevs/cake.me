<?php
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if ($arResult['DATA_SAVED'] === 'Y')
{
	LocalRedirect('/profile/?data_saved=Y');
}
?>

<style> .recently,.search-container,.filter {display: none;}</style>

<div class="bx-auth-profile">
	<?php if (!empty($arResult["strProfileError"])): ?>
	<div class="notification is-danger is-light auth-success-message">
		<p><?= $arResult["strProfileError"] ?></p>
	</div>
	<? endif; ?>

	<div id="bx_profile_error" style="display:none"><?ShowError("error")?></div>

	<div id="bx_profile_resend"></div>

	<script type="text/javascript">
		<!--
		var opened_sections = [<?
			$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
			$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
			if ($arResult["opened"] <> '')
			{
				echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
			}
			else
			{
				$arResult["opened"] = "reg";
				echo "'reg'";
			}
			?>];
		//-->
		var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
	</script>

<div class="content">
	<form method="post" class="box box-profile-edit" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

		<div class="profile-link profile-user-div-link"><a title="<?=GetMessage("REG_SHOW_HIDE")?>" href="javascript:void(0)" onclick="SectionClick('reg')"><?=GetMessage("REG_SHOW_HIDE")?></a></div>
		<div class="profile-block-<?= mb_strpos($arResult["opened"], "reg") === false ? "hidden" : "shown"?>" id="user_div_reg">

			<div class="field">
				<label class="label"><?= GetMessage('NAME')?></label>
				<div class="control">
					<input class="input" type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>">
				</div>
			</div>

			<div class="field">
				<label class="label"><?=GetMessage('LAST_NAME')?></label>
				<div class="control">
					<input class="input" type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>">
				</div>
			</div>

			<div class="field">
				<label class="label"><?=GetMessage('LOGIN')?><span class="starrequired"> *</span></label>
				<div class="control">
					<input class="input" type="text" name="LOGIN" maxlength="50" value="<?= $arResult["arUser"]["LOGIN"]?>">
				</div>
			</div>

			<div class="field">
				<label class="label"><?=GetMessage('EMAIL')?>
					<?php if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
				<div class="control">
					<input class="input" type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>">
				</div>
			</div>

			<?if($arResult['CAN_EDIT_PASSWORD']):?>
				<div class="field">
					<label class="label"><?=GetMessage('NEW_PASSWORD_REQ')?></label>
					<div class="control">
						<input class="input" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off">
					</div>
				</div>

				<div class="field">
					<label class="label"><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
					<div class="control">
						<input class="input" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off">
					</div>
				</div>
			<?php endif?>

			<div class="field">
				<label class="label"><?=GetMessage('USER_GENDER')?></label>
				<div class="control">
					<div class="select">
						<select name="PERSONAL_GENDER">
							<option value="M"<?=$arResult["arUser"]["PERSONAL_GENDER"] === "M" ? " SELECTED=\"SELECTED\"" : ""?>>
								<?=GetMessage("USER_MALE")?></option>
							<option <option value="F"<?=$arResult["arUser"]["PERSONAL_GENDER"] === "F" ? " SELECTED=\"SELECTED\"" : ""?>>
								<?=GetMessage("USER_FEMALE")?></option>
						</select>
					</div>
				</div>
			</div>

			<div class="field">
				<label class="label"><?=GetMessage("USER_PHOTO")?></label>
				<div class="control">


					<?php if ($arResult["arUser"]["PERSONAL_PHOTO"] <> ''): ?>

						<?=$arResult["arUser"]["PERSONAL_PHOTO_HTML"]?>
						<?php endif; ?>
				</div>
				<input name="PERSONAL_PHOTO" class="typefile" size="20" type="file">
			</div>

			<div class="field">
				<label class="label"><?=GetMessage('USER_CITY')?></label>
				<div class="control">
					<input class="input" type="text" name="PERSONAL_CITY" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>">
				</div>
			</div>

			<div class="field">
				<label class="label"><?=GetMessage("USER_NOTES")?></label>
				<div class="control">
					<textarea class="textarea" cols="30" rows="5" id="personal-notes" name="PERSONAL_NOTES"><?=$arResult["arUser"]["PERSONAL_NOTES"]?></textarea>
				</div>
			</div>

			<?// ******************** /User properties ***************************************************?>
			<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
			<p><input class="button is-link" type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">&nbsp;&nbsp;
				<input class="button is-link is-light" type="reset" value="<?=GetMessage('MAIN_RESET');?>"></p>
	</form>
</div>
</div>

	<script>
		document.forms.form1.onsubmit = function() {
			let personalNotes = this.PERSONAL_NOTES.value.trim();
			let error = false;

			if (personalNotes.length >= 1000)
			{
				let personalNotesClass = document.querySelector('#personal-notes');
				personalNotesClass.classList.add('is-danger', 'is-focused');
				error = true;
					alert('В поле "дополнительные заметки" слишком много текста!')
					return false;
			}

			// if (error)
			// {
			// 	alert('Заполните обязательные поля рецепта!')
			// 	return false;
			// }
			return true;
		};
	</script>

