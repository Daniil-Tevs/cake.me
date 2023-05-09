this.BX = this.BX || {};
this.BX.Up = this.BX.Up || {};
(function (exports,main_core) {
	'use strict';

	var _templateObject;
	var RecipeComments = /*#__PURE__*/function () {
	  function RecipeComments() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    babelHelpers.classCallCheck(this, RecipeComments);
	    babelHelpers.defineProperty(this, "COUNT_COMMENT_IN_ROW", 10);
	    babelHelpers.defineProperty(this, "LENGTH_COMMENT", 1024);
	    babelHelpers.defineProperty(this, "END_PAGE", false);
	    if (main_core.Type.isStringFilled(options.rootNodeId)) {
	      this.rootNodeId = options.rootNodeId;
	    } else {
	      throw new Error('CommentList: options.rootNodeId required');
	    }
	    if (main_core.Type.isInteger(options.recipeId)) {
	      this.recipeId = options.recipeId;
	    }
	    this.rootNode = document.getElementById(this.rootNodeId);
	    this.commentList = [];
	    if (!this.rootNode) {
	      throw new Error("CommentList: element with id\"".concat(this.rootNodeId, "\" not found"));
	    }
	    this.reload();
	  }
	  babelHelpers.createClass(RecipeComments, [{
	    key: "reload",
	    value: function reload() {
	      var _this = this;
	      var step = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
	      this.loadList(step).then(function (commentList) {
	        if (commentList.length !== _this.commentList.length || commentList.length === 0) {
	          _this.commentList = commentList;
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
	        var _this2$recipeId;
	        BX.ajax.runAction('up:cake.comment.getList', {
	          data: {
	            step: step,
	            recipeId: (_this2$recipeId = _this2.recipeId) !== null && _this2$recipeId !== void 0 ? _this2$recipeId : null
	          }
	        }).then(function (response) {
	          resolve(response.data.commentList);
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
	      console.log(this.commentList);
	      this.commentList.forEach(function (commentData) {
	        console.log(commentData);
	        var commentNode = main_core.Tag.render(_templateObject || (_templateObject = babelHelpers.taggedTemplateLiteral(["<div class=\"card\"><div class=\"card-content comment-card pl-2 \">\n\t\t\t\t\t<div class=\"media\">\n\t\t\t\t\t\t<div class=\"media-left mr-2\">\n\t\t\t\t\t\t\t<figure class=\"image is-32x32\">\n\t\t\t\t\t\t\t\t<img class=\"is-rounded\" src=\"", "\" alt=\"\">\n\t\t\t\t\t\t\t</figure>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"media-content\">\n\t\t\t\t\t\t\t<a href=\"/users/", "/\" class=\"title is-6\">", ":</a>\n\t\t\t\t\t\t\t\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t\n\t\t\t\t\t<div class=\"container comment-title ml-3\">\n\t\t\t\t\t\t<p>", "</p>\n\t\t\t\t\t</div></div>"])), commentData.UP_CAKE_MODEL_COMMENT_USER_PERSONAL_PHOTO !== '' ? commentData.UP_CAKE_MODEL_COMMENT_USER_PERSONAL_PHOTO : commentData.UP_CAKE_MODEL_COMMENT_USER_PERSONAL_GENDER === 'M' ? '/local/modules/up.cake/install/templates/cake/images/profileMale.png' : '/local/modules/up.cake/install/templates/cake/images/profileFemale.png', commentData.UP_CAKE_MODEL_COMMENT_USER_ID, commentData.UP_CAKE_MODEL_COMMENT_USER_NAME + ' ' + commentData.UP_CAKE_MODEL_COMMENT_USER_LAST_NAME, commentData.TITLE.substring(0, _this3.LENGTH_COMMENT));
	        _this3.rootNode.appendChild(commentNode);
	      });
	    }
	  }, {
	    key: "addComment",
	    value: function addComment(title) {
	      var _this4 = this;
	      if (!main_core.Type.isStringFilled(title)) {
	        throw new Error('RecipeComment: title should be string or required');
	      }
	      BX.ajax.runAction('up:cake.comment.addComment', {
	        data: {
	          recipeId: this.recipeId,
	          title: title
	        }
	      }).then(function (response) {
	        _this4.END_PAGE = false;
	        _this4.commentList = [];
	        _this4.reload(1);
	      })["catch"](function (error) {
	        console.log(error);
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
	  return RecipeComments;
	}();

	exports.RecipeComments = RecipeComments;

}((this.BX.Up.Cake = this.BX.Up.Cake || {}),BX));
