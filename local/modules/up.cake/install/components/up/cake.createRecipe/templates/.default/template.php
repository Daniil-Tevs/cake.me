<?php

/**
 * @var array $arResult
 * @var array $arParams
 */
CJSCore::Init(["jquery"]);

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$tags = $arResult['TAGS'];
$types = $arResult['TYPES'];

$isError = $arResult['ERROR_CREATE'];

Loc::loadMessages(__FILE__); ?>

<?php
if ($isError): ?>
	<div class="notification is-danger is-light error-edit-recipe">
		<p>Произошла ошибка при создании рецепта!</p>
	</div>
<?php
endif; ?>

<style> .recently,.search-container,.filter {display: none;}</style>

<div class="content">
	<form class="box" name="form_add_recipe" method="post" id="recipe-form" target="_top" action="/recipe/create/" enctype="multipart/form-data">
		<div class="create-page-main-label create-header">Новый рецепт</div>

		<div class="block is-flex add-form-recipe-name">
			<input class="input is-large add-form-recipe-name-input" id="recipe-name" name="RECIPE_NAME" type="text" placeholder="Название рецепта">
		</div>
		<hr>
		<div class="block is-flex add-form-recipe-main-image">
			<div class="field update-image-delete-1">
				<label id="recipe-main-image-label" class="label create-page-main-label-image">Изображение 1:</label>
				<input type="file" id="recipe-main-image-1" name="RECIPE_IMAGES_MAIN[]" onchange="return fileValidation('recipe-main-image-1')" />
			</div>
		</div>

		<div class="field is-flex add-form-recipe-image-buttons">
			<a class="image-button button is-primary is-light">добавить</a>
			<a class="image-delete-button button is-warning is-light">Удалить</a>
		</div>

		<hr>
		<div class="field">
			<label class="label create-page-main-label">Описание:</label>

			<div class="field add-recipe-desc">
				<div class="field">
					<div class="control">
						<textarea class="textarea" maxlength="2000" id="recipe-desc" name="RECIPE_DESC" placeholder="Описание"></textarea>
					</div>
				</div>
			</div>

			<hr>
			<div class="block is-flex add-form-recipe-info-block">
				<div class="field">
					<label class="label">Количество порций:</label>
					<div class="control">
						<input class="input add-recipe-info-block-input" id="recipe-portion" name="RECIPE_PORTION" type="number" value="1" min="1" max="100" placeholder="">
					</div>
				</div>

			<div class="field">
				<label class="label">Время приготовления (мин):</label>
				<div class="control">
					<input class="input add-recipe-info-block-time" value="1" min="1" max="1000" id="recipe-time" name="RECIPE_TIME" type="number" placeholder="">
				</div>
			</div>

			<div class="field">
				<label class="label">Калории:</label>
				<div class="control">
					<input class="input add-recipe-info-block-input" id="recipe-calories" name="RECIPE_CALORIES" type="number" min="1" max="10000" placeholder="">
				</div>
			</div>
		</div>

			<hr>
			<div class="field is-flex add-form-recipe-tag-block">
			<label class="label create-page-label-tag">Категории блюда:</label>
			<div class="control add-recipe-control-tags is-flex">
				<div class="select add-recipe-tags-select update-tag-delete-1">
					<select id="tag-1" name="RECIPE_TAGS[]">

						<?php foreach ($tags as $tag): ?>
						<option><?= $tag->getName() ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

				<div class="field">
					<a id="tag-button" class="tag-button button is-primary is-light">добавить тег</a>
					<a class="tag-delete-button button is-warning is-light">Удалить тег</a>
				</div>
			</div>
			<hr>
			<div class="field is-flex add-form-recipe-tag-block">
				<label class="label create-page-label-tag">Ингредиенты:</label>
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
					<tr>
						<th></th>
						<th>Название</th>
						<th>Количество</th>
						<th>Единица измерения</th>
					</tr>
					</thead>
					<tbody class="table-add-recipe-ingredient">
						<tr class="update-ingredient-delete-1">
							<th>1</th>
							<td><input class="input" id="recipe-ingredient-name-1" name="RECIPE_INGREDIENT[NAME][]" type="text"></td>
							<td><input class="input" id="recipe-ingredient-value-1"  name="RECIPE_INGREDIENT[VALUE][]" step="0.1" min="0.1" max="10000" type="number"></td>
							<td>
								<div class="select add-recipe-tags-select">
									<select name="RECIPE_INGREDIENT[TYPE][]" id="recipe-ingredient-type-1">
										<?php foreach ($types as $type): ?>
											<option ><?= $type->getId() ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</td>
						</tr>
					</tbody>
				</table>



				<div class="field">
					<a class="table-button button is-primary is-light">Добавить ингредиент</a>
					<a class="ingredient-delete-button button is-warning is-light">Удалить ингредиент</a>
				</div>
			</div>

			<hr>

			<div class="field is-flex add-form-recipe-tag-block">
				<label class="label create-page-label-tag">Шаги приготовления блюда:</label>

				<div class="field add-recipe-instruction">
					<div class="field instruct update-instruction-delete-1">
						<div class="step-head">
							<label class="label">Шаг 1:</label>
							<input type="file" name="RECIPE_INSTRUCTION_IMAGES[]"/>
						</div>

						<div class="field is-flex  add-recipe-instruction-textarea">
							<div class="field">
								<div class="control">
								<textarea class="textarea add-recipe-textarea-input" maxlength="1000"
										  id="recipe-instruction-1" name="RECIPE_INSTRUCTION[]" placeholder="Описание"></textarea>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="field">
					<a class="instruction-button button is-primary is-light">Добавить шаг</a>
					<a class="instruction-delete-button button is-danger is-light">Удалить шаг</a>
				</div>


			<div class="field is-grouped is-grouped-centered is-add-form-buttons">
				<div class="control">
					<input class="button is-link" type="submit" name="addRecipe" value="Сохранить">
				</div>
				<div class="control">
					<a href="/" class="button is-link is-light">Отмена</a>
				</div>
			</div>


	</form>
