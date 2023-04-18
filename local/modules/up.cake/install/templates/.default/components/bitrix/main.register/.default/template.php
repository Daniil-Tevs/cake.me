<?php
/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die(); ?>

<?
if (count($arResult["ERRORS"]) > 0):
	foreach ($arResult["ERRORS"] as $key => $error)
		if (intval($key) == 0 && $key !== 0)
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);
?>
	<article class="message is-danger">
		<div class="message-header">
		</div>
		<div class="message-body">
			<div class="content"><h3><?php ShowError(implode("<br><br>", $arResult["ERRORS"])); ?></h3></div>
		</div>
	</article>


<?php elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
	<p><?= GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
<?php endif; ?>

	<div class="content">


		<form method="post" class="box box-reg" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
			<? if($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?endif; ?>
			<label class="label label-reg-name is-size-2"><?=GetMessage("AUTH_REGISTER")?></label>

			<?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>

				<div class="field">
				<label class="label reg-value-name"><?=GetMessage("REGISTER_FIELD_".$FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
				</label>

				<? if ($FIELD === "PASSWORD" || $FIELD === "CONFIRM_PASSWORD"): ?>
					<div class="control">
						<input class="input" type="password" name="REGISTER[<?=$FIELD?>]"
							   value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="<?=GetMessage("REGISTER_FIELD_PASSWORD")?>" autocomplete="off">
					</div>

				<?if($arResult["SECURE_AUTH"]):?>
					<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
					<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
					</noscript>
					<script type="text/javascript">
						document.getElementById('bx_auth_secure').style.display = 'inline-block';
					</script>
				<?endif?>

					</div>
				<? elseif ($FIELD === "PERSONAL_GENDER"): ?>
					<div class="control">
						<div class="select">
							<select name="REGISTER[<?=$FIELD?>]">
								<option value="M"<?=$arResult["VALUES"][$FIELD] === "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
								<option value="F"<?=$arResult["VALUES"][$FIELD] === "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
							</select>
						</div>
					</div>
				<? elseif ($FIELD === "PERSONAL_NOTES"): ?>
					<div class="control">
						<textarea class="textarea" name="REGISTER[<?=$FIELD?>]" placeholder="<?=GetMessage("REGISTER_INFO_FIELD")?>"><?=$arResult["VALUES"][$FIELD]?></textarea>
					</div>

				<? elseif ($FIELD === "EMAIL"): ?>
					<div class="control">
						<input class="input" name="REGISTER[<?=$FIELD?>]" type="email" placeholder="<?=GetMessage("REGISTER_EMAIL_FIELD")?>">
						<?=$arResult["VALUES"][$FIELD]?>
					</div>
				<? else: ?>
					<div class="control">
						<input class="input" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>"
							   placeholder="">
					</div>

				<? endif; ?>
			<? endforeach; ?>

			<?// ********************* User properties ***************************************************?>
			<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
				<tr><td colspan="2"><?=trim($arParams["USER_PROPERTY_NAME"]) <> '' ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></td></tr>
				<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
					<tr><td><?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;?></td><td>
							<?$APPLICATION->IncludeComponent(
								"bitrix:system.field.edit",
								$arUserField["USER_TYPE"]["USER_TYPE_ID"],
								array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
				<?endforeach;?>
			<?endif;?>

			<? if ($arResult["USE_CAPTCHA"] == "Y"): ?>
				<div class="field">
					<label class="label"><?=GetMessage("REGISTER_CAPTCHA_TITLE")?>:</label>

					<div class="control">
						<input class="input" type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>">
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
					</div>
				</div>

				<div class="field">
					<label class="label"><?=GetMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span></label>
					<div class="control">
						<input type="text" class="input" name="captcha_word" maxlength="50" value="" autocomplete="off">
					</div>
				</div>
			<? endif?>

			<div class="field is-grouped is-grouped-centered is-reg-buttons">
				<div class="control">
					<input class="button is-link" type="submit" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>">
				</div>
				<div class="control">
					<a href="/" class="button is-link is-light"><?=GetMessage("REGISTER_BUTTON_CANCEL")?></a>
				</div>
			</div>

		</form>
		<div class="block block-redirect-auth">
			<p><?=GetMessage("REDIRECT_AUTH_MESSAGE")?> <a href="/auth/"><?=GetMessage("REDIRECT_AUTH_HREF")?></a></p>
		</div>

		<p><span class="starrequired">* </span><?=GetMessage("AUTH_REQ")?></p>
	</div>

