this.BX = this.BX || {};
this.BX.Up = this.BX.Up || {};
(function (exports,main_core) {
	'use strict';

	var _templateObject, _templateObject2;
	var RecipeCard = /*#__PURE__*/function () {
	  function RecipeCard(recipeData, image, type) {
	    babelHelpers.classCallCheck(this, RecipeCard);
	    if (type === 'profile') {
	      this.cardNode = this.profileCard(recipeData, image);
	    } else {
	      this.cardNode = this.simpleCard(recipeData, image);
	    }
	  }
	  babelHelpers.createClass(RecipeCard, [{
	    key: "simpleCard",
	    value: function simpleCard(recipeData, image) {
	      return main_core.Tag.render(_templateObject || (_templateObject = babelHelpers.taggedTemplateLiteral(["\n\t\t\t\t<div class=\"column mt-5\">\n\t\t\t\t\t<div class=\"card card-list\" id=\"", "\">\n\t\t\t\t\t\t<div class=\"card-image\">\n\t\t\t\t\t\t\t<figure class=\"image\">\n\t\t\t\t\t\t\t\t<img src='", "' alt=\"Placeholder image\">\n\t\t\t\t\t\t\t</figure>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"card-content\">\n\t\t\t\t\t\t\t<div class=\"content\">\n\t\t\t\t\t\t\t\t<a class=\"title mb-2\" href=\"/detail/", "/\">", " </a>\n\t\t\t\t\t\t\t\t<hr>\n\t\t\t\t\t\t\t\t<p>", "...</p>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<footer class=\"card-footer\">\n\t\t\t\t\t\t\t<div class=\"card-footer-item\">\uD83D\uDD54 ", " min</div>\n\t\t\t\t\t\t\t<div class=\"card-footer-item\">\uD83D\uDD25 ", " calories</div>\n\t\t\t\t\t\t\t<div class=\"card-footer-item \"><a href=\"/users/<?=htmlspecialcharsbx($recipe->getUser()->getID())?>\">\uD83D\uDC68\u200D\uD83C\uDF73", "</a></div>\n\t\t\t\t\t\t</footer>\n\t\t\t\t\t</div>\n\t\t\t\t</div>"])), recipeData.ID, image !== null && image !== void 0 ? image : "", recipeData.ID, recipeData.NAME, recipeData.DESCRIPTION.substring(0, this.LENGTH_DESCRIPTION), recipeData.TIME, recipeData.CALORIES, recipeData.UP_CAKE_MODEL_RECIPE_USER_NAME + ' ' + recipeData.UP_CAKE_MODEL_RECIPE_USER_LAST_NAME);
	    }
	  }, {
	    key: "profileCard",
	    value: function profileCard(recipeData, image) {
	      console.log(recipeData);
	      return main_core.Tag.render(_templateObject2 || (_templateObject2 = babelHelpers.taggedTemplateLiteral(["\n\t\t\t\t<div class=\"column mt-5\">\n\t\t\t\t\t<div class=\"card card-list\" id=\"", "\">\n\t\t\t\t\t\t<div class=\"card-image\">\n\t\t\t\t\t\t\t<figure class=\"image\">\n\t\t\t\t\t\t\t\t<img src='", "' alt=\"Placeholder image\">\n\t\t\t\t\t\t\t</figure>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"card-content\">\n\t\t\t\t\t\t\t<div class=\"content\">\n\t\t\t\t\t\t\t\t<a class=\"title mb-2\" href=\"/detail/", "/\">", " </a>\n\t\t\t\t\t\t\t\t<hr>\n\t\t\t\t\t\t\t\t<p>", "...</p>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<footer class=\"card-footer\">\n\t\t\t\t\t\t\t<div class=\"card-footer-item\">Likes: ", "</div> \t\n\t\t\t\t\t\t\t<a href=\"/recipe/edit/", "/\" class=\"card-footer-item button profile-button-edit\">Edit</a>\n    \t\t\t\t\t\t<button class=\"card-footer-item button profile-button-delete\">Delete</button>\n\t\t\t\t\t\t</footer>\n\t\t\t\t\t</div>\n\t\t\t\t</div>"])), recipeData.ID, image !== null && image !== void 0 ? image : "", recipeData.ID, recipeData.NAME, recipeData.DESCRIPTION.substring(0, this.LENGTH_DESCRIPTION), recipeData.REACTION, recipeData.ID);
	    }
	  }]);
	  return RecipeCard;
	}();

	var _templateObject$1, _templateObject2$1;
	var RecipeList = /*#__PURE__*/function () {
	  function RecipeList() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    babelHelpers.classCallCheck(this, RecipeList);
	    babelHelpers.defineProperty(this, "COUNT_RECIPE_IN_ROW", 3);
	    babelHelpers.defineProperty(this, "LENGTH_DESCRIPTION", 200);
	    babelHelpers.defineProperty(this, "END_PAGE", false);
	    babelHelpers.defineProperty(this, "title", '');
	    babelHelpers.defineProperty(this, "filters", []);
	    if (main_core.Type.isStringFilled(options.rootNodeId)) {
	      this.rootNodeId = options.rootNodeId;
	    } else {
	      throw new Error('RecipeList: options.rootNodeId required');
	    }
	    if (main_core.Type.isInteger(options.userId)) {
	      this.userId = options.userId;
	    }
	    this.type = options.type;
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
	    this.recipeList = [];
	    this.imageList = [];
	    this.reload();
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
	      console.log(this.filters['tags']);
	      return new Promise(function (resolve, reject) {
	        var _this2$userId, _this2$title;
	        BX.ajax.runAction('up:cake.recipe.getList', {
	          data: {
	            step: step,
	            userId: (_this2$userId = _this2.userId) !== null && _this2$userId !== void 0 ? _this2$userId : null,
	            title: (_this2$title = _this2.title) !== null && _this2$title !== void 0 ? _this2$title : null,
	            filters: _this2.filters['tags']
	          }
	        }).then(function (response) {
	          var request = [response.data.recipeList, response.data.imageList];
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
	      var index = 1;
	      var recipeContainerNode = main_core.Tag.render(_templateObject$1 || (_templateObject$1 = babelHelpers.taggedTemplateLiteral(["<div class=\"columns card-lists\"></div>"])));
	      this.recipeList.forEach(function (recipeData) {
	        var recipeNode = new RecipeCard(recipeData, _this3.imageList[recipeData.ID], _this3.type).cardNode;
	        recipeContainerNode.appendChild(recipeNode);
	        if (index % _this3.COUNT_RECIPE_IN_ROW === 0) {
	          _this3.rootNode.appendChild(recipeContainerNode);
	          recipeContainerNode = main_core.Tag.render(_templateObject2$1 || (_templateObject2$1 = babelHelpers.taggedTemplateLiteral(["<div class=\"columns card-lists\"></div>"])));
	        }
	        index++;
	      });
	      this.rootNode.appendChild(recipeContainerNode);
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
	        console.log(id, type, this.filters[type]);
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
	      console.log(title);
	      if (!main_core.Type.isStringFilled(title) && title.trim() !== '') {
	        throw new Error('RecipeList: title should be string');
	      }
	      this.title = title.trim();
	      this.END_PAGE = false;
	      this.recipeList = [];
	      this.reload(1);
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
