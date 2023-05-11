import {Type, Tag} from 'main.core';

export class SubscribeList
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
			throw new Error('RecipeList: options.rootNodeId required');
		}

		if (Type.isInteger(options.userId))
		{
			this.userId = options.userId;
		}

		if (Type.isInteger(options.subs2))
		{
			this.subs2 = options.subs2;
		}

		this.rootNode = document.getElementById(this.rootNodeId);
		this.userList = []

		if (!this.rootNode)
		{
			throw new Error(`userList: element with id"${this.rootNodeId}" not found`);
		}

		this.reload();
	}

	reload(step = 1)
	{
		this.loadList(step)
			.then((userList) => {
				if (userList.length !== this.userList.length || userList.length === 0)
				{
					this.userList = userList;
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
			BX.ajax.runAction('up:cake.subs.getList', {
					data: {
						step: step,
						userId: this.userId ?? null,
						subs2: this.subs2 ?? null,
					},
				})
				.then((response) => {
					resolve(response.data.userList);
				})
				.catch((error) => {
					reject(error);
				});
		});
	}

	render()
	{
		this.rootNode.innerHTML = '';
		if (this.userList.length === 0)
		{
			var commentNode = document.createElement('div'); // is a node
			commentNode.innerHTML = `
				<br>
				<h2>Нет пользователей!</h2>
				`;
			this.rootNode.appendChild(commentNode);
			return;
		}
			this.userList.forEach(commentData => {
				if (commentData.PERSONAL_PHOTO === '')
				{
					if (commentData.PERSONAL_GENDER === 'M')
					{
						commentData.PERSONAL_PHOTO = "/local/modules/up.cake/install/templates/cake/images/profileMale.png"
					}
					else
					{
						commentData.PERSONAL_PHOTO = "/local/modules/up.cake/install/templates/cake/images/profileFemale.png"
					}
				}

				const commentNode = Tag.render`<div id="box-subs-list" class="box box-user-search">
				<article class="media">
					<div class="media-left">
						<a href="/users/${commentData.ID}/">
<!--							<figure class="image is-64x64">-->
								<img src="${commentData.PERSONAL_PHOTO}" height="150" width="150" alt="image">
<!--							</figure>-->
						</a>
					</div>
					
					<div class="media-content">
						<div class="content">
							<p>
							<a href="/users/${commentData.ID}/">
								<strong>${commentData.NAME + ' ' + commentData.LAST_NAME + ' (' + commentData.LOGIN + ')'}</strong>
							</a>
							<br> <br>
								${commentData.PERSONAL_NOTES.substring(0,this.LENGTH_COMMENT)}
							</p>
						</div>
					</div>
				</article>
			</div>`;
				this.rootNode.appendChild(commentNode);
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