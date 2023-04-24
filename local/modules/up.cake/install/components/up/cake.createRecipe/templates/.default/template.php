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

Loc::loadMessages(__FILE__); ?>

<div class="content">
	<form class="box" name="form_add_recipe" method="post" target="_top" action="/recipe/create/" enctype="multipart/form-data">
		<div class="create-page-main-label">Новый рецепт</div>

		<div class="block is-flex add-form-recipe-name">
			<input class="input is-large add-form-recipe-name-input" name="RECIPE_NAME" type="text" placeholder="Название рецепта">
		</div>
		<hr>
		<div class="create-page-main-label">Главное изображение:</div>
		<div class="block is-flex add-form-recipe-main-image">
			<label class="label create-page-main-label-image">Изображение 1:</label>
			<input type="file" name="RECIPE_IMAGES_MAIN[1]" />
		</div>

		<div class="field is-flex add-form-recipe-tag-block">
		<a class="image-button button">добавить изображение</a>
		</div>

		<hr>
		<div class="field">
			<label class="label create-page-main-label">Описание:</label>

			<div class="field add-recipe-desc">
				<div class="field">
					<div class="control">
						<textarea class="textarea" maxlength="2000" name="RECIPE_DESC" placeholder="Описание"></textarea>
					</div>
				</div>
			</div>

			<hr>
		<div class="block is-flex add-form-recipe-info-block">
			<div class="field">
				<label class="label">Количество порций:</label>
				<div class="control">
					<input class="input add-recipe-info-block-input" name="RECIPE_PORTION" type="number" value="1" min="1" max="100" placeholder="">
				</div>
			</div>

			<div class="field">
				<label class="label">Время приготовления (мин):</label>
				<div class="control">
					<input class="input add-recipe-info-block-time" name="RECIPE_TIME" type="number" placeholder="">
				</div>
			</div>

			<div class="field">
				<label class="label">Калории:</label>
				<div class="control">
					<input class="input add-recipe-info-block-input" name="RECIPE_CALORIES" type="number" value="1" min="1" max="10000" placeholder="">
				</div>
			</div>
		</div>

			<hr>
			<div class="field is-flex add-form-recipe-tag-block">
			<label class="label create-page-label-tag">Категории блюда:</label>
			<div class="control add-recipe-control-tags is-flex">
				<div class="select add-recipe-tags-select">
					<select name="RECIPE_TAGS[]">
						<?php foreach ($tags as $tag): ?>
						<option ><?= $tag->getName() ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

				<a class="tag-button button">добавить тег</a>



				<hr>
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
						<tr>
							<th>1</th>
							<td><input class="input" name="RECIPE_INGREDIENT[NAME][1]" type="text"></td>
							<td><input class="input" name="RECIPE_INGREDIENT[VALUE][1]" type="number"></td>
							<td>
								<div class="select add-recipe-tags-select">
									<select name="RECIPE_INGREDIENT[TYPE][1]">
										<?php foreach ($types as $type): ?>
											<option ><?= $type->getId() ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</td>
						</tr>
					</tbody>
				</table>



				<a class="table-button button">Добавить ингредиент</a>

				<hr>
				<label class="label create-page-label-tag">Шаги:</label>
				<hr>



				<div class="field add-recipe-instruction">
					<label class="label">Шаг 1:</label>

					<div class="field is-flex  add-recipe-instruction-textarea">
						<input type="file" name="RECIPE_INSTRUCTION_IMAGES[1]" />
						<div class="field">
							<div class="control">
								<textarea class="textarea add-recipe-textarea-input" maxlength="1000" name="RECIPE_INSTRUCTION[1]" placeholder="Описание"></textarea>
							</div>
						</div>
					</div>

				</div>
					<a class="instruction-button button">Добавить шаг</a>



				<div class="field is-grouped is-grouped-centered is-add-form-buttons">
					<div class="control">
						<input class="button is-link" type="submit" name="addRecipe" value="Сохранить">
					</div>
					<div class="control">
						<a href="/" class="button is-link is-light">Отмена</a>
					</div>
				</div>

				<div class="field">

				</div>
	</form>

	<script>
		let $countMainImage = 2;
		function openSelectMainImageModal()
		{

			const modalImage = $(`
			<label class="label create-page-main-label-image">Изображение ${$countMainImage}:</label>
			<input type="file" name="RECIPE_IMAGES_MAIN[${$countMainImage}]" />
	`);
			$countMainImage++;
			$('.add-form-recipe-main-image').append(modalImage);

		}

		$('.image-button').on('click', () => {
			if ($countMainImage <= 3)
			{
				openSelectMainImageModal();
			}
			else
			{
				alert('Слишком много изображений!');
			}

		});

	</script>


	<script>
		let $countInstruction = 2;
		function openSelectInstructionModal()
		{

			const modalInstruction = $(`
				<label class="label">Шаг ${$countInstruction}:</label>

					<div class="field is-flex  add-recipe-instruction-textarea">
						<input type="file" name="RECIPE_INSTRUCTION_IMAGES[${$countInstruction}]" />

						<div class="field">
							<div class="control">
								<textarea class="textarea add-recipe-textarea-input" maxlength="1000" name="RECIPE_INSTRUCTION[${$countInstruction}]" placeholder="Описание"></textarea>
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

	</script>



	<script>
		let $countTable = 2;
		function openSelectIngredientModal()
		{

			const modalTable = $(`
				<tr>
							<th>${$countTable}</th>
							<td><input class="input" name="RECIPE_INGREDIENT[NAME][${$countTable}]" type="text"></td>
							<td><input class="input" name="RECIPE_INGREDIENT[VALUE][${$countTable}]" type="number"></td>
							<td>
								<div class="select add-recipe-tags-select">
									<select name="RECIPE_INGREDIENT[TYPE][${$countTable}]">
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

	</script>


	<script>
		let $countTags = 2;
		function openSelectTagModal()
		{

			const modalTag = $(`
				<div class="select add-recipe-tags-select">
					<select name="RECIPE_TAGS[]">
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
				if ($countTags <= 10)
				{
					openSelectTagModal();
				}
				else
				{
					alert('Слишком много тегов!');
				}

			});
	</script>
</div>
