import { Type, Tag } from 'main.core';
import { RecipeCard } from './recipe-card.js';
import { Reaction } from './recipe-reaction.js';

export class RecipeList
{
	COUNT_RECIPE_IN_ROW = 3;
	LENGTH_DESCRIPTION = 200;
	title = '';
	filters = [];
	recipeList = [];
	imageList = [];
	type = null;
	userId = null;
	anotherUserId = null;
	reaction = null;
	END_PAGE = false;

	constructor(options = {})
	{
		if (Type.isStringFilled(options.rootNodeId)) {
			this.rootNodeId = options.rootNodeId;
		}
		else {
			throw new Error('RecipeList: options.rootNodeId required');
		}

		if (Type.isInteger(options.userId)) {
			this.userId = options.userId;
		}
		if (Type.isInteger(options.anotherUserId)) {
			this.anotherUserId = options.anotherUserId;
		}

		if ( Type.isString(options.type))
		{
			this.type = options.type;
		}
		else {
			this.type = (this.userId===null || this.userId<=0)?'unregister':null;
		}
		console.log(this.type);

		this.filters['tags'] = [];

		this.title = window.location.search.replace('?', '').split('&').reduce(function(p, e) {
			var a = e.split('=');
			p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
			return p;
		}, {})['search-string'];

		this.rootNode = document.getElementById(this.rootNodeId);

		if (!this.rootNode)
		{
			throw new Error(`RecipeList: element with id"${this.rootNodeId}" not found`);
		}

		this.reload();

		this.reaction = new Reaction(this.userId);
	}

	reload(step = 1)
	{
		this.loadList(step)
			.then((data) => {
				if (data[0].length !== this.recipeList.length || data[0].length === 0)
				{

					this.recipeList = data[0];
					this.imageList = data[1];
					this.userReactions = data[2];
					this.render();
				}
				else
				{
					this.END_PAGE = true;
				}
			});
	}

	loadList(step = 1)
	{
		console.log(this);
		return new Promise((resolve, reject) => {
			BX.ajax.runAction('up:cake.recipe.getList', {
					data: {
						step: step,
						type: this.type,
						userId: this.userId,
						anotherUserId: this.anotherUserId,
						title: this.title ?? null,
						filters: this.filters['tags'],
					},
				})
				.then((response) => {
					const request = [response.data.recipeList, response.data.imageList, response.data.userReactions];
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

		let recipeContainerNode = Tag.render`<div class="columns card-lists"></div>`;

		this.recipeList.forEach(recipeData => {
			recipeData['USER_REACTION'] = (this.userReactions.indexOf(Number(recipeData.ID)) !== -1)
			const recipeNode = (new RecipeCard(recipeData, this.imageList[recipeData.ID], this.type,this.userId)).cardNode;
			recipeContainerNode.appendChild(recipeNode);
			if (index % this.COUNT_RECIPE_IN_ROW === 0)
			{
				this.rootNode.appendChild(recipeContainerNode);
				recipeContainerNode = Tag.render`<div class="columns card-lists"></div>`;
			}
			index++;
		});
		this.rootNode.appendChild(recipeContainerNode);

		if(this.userId === null || this.userId <= 0)
		{
			let likes = this.rootNode.getElementsByClassName('like');
			while(likes.length) {
				likes[0].parentNode.removeChild(likes[0]);
			}
			let cardHeader = this.rootNode.getElementsByClassName('content-header');
			for (let i = 0; i < cardHeader.length; i++)
			{
				cardHeader[i].style.justifyContent = 'flex-start';
			}
		}
	}

	changeFilters(type, id = 0)
	{
		id = Number(id);
		if (!Type.isInteger(id))
		{
			throw new Error('RecipeList: id checkbox should be integer');
		}
		if (!Type.isStringFilled(type))
		{
			throw new Error('RecipeList: type should be string');
		}

		if (id !== 0)
		{
			if (this.filters['tags'].indexOf(this.filters[type]) >= 0)
			{
				this.filters['tags'].splice(this.filters['tags'].indexOf(this.filters[type]), 1);
			}
			this.filters['tags'].push(id);
			this.filters[type] = id;
		}
		else
		{
			this.filters['tags'].splice(this.filters['tags'].indexOf(this.filters[type]), 1);
			delete this.filters[type];
		}
		this.END_PAGE = false;
		this.recipeList = [];
		this.reload(1);
	};

	changeTitle(title)
	{
		if (!Type.isStringFilled(title) && title.trim() !== '')
		{
			throw new Error('RecipeList: title should be string');
		}
		this.title = title.trim();
		this.END_PAGE = false;
		this.recipeList = [];
		this.reload(1);
	}

	deleteRecipe(id)
	{
		id = Number(id);
		if (!Type.isInteger(id))
		{
			throw new Error('RecipeCard: id should be int');
		}
		BX.ajax.runAction('up:cake.recipe.deleteRecipe', {
				data: {
					id: id,
					userId: this.userId,
				},
			})
			.then((response) => {
				this.END_PAGE = false;
				this.recipeList = [];
				this.reload(1);
			});
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