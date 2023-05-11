import { Tag } from 'main.core';

export class RecipeCard
{
	cardNode;
	LENGTH_DESCRIPTION = 110;

	constructor(recipeData, image, type)
	{
		this.recipeId = Number(recipeData.ID);
		if (type === 'profile')
		{
			this.cardNode = this.profileCard(recipeData, image);
		}
		else
		{
			this.cardNode = this.simpleCard(recipeData, image);
		}
	}

	getDescription(description = '')
	{
		if (description.length <= this.LENGTH_DESCRIPTION)
		{
			return description;
		}
		else
		{
			return description.substring(0, this.LENGTH_DESCRIPTION) + '...';
		}
	}

	simpleCard(recipeData, image)
	{
		return Tag.render`
				<div class="card card-list" id="${recipeData.ID}">
						<div class="card-image">
							<figure class="image">
								<img src='${image ?? ''}'>
							</figure>
						</div>
						<div class="card-content">
							<div class="content">
								<div class="content-header">
									<a class="title mb-2" href="/detail/${recipeData.ID}/">${recipeData.NAME} </a>
									<button class="like ${recipeData.USER_REACTION ? 'like-active' : ''}" id="like-btn-${recipeData.ID}" value="${recipeData.ID}" onclick="window.CakeRecipeList.reaction.changeLike(this.value)"></button>
								</div>
								
								<hr>
								<p>${this.getDescription(recipeData.DESCRIPTION)}</p>
							</div>
						</div>
						<footer class="card-footer">
							<div class="card-footer-item">🕔 ${recipeData.TIME} min</div>
							${(recipeData.CALORIES !== '')? "<div class=\"card-footer-item\">🔥" +recipeData.CALORIES + " calories</div>" :'' }
							<div class="card-footer-item "><a href="/users/${recipeData.UP_CAKE_MODEL_RECIPE_USER_ID}/">👨‍🍳${recipeData.UP_CAKE_MODEL_RECIPE_USER_NAME + ' ' + recipeData.UP_CAKE_MODEL_RECIPE_USER_LAST_NAME}</a></div>
						</footer>
					</div>`;
	}

	profileCard(recipeData, image)
	{
		return Tag.render`
				<div class="column mt-5">
					<div class="card card-list" id="${recipeData.ID}">
						<div class="card-image">
							<figure class="image">
								<img src='${image ?? ''}'>
							</figure>
						</div>
						<div class="card-content">
							<div class="content">
								<a class="title mb-2" href="/detail/${recipeData.ID}/">${recipeData.NAME} </a>
								<hr>
								<p>${this.getDescription(recipeData.DESCRIPTION)}</p>
							</div>
						</div>
						<footer class="card-footer">
							<div class="card-footer-item">❤ Likes: ${(recipeData.REACTION !== '')?recipeData.REACTION:0}</div> 	
							<a href="/recipe/edit/${recipeData.ID}/" class="card-footer-item button profile-button-edit">Edit</a>
    						<button class="card-footer-item button profile-button-delete" value="${recipeData.ID}" onclick=" window.step = 1 ; window.CakeRecipeList.deleteRecipe(this.value);">Delete</button>
						</footer>
					</div>
				</div>`;
	}
}