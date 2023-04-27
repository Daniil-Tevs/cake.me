import { Type, Tag } from 'main.core';
import {RecipeCard} from './recipe-card.js';

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

		if (Type.isInteger(options.userId))
		{
			this.userId = options.userId;
		}

		this.type = options.type;

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
						userId: this.userId ?? null,
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
		console.log(this.imageList)
		let index = 1;
		let recipeContainerNode = Tag.render`<div class="columns"></div>`;
		this.recipeList.forEach(recipeData => {
			const recipeNode = (new RecipeCard(recipeData,this.imageList[recipeData.ID],this.type)).cardNode;
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