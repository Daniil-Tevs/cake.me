import { Type } from 'main.core';
export class Reaction
{
	userId = [];
	userReactions = [];
	reformat = false;

	constructor(userId = 0)
	{
		if (!Type.isInteger(userId))
		{
			throw new Error('Reaction: userId required');
		}
		this.userId = userId;
		this.getUserLikes();
	}

	getUserLikes()
	{
		BX.ajax.runAction('up:cake.reaction.getLikesOfUser', {
				data: {
					userId: this.userId,
				},
			})
			.then((response) => {
				this.userReactions =  response.data;
			})
			.catch((error) => {
				console.log(error);
			});
	}

	changeLike(recipeId)
	{
		if(!this.reformat)
			this.reformatUserReactions()
		recipeId = Number(recipeId);
		if (!Type.isInteger(recipeId))
		{
			throw new Error('Reaction: id should be int');
		}
		(this.userReactions.indexOf(recipeId) === -1) ? this.addLike(recipeId) : this.removeLike(recipeId);
	}

	addLike(recipeId)
	{
		if (!Type.isInteger(recipeId))
		{
			throw new Error('Reaction: id should be int');
		}
		BX.ajax.runAction('up:cake.reaction.addLike', {
				data: {
					userId: this.userId,
					recipeId: recipeId,
				},
			})
			.then(() => {
				this.userReactions.push(Number(recipeId));
				document.getElementById(`like-btn-${recipeId}`).classList.add('like-active');
			})
			.catch((error) => {
				console.log(error);
			});
	}

	removeLike(recipeId)
	{
		if (!Type.isInteger(recipeId))
		{
			throw new Error('Reaction: id should be int');
		}
		BX.ajax.runAction('up:cake.reaction.removeLike', {
				data: {
					userId: this.userId,
					recipeId: recipeId,
				},
			})
			.then(() => {
				this.userReactions.splice(this.userReactions.indexOf(Number(recipeId)),1);
				document.getElementById(`like-btn-${recipeId}`).classList.remove('like-active');
			})
			.catch((error) => {
				console.log(error);
			});
	}

	reload()
	{
		if(this.userReactions)
		{
			this.userReactions.forEach(function(id) {
				document.getElementById(`like-btn-${id}`).classList.add('like-active');
			});
		}
	}

	reformatUserReactions()
	{
		this.userReactions = this.userReactions.map(function(id){return Number(id)});
		this.reformat = true;
	}
}