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

[$recipe, $ingredients] = $arResult['RECIPE'];
$mainImages = $arResult['RECIPE_MAIN_IMAGES'];
$instructionImages = $arResult['RECIPE_INSTRUCTIONS_IMAGES'];

$errors = $arResult['ERROR_MESSAGE'];

Loc::loadMessages(__FILE__); ?>

<?php if (!empty($errors)): ?>
	<div class="notification is-danger is-light error-edit-recipe">
	<?php if ($errors[0] === true) ?>
		<p>Теги или ингредиенты не должны повторяться!</p>
	<?php if ($errors[1] === true) ?>
		<p>Текстовые поля шагов не должны быть пустыми!</p>
	<?php if ($errors[2] === true) ?>
		<p>Должен быть хотя бы один шаг или ингредиент!</p>
		</div>
	<?php endif; ?>

<div class="content">
	<form class="box" name="form_add_recipe" method="post" target="_top" action="/recipe/edit/<?=$recipe->getId()?>/" enctype="multipart/form-data">
		<div class="create-page-main-label">Изменить рецепт</div>

		<div class="block is-flex add-form-recipe-name">
			<input class="input is-large add-form-recipe-name-input" name="RECIPE_NAME" type="text" value="<?= htmlspecialcharsbx($recipe->getName()) ?>" placeholder="Название рецепта">
		</div>
		<hr>
		<div class="create-page-main-label">Главное изображение:</div>
		<div class="block is-flex add-form-recipe-main-image">

			<?php $imageCount = 1;
			foreach ($mainImages as $image): ?>
				<div class="field update-image-delete-<?= $imageCount ?>">
			<?= CFile::ShowImage($image['IMAGE_ID'], 100, 50, "border=0", "", true); ?>
			<label class="label create-page-main-label-image">Изображение <?= $imageCount ?>:</label>
			<input type="file" name="RECIPE_IMAGES_MAIN[]" />
				</div>
			<?php $imageCount++;
			endforeach; ?>
		</div>

		<div class="field is-flex add-form-recipe-image-buttons">
		<a class="image-button button is-primary is-light">добавить изображение</a>
			<a class="image-delete-button button is-danger is-light">Удалить изображение</a>
		</div>

		<hr>
		<div class="field">
			<label class="label create-page-main-label">Описание:</label>

			<div class="field add-recipe-desc">
				<div class="field">
					<div class="control">
						<textarea class="textarea" maxlength="2000" name="RECIPE_DESC" placeholder="Описание"><?= htmlspecialcharsbx($recipe->getDescription()) ?></textarea>
					</div>
				</div>
			</div>

			<hr>
		<div class="block is-flex add-form-recipe-info-block">
			<div class="field">
				<label class="label">Количество порций:</label>
				<div class="control">
					<input class="input add-recipe-info-block-input" name="RECIPE_PORTION" type="number"
						   value="<?= htmlspecialcharsbx($recipe->getPortionCount()) ?>" min="1" max="100" placeholder="">
				</div>
			</div>

			<div class="field">
				<label class="label">Время приготовления (мин):</label>
				<div class="control">
					<input class="input add-recipe-info-block-time" name="RECIPE_TIME"
						   value="<?= htmlspecialcharsbx($recipe->getTime()) ?>" type="number" placeholder="">
				</div>
			</div>

			<div class="field">
				<label class="label">Калории:</label>
				<div class="control">
					<input class="input add-recipe-info-block-input" name="RECIPE_CALORIES" type="number"
						   value="<?= htmlspecialcharsbx($recipe->getCalories()) ?>" min="0" max="10000" placeholder="">
				</div>
			</div>
		</div>

			<hr>
			<div class="field is-flex add-form-recipe-tag-block">
			<label class="label create-page-label-tag">Категории блюда:</label>
			<div class="control add-recipe-control-tags is-flex">
				<?php $tagCount = 1;
				foreach ($recipe->getTags() as $item): ?>
				<div class="select add-recipe-tags-select update-tag-delete-<?= $tagCount ?>">
					<select name="RECIPE_TAGS[]">
						<?php foreach ($tags as $tag): ?>

						<?php if (htmlspecialcharsbx($item->getName()) === htmlspecialcharsbx($tag->getName())): ?>
						<option selected="selected"><?= htmlspecialcharsbx($tag->getName()) ?></option>
						<?php else: ?>
						<option><?= htmlspecialcharsbx($tag->getName()) ?></option>
						<?php endif; ?>

						<?php endforeach; ?>
					</select>
				</div>
				<?php $tagCount++; endforeach; ?>

			</div>
				<div class="field">
					<a class="tag-button button is-primary is-light">добавить тег</a>
					<a class="tag-delete-button button is-danger is-light">Удалить тег</a>
				</div>


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
					<?php $countIngredient = 1;
					foreach ($ingredients as $ingredient): ?>
						<tr class="update-ingredient-delete-<?= $countIngredient ?>">
							<th><?= $countIngredient ?></th>
							<td><input class="input" name="RECIPE_INGREDIENT[NAME][]"
									   value="<?= htmlspecialcharsbx($ingredient->getIngredient()->getName()) ?>" type="text"></td>
							<td><input class="input" name="RECIPE_INGREDIENT[VALUE][]"
									   value="<?= htmlspecialcharsbx($ingredient->getCount()) ?>" type="number"></td>
							<td>
								<div class="select add-recipe-tags-select">
									<select name="RECIPE_INGREDIENT[TYPE][]">
										<?php foreach ($types as $type): ?>

										<?php if ( htmlspecialcharsbx($ingredient->getTypeId()) === htmlspecialcharsbx($type->getId())): ?>
											<option selected="selected"><?= $type->getId() ?></option>
										<?php else: ?>
										<option><?= $type->getId() ?></option>
										<?php endif; ?>

										<?php endforeach; ?>
									</select>
								</div>
							</td>
						</tr>
					<?php $countIngredient++;
					endforeach; ?>
					</tbody>
				</table>


				<div class="field">
				<a class="table-button button is-primary is-light">Добавить ингредиент</a>
				<a class="ingredient-delete-button button is-danger is-light">Удалить ингредиент</a>
				</div>
				<hr>
				<label class="label create-page-label-tag">Шаги:</label>
				<hr>



				<div class="field add-recipe-instruction">
					<?php
					$instructionCount = 1;
					foreach ($recipe->getInstructions() as $instruction): ?>
					<div class="field update-instruction-delete-<?= $instructionCount ?>">
					<label class="label">Шаг <?= htmlspecialcharsbx($instruction->getStep()) ?>:</label>
						<?= CFile::ShowImage($instructionImages[$instructionCount - 1]['IMAGE_ID'], 100, 100, "border=0", "", true); ?>

					<div class="field is-flex  add-recipe-instruction-textarea">
						<input type="file" name="RECIPE_INSTRUCTION_IMAGES[]" />
						<div class="field">
							<div class="control">
								<textarea class="textarea add-recipe-textarea-input" maxlength="1000" name="RECIPE_INSTRUCTION[]"><?= htmlspecialcharsbx($instruction->getDescription()) ?></textarea>
							</div>
						</div>
					</div>
					</div>
					<?php $instructionCount++;
					endforeach; ?>
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

				<div class="field">

				</div>
	</form>

	<script>
		let $countMainImage = <?= $imageCount ?>;
		function openSelectMainImageModal()
		{

			const modalImage = $(`
			<div class="field update-image-delete-${$countMainImage}">
			<label class="label create-page-main-label-image">Изображение ${$countMainImage}:</label>
			<input type="file" name="RECIPE_IMAGES_MAIN[]" />
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

	</script>


	<script>
		let $countInstruction = <?= $instructionCount ?>;
		function openSelectInstructionModal()
		{

			const modalInstruction = $(`
			<div class="field update-instruction-delete-${$countInstruction}">
				<label class="label">Шаг ${$countInstruction}:</label>

					<div class="field is-flex  add-recipe-instruction-textarea">
						<input type="file" name="RECIPE_INSTRUCTION_IMAGES[]" />

						<div class="field">
							<div class="control">
								<textarea class="textarea add-recipe-textarea-input" maxlength="1000" name="RECIPE_INSTRUCTION[]" placeholder="Описание"></textarea>
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

	</script>



	<script>
		let $countTable = <?= $countIngredient ?>;
		function openSelectIngredientModal()
		{

			const modalTable = $(`
				<tr class="update-ingredient-delete-${$countTable}">
							<th>${$countTable}</th>
							<td><input class="input" name="RECIPE_INGREDIENT[NAME][]" type="text"></td>
							<td><input class="input" name="RECIPE_INGREDIENT[VALUE][]" type="number"></td>
							<td>
								<div class="select add-recipe-tags-select">
									<select name="RECIPE_INGREDIENT[TYPE][]">
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
		let $countTags = <?= $tagCount ?>;
		function openSelectTagModal()
		{

			const modalTag = $(`
				<div class="select add-recipe-tags-select update-tag-delete-${$countTags}">
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
				if ($countTags <= 7)
				{
					openSelectTagModal();
				}
				else
				{
					alert('Слишком много тегов!');
				}

			});
	</script>

	<script>
		$('.image-delete-button').on('click', function(){
			if ($countMainImage - 1 > 0)
			{
				$('.update-image-delete-' + ($countMainImage - 1)).remove();
				$countMainImage = $countMainImage - 1;
			}
		});

		$('.tag-delete-button').on('click', function(){
			if ($countTags - 1 > 0)
			{
				$('.update-tag-delete-' + ($countTags - 1)).remove();
				$countTags = $countTags - 1;
			}
		});

		$('.ingredient-delete-button').on('click', function(){
			if ($countTable - 1 > 0)
			{
				$('.update-ingredient-delete-' + ($countTable - 1)).remove();
				$countTable = $countTable - 1;
			}
		});

		$('.instruction-delete-button').on('click', function(){
			if ($countInstruction - 1 > 0)
			{
				$('.update-instruction-delete-' + ($countInstruction - 1)).remove();
				$countInstruction = $countInstruction - 1;
			}
		});


	</script>
</div>
