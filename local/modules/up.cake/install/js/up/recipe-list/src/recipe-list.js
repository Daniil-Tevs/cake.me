import { Type, Tag } from 'main.core';

export class RecipeList
{
	COUNT_RECIPE_IN_ROW = 3;
	LENGTH_DESCRIPTION = 200;
	END_PAGE = false

	constructor(options = {})
	{
		if (Type.isStringFilled(options.rootNodeId))
		{
			this.rootNodeId = options.rootNodeId;
		}
		else
		{
			throw new Error('RecipeList: options.rootNodeId required');
		}

		this.rootNode = document.getElementById(this.rootNodeId);

		if (!this.rootNode)
		{
			throw new Error(`RecipeList: element with id"${this.rootNodeId}" not found`);
		}
		this.recipeList = [];
		this.imageList = [];
		this.reload();
	}

	reload(step = 1)
	{
		this.loadList(step)
			.then((data) => {
				if(data[0].length !== this.recipeList.length)
				{
					this.recipeList = data[0];
					this.imageList = data[1];
					this.render();
				}
				else
				{
					this.END_PAGE = true
				}
			});
	}

	loadList(step = 1)
	{
		return new Promise((resolve, reject) => {
			BX.ajax.runAction('up:cake.recipe.getList',{
					data: {
						step: step,
					}
				})
				.then((response) => {
					const request = [response.data.recipeList,response.data.imageList]
					resolve(request);
				})
				.catch((error) => {
					reject(error);
				});
		});
	}

	render()
	{
		this.rootNode.innerHTML = '';

		let index = 1;
		let recipeContainerNode = Tag.render`<div class="columns"></div>`;
		this.recipeList.forEach(recipeData => {
			const recipeNode = Tag.render`
				<div class="column mt-5">
					<div class="card card-list">
						<div class="card-image">
							<figure class="image">
								<img src='${this.imageList[`up.cake_${recipeData.ID}_1`]??""}' alt="Placeholder image">
							</figure>
						</div>
						<div class="card-content">
							<div class="content">
								<a class="title mb-2" href="/detail/${recipeData.ID}/">${recipeData.NAME} </a>
								<hr>
								<p>${recipeData.DESCRIPTION.substring(0,this.LENGTH_DESCRIPTION)}...</p>
							</div>
						</div>
						<footer class="card-footer">
							<div class="card-footer-item">🕔 ${recipeData.TIME} min</div>
							<div class="card-footer-item">🔥 ${recipeData.CALORIES} calories</div>
							<div class="card-footer-item "><a href="/users/<?=htmlspecialcharsbx($recipe->getUser()->getID())?>">👨‍🍳${recipeData.UP_CAKE_MODEL_RECIPE_USER_NAME + ' ' + recipeData.UP_CAKE_MODEL_RECIPE_USER_LAST_NAME}</a></div>
						</footer>
					</div>
				</div>`;
			recipeContainerNode.appendChild(recipeNode);
			if (index % this.COUNT_RECIPE_IN_ROW === 0)
			{
				this.rootNode.appendChild(recipeContainerNode);
				recipeContainerNode = Tag.render`<div class="columns"></div>`;
			}
			index++;
		});
		this.rootNode.appendChild(recipeContainerNode);
	}

	setName(name)
	{
		if (Type.isString(name))
		{
			this.name = name;
		}
	}

	getName()
	{
		return this.name;
	}
}