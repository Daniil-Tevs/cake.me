this.BX = this.BX || {};
this.BX.Up = this.BX.Up || {};
(function (exports,main_core) {
	'use strict';

	var _templateObject, _templateObject2, _templateObject3;
	var RecipeList = /*#__PURE__*/function () {
	  function RecipeList() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    babelHelpers.classCallCheck(this, RecipeList);
	    babelHelpers.defineProperty(this, "COUNT_RECIPE_IN_ROW", 3);
	    babelHelpers.defineProperty(this, "LENGTH_DESCRIPTION", 200);
	    babelHelpers.defineProperty(this, "END_PAGE", false);
	    if (main_core.Type.isStringFilled(options.rootNodeId)) {
	      this.rootNodeId = options.rootNodeId;
	    } else {
	      throw new Error('RecipeList: options.rootNodeId required');
	    }
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
	        if (data[0].length !== _this.recipeList.length) {
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
	      var step = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
	      return new Promise(function (resolve, reject) {
	        BX.ajax.runAction('up:cake.recipe.getList', {
	          data: {
	            step: step
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
	      var _this2 = this;
	      this.rootNode.innerHTML = '';
	      var index = 1;
	      var recipeContainerNode = main_core.Tag.render(_templateObject || (_templateObject = babelHelpers.taggedTemplateLiteral(["<div class=\"columns\"></div>"])));
	      this.recipeList.forEach(function (recipeData) {
	        var _this2$imageList;
	        var recipeNode = main_core.Tag.render(_templateObject2 || (_templateObject2 = babelHelpers.taggedTemplateLiteral(["\n\t\t\t\t<div class=\"column mt-5\">\n\t\t\t\t\t<div class=\"card card-list\">\n\t\t\t\t\t\t<div class=\"card-image\">\n\t\t\t\t\t\t\t<figure class=\"image\">\n\t\t\t\t\t\t\t\t<img src='", "' alt=\"Placeholder image\">\n\t\t\t\t\t\t\t</figure>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"card-content\">\n\t\t\t\t\t\t\t<div class=\"content\">\n\t\t\t\t\t\t\t\t<a class=\"title mb-2\" href=\"/detail/", "/\">", " </a>\n\t\t\t\t\t\t\t\t<hr>\n\t\t\t\t\t\t\t\t<p>", "...</p>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<footer class=\"card-footer\">\n\t\t\t\t\t\t\t<div class=\"card-footer-item\">\uD83D\uDD54 ", " min</div>\n\t\t\t\t\t\t\t<div class=\"card-footer-item\">\uD83D\uDD25 ", " calories</div>\n\t\t\t\t\t\t\t<div class=\"card-footer-item \"><a href=\"/users/<?=htmlspecialcharsbx($recipe->getUser()->getID())?>\">\uD83D\uDC68\u200D\uD83C\uDF73", "</a></div>\n\t\t\t\t\t\t</footer>\n\t\t\t\t\t</div>\n\t\t\t\t</div>"])), (_this2$imageList = _this2.imageList["up.cake_".concat(recipeData.ID, "_1")]) !== null && _this2$imageList !== void 0 ? _this2$imageList : "", recipeData.ID, recipeData.NAME, recipeData.DESCRIPTION.substring(0, _this2.LENGTH_DESCRIPTION), recipeData.TIME, recipeData.CALORIES, recipeData.UP_CAKE_MODEL_RECIPE_USER_NAME + ' ' + recipeData.UP_CAKE_MODEL_RECIPE_USER_LAST_NAME);
	        recipeContainerNode.appendChild(recipeNode);
	        if (index % _this2.COUNT_RECIPE_IN_ROW === 0) {
	          _this2.rootNode.appendChild(recipeContainerNode);
	          recipeContainerNode = main_core.Tag.render(_templateObject3 || (_templateObject3 = babelHelpers.taggedTemplateLiteral(["<div class=\"columns\"></div>"])));
	        }
	        index++;
	      });
	      this.rootNode.appendChild(recipeContainerNode);
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
