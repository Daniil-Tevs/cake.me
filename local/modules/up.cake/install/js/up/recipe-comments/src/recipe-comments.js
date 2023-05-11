import { Type, Tag } from 'main.core';

export class RecipeComments
{
	COUNT_COMMENT_IN_ROW = 10;
	LENGTH_COMMENT = 1024;
	END_PAGE = false;

	constructor(options = {})
	{
		if (Type.isStringFilled(options.rootNodeId))
		{
			this.rootNodeId = options.rootNodeId;
		}
		else
		{
			throw new Error('CommentList: options.rootNodeId required');
		}

		if (Type.isInteger(options.recipeId))
		{
			this.recipeId = options.recipeId;
		}

		this.rootNode = document.getElementById(this.rootNodeId);
		this.commentList = []

		if (!this.rootNode)
		{
			throw new Error(`CommentList: element with id"${this.rootNodeId}" not found`);
		}

		this.reload();
	}

	reload(step = 1)
	{
		this.loadList(step)
			.then((commentList) => {
				if (commentList.length !== this.commentList.length || commentList.length === 0)
				{
					this.commentList = commentList;
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
		return new Promise((resolve, reject) => {
			BX.ajax.runAction('up:cake.comment.getList', {
					data: {
						step: step,
						recipeId: this.recipeId ?? null,
					},
				})
				.then((response) => {
					resolve(response.data.commentList);
				})
				.catch((error) => {
					reject(error);
				});
		});
	}

	render()
	{
		this.rootNode.innerHTML = '';
		this.commentList.forEach(commentData => {
			const commentNode = Tag.render`<div class="card"><div class="card-content comment-card pl-2 ">
					<div class="media">
						<div class="media-left mr-2">
							<figure class="image is-32x32">
								<img class="is-rounded" src="${(commentData.UP_CAKE_MODEL_COMMENT_USER_PERSONAL_PHOTO !== '')? commentData.UP_CAKE_MODEL_COMMENT_USER_PERSONAL_PHOTO:((commentData.UP_CAKE_MODEL_COMMENT_USER_PERSONAL_GENDER === 'M')?'/local/modules/up.cake/install/templates/cake/images/profileMale.png':'/local/modules/up.cake/install/templates/cake/images/profileFemale.png')}" alt="">
							</figure>
						</div>
						<div class="media-content">
							<a href="/users/${commentData.UP_CAKE_MODEL_COMMENT_USER_ID}/" class="title is-6">${commentData.UP_CAKE_MODEL_COMMENT_USER_NAME + ' ' + commentData.UP_CAKE_MODEL_COMMENT_USER_LAST_NAME}:</a>
							
						</div>
					</div>
			
					<div class="container comment-title ml-3">
						<p>${commentData.TITLE.substring(0,this.LENGTH_COMMENT)}</p>
					</div></div>`;
			this.rootNode.appendChild(commentNode);
		});
	}

	addComment(title)
	{
		if (!Type.isStringFilled(title))
		{
			throw new Error('RecipeComment: title should be string or required');
		}
		BX.ajax.runAction('up:cake.comment.addComment', {
				data: {
					recipeId: this.recipeId,
					title: title,
				},
			})
			.then((response) => {
				this.END_PAGE = false;
				this.commentList = [];
				this.reload(1);
			})
			.catch((error) => {
				console.log(error);
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