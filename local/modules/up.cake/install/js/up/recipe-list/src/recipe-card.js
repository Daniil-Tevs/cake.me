import { Tag } from 'main.core';

export class RecipeCard
{
	cardNode;

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

	simpleCard(recipeData, image)
	{
		return Tag.render`
				<div class="column mt-5">
					<div class="card card-list" id="${recipeData.ID}">
						<div class="card-image">
							<figure class="image">
								<img src='${image ?? ''}' alt="Placeholder image">
							</figure>
						</div>
						<div class="card-content">
							<div class="content">
								<div class="content-header">
									<a class="title mb-2" href="/detail/${recipeData.ID}/">${recipeData.NAME} </a>
									<button class="like ${recipeData.USER_REACTION?'like-active':''}" id="like-btn-${recipeData.ID}" value="${recipeData.ID}" onclick="window.CakeRecipeList.reaction.changeLike(this.value)"></button>
								</div>
								
								<hr>
								<p>${recipeData.DESCRIPTION.substring(0, this.LENGTH_DESCRIPTION)}...</p>
							</div>
						</div>
						<footer class="card-footer">
							<div class="card-footer-item">🕔 ${recipeData.TIME} min</div>
							<div class="card-footer-item">🔥 ${recipeData.CALORIES} calories</div>
							<div class="card-footer-item "><a href="/users/${recipeData.UP_CAKE_MODEL_RECIPE_USER_ID}/">👨‍🍳${recipeData.UP_CAKE_MODEL_RECIPE_USER_NAME + ' ' + recipeData.UP_CAKE_MODEL_RECIPE_USER_LAST_NAME}</a></div>
						</footer>
					</div>
				</div>`;
	}

	profileCard(recipeData, image)
	{
		console.log(recipeData);
		return Tag.render`
				<div class="column mt-5">
					<div class="card card-list" id="${recipeData.ID}">
						<div class="card-image">
							<figure class="image">
								<img src='${image ?? ''}' alt="Placeholder image">
							</figure>
						</div>
						<div class="card-content">
							<div class="content">
								<a class="title mb-2" href="/detail/${recipeData.ID}/">${recipeData.NAME} </a>
								<hr>
								<p>${recipeData.DESCRIPTION.substring(0, this.LENGTH_DESCRIPTION)}...</p>
							</div>
						</div>
						<footer class="card-footer">
							<div class="card-footer-item">Likes: ${recipeData.REACTION}</div> 	
							<a href="/recipe/edit/${recipeData.ID}/" class="card-footer-item button profile-button-edit">Edit</a>
    						<button class="card-footer-item button profile-button-delete" value="${recipeData.ID}" onclick=" window.step = 1 ; window.CakeRecipeList.deleteRecipe(this.value);">Delete</button>
						</footer>
					</div>
				</div>`;
	}
}