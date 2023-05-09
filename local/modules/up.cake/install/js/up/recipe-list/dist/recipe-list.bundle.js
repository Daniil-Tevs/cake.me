this.BX = this.BX || {};
this.BX.Up = this.BX.Up || {};
(function (exports,main_core) {
	'use strict';

	var _templateObject, _templateObject2;
	var RecipeCard = /*#__PURE__*/function () {
	  function RecipeCard(recipeData, image, type) {
	    babelHelpers.classCallCheck(this, RecipeCard);
	    babelHelpers.defineProperty(this, "LENGTH_DESCRIPTION", 110);
	    this.recipeId = Number(recipeData.ID);
	    if (type === 'profile') {
	      this.cardNode = this.profileCard(recipeData, image);
	    } else {
	      this.cardNode = this.simpleCard(recipeData, image);
	    }
	  }
	  babelHelpers.createClass(RecipeCard, [{
	    key: "getDescription",
	    value: function getDescription() {
	      var description = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
	      if (description.length <= this.LENGTH_DESCRIPTION) {
	        return description;
	      } else {
	        return description.substring(0, this.LENGTH_DESCRIPTION) + '...';
	      }
	    }
	  }, {
	    key: "simpleCard",
	    value: function simpleCard(recipeData, image) {
	      return main_core.Tag.render(_templateObject || (_templateObject = babelHelpers.taggedTemplateLiteral(["\n\t\t\t\t<div class=\"card card-list\" id=\"", "\">\n\t\t\t\t\t\t<div class=\"card-image\">\n\t\t\t\t\t\t\t<figure class=\"image\">\n\t\t\t\t\t\t\t\t<img src='", "'>\n\t\t\t\t\t\t\t</figure>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"card-content\">\n\t\t\t\t\t\t\t<div class=\"content\">\n\t\t\t\t\t\t\t\t<div class=\"content-header\">\n\t\t\t\t\t\t\t\t\t<a class=\"title mb-2\" href=\"/detail/", "/\">", " </a>\n\t\t\t\t\t\t\t\t\t<button class=\"like ", "\" id=\"like-btn-", "\" value=\"", "\" onclick=\"window.CakeRecipeList.reaction.changeLike(this.value)\"></button>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t<hr>\n\t\t\t\t\t\t\t\t<p>", "</p>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<footer class=\"card-footer\">\n\t\t\t\t\t\t\t<div class=\"card-footer-item\">\uD83D\uDD54 ", " min</div>\n\t\t\t\t\t\t\t<div class=\"card-footer-item\">\uD83D\uDD25 ", " calories</div>\n\t\t\t\t\t\t\t<div class=\"card-footer-item \"><a href=\"/users/", "/\">\uD83D\uDC68\u200D\uD83C\uDF73", "</a></div>\n\t\t\t\t\t\t</footer>\n\t\t\t\t\t</div>"])), recipeData.ID, image !== null && image !== void 0 ? image : '', recipeData.ID, recipeData.NAME, recipeData.USER_REACTION ? 'like-active' : '', recipeData.ID, recipeData.ID, this.getDescription(recipeData.DESCRIPTION), recipeData.TIME, recipeData.CALORIES, recipeData.UP_CAKE_MODEL_RECIPE_USER_ID, recipeData.UP_CAKE_MODEL_RECIPE_USER_NAME + ' ' + recipeData.UP_CAKE_MODEL_RECIPE_USER_LAST_NAME);
	    }
	  }, {
	    key: "profileCard",
	    value: function profileCard(recipeData, image) {
	      return main_core.Tag.render(_templateObject2 || (_templateObject2 = babelHelpers.taggedTemplateLiteral(["\n\t\t\t\t<div class=\"column mt-5\">\n\t\t\t\t\t<div class=\"card card-list\" id=\"", "\">\n\t\t\t\t\t\t<div class=\"card-image\">\n\t\t\t\t\t\t\t<figure class=\"image\">\n\t\t\t\t\t\t\t\t<img src='", "'>\n\t\t\t\t\t\t\t</figure>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"card-content\">\n\t\t\t\t\t\t\t<div class=\"content\">\n\t\t\t\t\t\t\t\t<a class=\"title mb-2\" href=\"/detail/", "/\">", " </a>\n\t\t\t\t\t\t\t\t<hr>\n\t\t\t\t\t\t\t\t<p>", "</p>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<footer class=\"card-footer\">\n\t\t\t\t\t\t\t<div class=\"card-footer-item\">\u2764 Likes: ", "</div> \t\n\t\t\t\t\t\t\t<a href=\"/recipe/edit/", "/\" class=\"card-footer-item button profile-button-edit\">Edit</a>\n    \t\t\t\t\t\t<button class=\"card-footer-item button profile-button-delete\" value=\"", "\" onclick=\" window.step = 1 ; window.CakeRecipeList.deleteRecipe(this.value);\">Delete</button>\n\t\t\t\t\t\t</footer>\n\t\t\t\t\t</div>\n\t\t\t\t</div>"])), recipeData.ID, image !== null && image !== void 0 ? image : '', recipeData.ID, recipeData.NAME, this.getDescription(recipeData.DESCRIPTION), recipeData.REACTION, recipeData.ID, recipeData.ID);
	    }
	  }]);
	  return RecipeCard;
	}();

	var Reaction = /*#__PURE__*/function () {
	  function Reaction() {
	    var userId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
	    babelHelpers.classCallCheck(this, Reaction);
	    babelHelpers.defineProperty(this, "userId", []);
	    babelHelpers.defineProperty(this, "userReactions", []);
	    babelHelpers.defineProperty(this, "reformat", false);
	    if (!main_core.Type.isInteger(userId)) {
	      throw new Error('Reaction: userId required');
	    }
	    this.userId = userId;
	    this.getUserLikes();
	  }
	  babelHelpers.createClass(Reaction, [{
	    key: "getUserLikes",
	    value: function getUserLikes() {
	      var _this = this;
	      BX.ajax.runAction('up:cake.reaction.getLikesOfUser', {
	        data: {
	          userId: this.userId
	        }
	      }).then(function (response) {
	        _this.userReactions = response.data;
	      })["catch"](function (error) {
	        console.log(error);
	      });
	    }
	  }, {
	    key: "changeLike",
	    value: function changeLike(recipeId) {
	      if (!this.reformat) this.reformatUserReactions();
	      recipeId = Number(recipeId);
	      if (!main_core.Type.isInteger(recipeId)) {
	        throw new Error('Reaction: id should be int');
	      }
	      this.userReactions.indexOf(recipeId) === -1 ? this.addLike(recipeId) : this.removeLike(recipeId);
	    }
	  }, {
	    key: "addLike",
	    value: function addLike(recipeId) {
	      var _this2 = this;
	      console.log(this.userReactions);
	      if (!main_core.Type.isInteger(recipeId)) {
	        throw new Error('Reaction: id should be int');
	      }
	      BX.ajax.runAction('up:cake.reaction.addLike', {
	        data: {
	          userId: this.userId,
	          recipeId: recipeId
	        }
	      }).then(function () {
	        _this2.userReactions.push(Number(recipeId));
	        document.getElementById("like-btn-".concat(recipeId)).classList.add('like-active');
	      })["catch"](function (error) {
	        console.log(error);
	      });
	    }
	  }, {
	    key: "removeLike",
	    value: function removeLike(recipeId) {
	      var _this3 = this;
	      console.log(this.userReactions);
	      if (!main_core.Type.isInteger(recipeId)) {
	        throw new Error('Reaction: id should be int');
	      }
	      BX.ajax.runAction('up:cake.reaction.removeLike', {
	        data: {
	          userId: this.userId,
	          recipeId: recipeId
	        }
	      }).then(function () {
	        _this3.userReactions.splice(_this3.userReactions.indexOf(Number(recipeId)), 1);
	        document.getElementById("like-btn-".concat(recipeId)).classList.remove('like-active');
	      })["catch"](function (error) {
	        console.log(error);
	      });
	      console.log(this.userReactions);
	    }
	  }, {
	    key: "reload",
	    value: function reload() {
	      if (this.userReactions) {
	        this.userReactions.forEach(function (id) {
	          document.getElementById("like-btn-".concat(id)).classList.add('like-active');
	        });
	      }
	    }
	  }, {
	    key: "reformatUserReactions",
	    value: function reformatUserReactions() {
	      this.userReactions = this.userReactions.map(function (id) {
	        return Number(id);
	      });
	      this.reformat = true;
	    }
	  }]);
	  return Reaction;
	}();

	var _templateObject$1, _templateObject2$1;
	var RecipeMessage = /*#__PURE__*/function () {
	  function RecipeMessage(type) {
	    babelHelpers.classCallCheck(this, RecipeMessage);
	    if (type === 'profile') {
	      this.messageNode = this.profileMessage();
	    } else {
	      this.messageNode = this.simpleMessage();
	    }
	  }
	  babelHelpers.createClass(RecipeMessage, [{
	    key: "simpleMessage",
	    value: function simpleMessage() {
	      return main_core.Tag.render(_templateObject$1 || (_templateObject$1 = babelHelpers.taggedTemplateLiteral(["<div class=\"not-found-block\">\n<figure class=\"image not-found\">\n<img src=\"/local/modules/up.cake/install/templates/cake/images/NotFound.png\">\n<figcaption>\u041D\u0438\u0447\u0435\u0433\u043E \u043D\u0435 \u043D\u0430\u0439\u0434\u0435\u043D\u043E</figcaption>\n</div>\n\n</figure>"])));
	    }
	  }, {
	    key: "profileMessage",
	    value: function profileMessage() {
	      document.getElementsByClassName('your-recipe').item(0).innerHTML = "<p>\u0423 \u0432\u0430\u0441 \u043F\u043E\u043A\u0430 \u043D\u0435\u0442 \u0440\u0435\u0446\u0435\u043F\u0442\u043E\u0432</p>";
	      return main_core.Tag.render(_templateObject2$1 || (_templateObject2$1 = babelHelpers.taggedTemplateLiteral([""])));
	    }
	  }]);
	  return RecipeMessage;
	}();

	var RecipeList = /*#__PURE__*/function () {
	  function RecipeList() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    babelHelpers.classCallCheck(this, RecipeList);
	    babelHelpers.defineProperty(this, "title", '');
	    babelHelpers.defineProperty(this, "filters", []);
	    babelHelpers.defineProperty(this, "recipeList", []);
	    babelHelpers.defineProperty(this, "imageList", []);
	    babelHelpers.defineProperty(this, "type", null);
	    babelHelpers.defineProperty(this, "userId", null);
	    babelHelpers.defineProperty(this, "anotherUserId", null);
	    babelHelpers.defineProperty(this, "reaction", null);
	    babelHelpers.defineProperty(this, "END_PAGE", false);
	    babelHelpers.defineProperty(this, "MAX_COLOR", 3);
	    if (main_core.Type.isStringFilled(options.rootNodeId)) {
	      this.rootNodeId = options.rootNodeId;
	    } else {
	      throw new Error('RecipeList: options.rootNodeId required');
	    }
	    if (main_core.Type.isInteger(options.userId)) {
	      this.userId = options.userId;
	    }
	    if (main_core.Type.isInteger(options.anotherUserId)) {
	      this.anotherUserId = options.anotherUserId;
	    }
	    if (main_core.Type.isString(options.type)) {
	      this.type = options.type;
	    } else {
	      this.type = this.userId === null || this.userId <= 0 ? 'unregister' : null;
	    }
	    this.filters['tags'] = [];
	    this.title = window.location.search.replace('?', '').split('&').reduce(function (p, e) {
	      var a = e.split('=');
	      p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
	      return p;
	    }, {})['search-string'];
	    this.rootNode = document.getElementById(this.rootNodeId);
	    if (!this.rootNode) {
	      throw new Error("RecipeList: element with id\"".concat(this.rootNodeId, "\" not found"));
	    }
	    this.reload();
	    this.reaction = new Reaction(this.userId);
	  }
	  babelHelpers.createClass(RecipeList, [{
	    key: "reload",
	    value: function reload() {
	      var _this = this;
	      var step = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
	      this.loadList(step).then(function (data) {
	        if (data[0].length !== _this.recipeList.length || data[0].length === 0) {
	          _this.recipeList = data[0];
	          _this.imageList = data[1];
	          _this.userReactions = data[2];
	          _this.render();
	        } else {
	          _this.END_PAGE = true;
	        }
	      });
	    }
	  }, {
	    key: "loadList",
	    value: function loadList() {
	      var _this2 = this;
	      var step = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
	      return new Promise(function (resolve, reject) {
	        var _this2$title;
	        BX.ajax.runAction('up:cake.recipe.getList', {
	          data: {
	            step: step,
	            type: _this2.type,
	            userId: _this2.userId,
	            anotherUserId: _this2.anotherUserId,
	            title: (_this2$title = _this2.title) !== null && _this2$title !== void 0 ? _this2$title : null,
	            filters: _this2.filters['tags']
	          }
	        }).then(function (response) {
	          var request = [response.data.recipeList, response.data.imageList, response.data.userReactions];
	          resolve(request);
	        })["catch"](function (error) {
	          reject(error);
	        });
	      });
	    }
	  }, {
	    key: "render",
	    value: function render() {
	      var _this3 = this;
	      this.rootNode.innerHTML = '';
	      this.recipeList.forEach(function (recipeData) {
	        recipeData['USER_REACTION'] = _this3.userReactions.indexOf(Number(recipeData.ID)) !== -1;
	        var recipeNode = new RecipeCard(recipeData, _this3.imageList[recipeData.ID], _this3.type, _this3.userId).cardNode;
	        _this3.rootNode.appendChild(recipeNode);
	      });
	      if (this.recipeList.length === 0) {
	        this.END_PAGE = true;
	        this.rootNode.appendChild(new RecipeMessage(this.type).messageNode);
	      }
	      if (this.userId === null || this.userId <= 0) {
	        var likes = this.rootNode.getElementsByClassName('like');
	        while (likes.length) {
	          likes[0].parentNode.removeChild(likes[0]);
	        }
	        var cardHeader = this.rootNode.getElementsByClassName('content-header');
	        for (var i = 0; i < cardHeader.length; i++) {
	          cardHeader[i].style.justifyContent = 'flex-start';
	        }
	      }
	      var cardContainers = this.rootNode.getElementsByClassName('card-content');
	      for (var _i = 0; _i < cardContainers.length; _i++) {
	        cardContainers[_i].classList.add("color-".concat(1 + _i % this.MAX_COLOR));
	      }
	    }
	  }, {
	    key: "changeFilters",
	    value: function changeFilters(type) {
	      var id = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
	      id = Number(id);
	      if (!main_core.Type.isInteger(id)) {
	        throw new Error('RecipeList: id checkbox should be integer');
	      }
	      if (!main_core.Type.isStringFilled(type)) {
	        throw new Error('RecipeList: type should be string');
	      }
	      if (id !== 0) {
	        if (this.filters['tags'].indexOf(this.filters[type]) >= 0) {
	          this.filters['tags'].splice(this.filters['tags'].indexOf(this.filters[type]), 1);
	        }
	        this.filters['tags'].push(id);
	        this.filters[type] = id;
	      } else {
	        this.filters['tags'].splice(this.filters['tags'].indexOf(this.filters[type]), 1);
	        delete this.filters[type];
	      }
	      this.END_PAGE = false;
	      this.recipeList = [];
	      this.reload(1);
	    }
	  }, {
	    key: "changeTitle",
	    value: function changeTitle(title) {
	      if (!main_core.Type.isStringFilled(title) && title.trim() !== '') {
	        throw new Error('RecipeList: title should be string');
	      }
	      this.title = title.trim();
	      this.END_PAGE = false;
	      this.recipeList = [];
	      this.reload(1);
	    }
	  }, {
	    key: "deleteRecipe",
	    value: function deleteRecipe(id) {
	      var _this4 = this;
	      id = Number(id);
	      if (!main_core.Type.isInteger(id)) {
	        throw new Error('RecipeCard: id should be int');
	      }
	      BX.ajax.runAction('up:cake.recipe.deleteRecipe', {
	        data: {
	          id: id,
	          userId: this.userId
	        }
	      }).then(function (response) {
	        _this4.END_PAGE = false;
	        _this4.recipeList = [];
	        _this4.reload(1);
	      });
	    }
	  }, {
	    key: "setName",
	    value: function setName(name) {
	      if (main_core.Type.isString(name)) {
	        this.name = name;
	      }
	    }
	  }, {
	    key: "getName",
	    value: function getName() {
	      return this.name;
	    }
	  }]);
	  return RecipeList;
	}();

	exports.RecipeList = RecipeList;

}((this.BX.Up.Cake = this.BX.Up.Cake || {}),BX));