</div>

<script>


	let $countMainImage = 2;
	function openSelectMainImageModal()
	{

		const modalImage = $(`
			<div class="field update-image-delete-${$countMainImage}">
				<label class="label create-page-main-label-image">Изображение ${$countMainImage}:</label>
				<input type="file" id="recipe-main-image-${$countMainImage}" name="RECIPE_IMAGES_MAIN[]" onchange="return fileValidation('recipe-main-image-${$countMainImage}')"/>
			</div>
	`);
		$countMainImage++;
		$('.add-form-recipe-main-image').append(modalImage);

	}

	$('.image-button').on('click', () => {
		if ($countMainImage <= 5)
		{
			openSelectMainImageModal();
		}
		else
		{
			alert('Слишком много изображений!');
		}

	});

	let $countInstruction = 2;
	function openSelectInstructionModal()
	{

		const modalInstruction = $(`
			<div class="field update-instruction-delete-${$countInstruction}">
				<label class="label">Шаг ${$countInstruction}:</label>

					<div class="field is-flex  add-recipe-instruction-textarea">
						<input type="file" name="RECIPE_INSTRUCTION_IMAGES[]" />

						<div class="field">
							<div class="control">
								<textarea class="textarea add-recipe-textarea-input" maxlength="1000"
									id="recipe-instruction-${$countInstruction}" name="RECIPE_INSTRUCTION[]" placeholder="Описание"></textarea>
							</div>
						</div>
					</div>
				</div>
	`);
		$countInstruction++;
		$('.add-recipe-instruction').append(modalInstruction);

	}

	$('.instruction-button').on('click', () => {
		if ($countInstruction <= 10)
		{
			openSelectInstructionModal();
		}
		else
		{
			alert('Слишком много шагов рецепта!');
		}

	});


	let $countTable = 2;
	function openSelectIngredientModal()
	{

		const modalTable = $(`
				<tr class="update-ingredient-delete-${$countTable} " id="recipe-ingredient-${$countTable}">
							<th>${$countTable}</th>
							<td><input class="input" id="recipe-ingredient-name-${$countTable}" name="RECIPE_INGREDIENT[NAME][]" type="text"></td>
							<td><input class="input" id="recipe-ingredient-value-${$countTable}" name="RECIPE_INGREDIENT[VALUE][]"
							step="0.1" min="0.1" max="10000" type="number"></td>
							<td>
								<div class="select add-recipe-tags-select">
									<select name="RECIPE_INGREDIENT[TYPE][]" id="recipe-ingredient-type-${$countTable}">
										<?php foreach ($types as $type): ?>
											<option ><?= $type->getId() ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</td>
						</tr>
	`);
		$countTable++;
		$('.table-add-recipe-ingredient').append(modalTable);

	}

	$('.table-button').on('click', () => {
		if ($countTable <= 10)
		{
			openSelectIngredientModal();
		}
		else
		{
			alert('Слишком много ингредиентов!');
		}

	});


	let $countTags = 2;
	function openSelectTagModal()
	{

		const modalTag = $(`
				<div class="select add-recipe-tags-select update-tag-delete-${$countTags}">
					<select id="tag-${$countTags}" name="RECIPE_TAGS[]">
						<?php foreach ($tags as $tag): ?>
						<option><?= $tag->getName() ?></option>
						<?php endforeach; ?>
					</select>
				</div>
	`);
		$countTags++;
		$('.add-recipe-control-tags').append(modalTag);

	}

	$('.tag-button').on('click', () => {
		if ($countTags <= 6)
		{
			openSelectTagModal();
		}
		else
		{
			alert('Слишком много тегов!');
		}

	});


	$('.image-delete-button').on('click', function(){
		if ($countMainImage - 1 > 1)
		{
			$('.update-image-delete-' + ($countMainImage - 1)).remove();
			$countMainImage = $countMainImage - 1;
		}
	});

	$('.tag-delete-button').on('click', function(){
		if ($countTags - 1 > 1)
		{
			$('.update-tag-delete-' + ($countTags - 1)).remove();
			$countTags = $countTags - 1;
		}
	});

	$('.ingredient-delete-button').on('click', function(){
		if ($countTable - 1 > 1)
		{
			$('.update-ingredient-delete-' + ($countTable - 1)).remove();
			$countTable = $countTable - 1;
		}
	});

	$('.instruction-delete-button').on('click', function(){
		if ($countInstruction - 1 > 1)
		{
			$('.update-instruction-delete-' + ($countInstruction - 1)).remove();
			$countInstruction = $countInstruction - 1;
		}
	});
</script>