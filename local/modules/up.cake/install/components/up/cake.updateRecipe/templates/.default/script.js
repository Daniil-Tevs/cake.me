function fileValidation(imageId) {
	let recipeImage = document.getElementById(imageId);

	let filePath = recipeImage.value;

	let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
	if (!allowedExtensions.exec(filePath)) {
		alert('Можно добавить только изображение!');
		recipeImage.value = '';
		return false;
	}

	let file = recipeImage.files[0];
	if (file.size > 10485760)
	{
		alert('Размер файла не может превышать 10 мб!');
		recipeImage.value = '';
		return false;
	}
}

BX.ready(
	function()
	{
		document.forms.form_update_recipe.onsubmit = function() {
			let recipeName = this.RECIPE_NAME.value.trim();
			let recipePortion = this.RECIPE_PORTION.value.trim();
			let recipeTime = this.RECIPE_TIME.value.trim();
			let recipeCalories = this.RECIPE_CALORIES.value.trim();
			let recipeTags = document.getElementsByName('RECIPE_TAGS[]');
			let recipeInstruction = document.getElementsByName('RECIPE_INSTRUCTION[]');
			let recipeIngredientName = document.getElementsByName('RECIPE_INGREDIENT[NAME][]');
			let recipeIngredientValue = document.getElementsByName('RECIPE_INGREDIENT[VALUE][]');
			let recipeIngredientType = document.getElementsByName('RECIPE_INGREDIENT[TYPE][]');
			let recipeMainImage = document.getElementsByName('RECIPE_IMAGES_MAIN[]');
			let error = false;

			Array.from(document.querySelectorAll('.is-danger')).forEach(function(el) {
				el.classList.remove('is-danger');
				el.classList.remove('is-focused');
			});
			Array.from(document.querySelectorAll('#recipe-main-image-label')).forEach(function(el) {
				el.classList.remove('is-danger-image-recipe-form');
			});
			Array.from(document.querySelectorAll('#recipe-main-image')).forEach(function(el) {
				el.classList.remove('is-danger-image-recipe-form');
			});

			if (recipeName === '')
			{
				let recipeNameClass = document.querySelector('#recipe-name');
				recipeNameClass.classList.add('is-danger', 'is-focused');
				error = true;
			}

			if (recipePortion === '')
			{
				let recipePortionClass = document.querySelector('#recipe-portion');
				recipePortionClass.classList.add('is-danger', 'is-focused');
				error = true;
			}

			if (recipeTime === '')
			{
				let recipeTimeClass = document.querySelector('#recipe-time');
				recipeTimeClass.classList.add('is-danger', 'is-focused');

				error = true;
			}

			for (let i = 0; i < recipeInstruction.length; i++) {
				if (recipeInstruction[i].value.trim() === '')
				{
					let recipeInstructionClass = document.querySelector('#recipe-instruction-' + (i+1));
					recipeInstructionClass.classList.add('is-danger', 'is-focused');
					error = true;
				}
			}

			for (let i = 0; i < recipeIngredientName.length; i++) {

				if (recipeIngredientName[i].value.trim() === '' || document.availableIngredients.indexOf(recipeIngredientName[i].value.trim()) === -1)
				{
					let recipeInstructionClass = document.querySelector('#recipe-ingredient-name-' + (i+1));
					recipeInstructionClass.classList.add('is-danger', 'is-focused');
					error = true;
				}
				if (error)
				{
					alert('Такого игрединта нет в базе данных!')
					document.querySelector('#recipe-ingredient-name-' + (i+1)).scrollIntoView();
					return false;
				}
				if (recipeIngredientValue[i].value.trim() === '')
				{
					let recipeInstructionClass = document.querySelector('#recipe-ingredient-value-' + (i+1));
					recipeInstructionClass.classList.add('is-danger', 'is-focused');
					error = true;
				}
				if (recipeIngredientType[i].value.trim() === '')
				{
					let recipeInstructionClass = document.querySelector('#recipe-ingredient-type-' + (i+1));
					recipeInstructionClass.classList.add('is-danger', 'is-focused');
					error = true;
				}
			}

			// let isImage = false;
			// for (let i = 0; i < recipeMainImage.length; i++)
			// {
			// 	if (recipeMainImage[i].value !== '')
			// 	{
			// 		isImage = true;
			// 		break;
			// 	}
			// }
			//
			// console.log(isImage);
			// if (isImage === false)
			// {
			// 	let recipeMainImageClass = document.querySelector('#recipe-main-image');
			// 	let recipeMainImageLabelClass = document.querySelector('#recipe-main-image-label');
			// 	recipeMainImageClass.classList.add('is-danger-image-recipe-form');
			// 	recipeMainImageLabelClass.classList.add('is-danger-image-recipe-form');
			//
			// 	error = true;
			// }

			if (error)
			{
				alert('Заполните обязательные поля рецепта!')
				document.querySelector('#update-form').scrollIntoView();
				return false;
			}

			for (let i = 0; i < recipeTags.length; i++)
			{
				let $tagValue = recipeTags[i].value;
				for (let j = 0; j < recipeTags.length; j++)
				{
					if (i !== j)
					{
						if ($tagValue === recipeTags[j].value)
						{
							let recipeTag1Class = document.querySelector('#tag-' + (j+1));
							recipeTag1Class.classList.add('is-danger-tag-recipe', 'is-focused');
							let recipeTag2Class = document.querySelector('#tag-' + (i+1));
							recipeTag2Class.classList.add('is-danger-tag-recipe', 'is-focused');
							error = true;
						}
					}
				}
			}

			if (error)
			{
				alert('Теги повторяются!')
				document.querySelector('#recipe-time').scrollIntoView();
				return false;
			}

			for (let i = 0; i < recipeIngredientName.length; i++)
			{
				let $ingredientValue = recipeIngredientName[i].value;
				for (let j = 0; j < recipeIngredientName.length; j++)
				{
					if (i !== j)
					{
						if ($ingredientValue === recipeIngredientName[j].value)
						{
							let recipeIngredient1Class = document.querySelector('#recipe-ingredient-name-' + (j+1));
							recipeIngredient1Class.classList.add('is-danger', 'is-focused');
							let recipeIngredient2Class = document.querySelector('#recipe-ingredient-name-' + (i+1));
							recipeIngredient2Class.classList.add('is-danger', 'is-focused');
							error = true;
						}
					}
				}
			}

			if (error)
			{
				alert('Ингредиенты повторяются!')
				document.querySelector('#tag-button').scrollIntoView();
				return false;
			}

			return true;
		};

	}

);