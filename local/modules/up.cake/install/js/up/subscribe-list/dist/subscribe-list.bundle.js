this.BX = this.BX || {};
this.BX.Up = this.BX.Up || {};
(function (exports,main_core) {
	'use strict';

	var _templateObject;
	var SubscribeList = /*#__PURE__*/function () {
	  function SubscribeList() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    babelHelpers.classCallCheck(this, SubscribeList);
	    babelHelpers.defineProperty(this, "COUNT_COMMENT_IN_ROW", 10);
	    babelHelpers.defineProperty(this, "LENGTH_COMMENT", 1024);
	    babelHelpers.defineProperty(this, "END_PAGE", false);
	    if (main_core.Type.isStringFilled(options.rootNodeId)) {
	      this.rootNodeId = options.rootNodeId;
	    } else {
	      throw new Error('RecipeList: options.rootNodeId required');
	    }
	    if (main_core.Type.isInteger(options.userId)) {
	      this.userId = options.userId;
	    }
	    if (main_core.Type.isInteger(options.subs2)) {
	      this.subs2 = options.subs2;
	    }
	    this.rootNode = document.getElementById(this.rootNodeId);
	    this.userList = [];
	    if (!this.rootNode) {
	      throw new Error("userList: element with id\"".concat(this.rootNodeId, "\" not found"));
	    }
	    this.reload();
	  }
	  babelHelpers.createClass(SubscribeList, [{
	    key: "reload",
	    value: function reload() {
	      var _this = this;
	      var step = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
	      this.loadList(step).then(function (userList) {
	        if (userList.length !== _this.userList.length || userList.length === 0) {
	          _this.userList = userList;
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
	        var _this2$userId, _this2$subs;
	        BX.ajax.runAction('up:cake.subs.getList', {
	          data: {
	            step: step,
	            userId: (_this2$userId = _this2.userId) !== null && _this2$userId !== void 0 ? _this2$userId : null,
	            subs2: (_this2$subs = _this2.subs2) !== null && _this2$subs !== void 0 ? _this2$subs : null
	          }
	        }).then(function (response) {
	          resolve(response.data.userList);
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
	      if (this.userList.length === 0) {
	        var commentNode = document.createElement('div'); // is a node
	        commentNode.innerHTML = "\n\t\t\t\t<br>\n\t\t\t\t<h2>\u041D\u0435\u0442 \u043F\u043E\u043B\u044C\u0437\u043E\u0432\u0430\u0442\u0435\u043B\u0435\u0439!</h2>\n\t\t\t\t";
	        this.rootNode.appendChild(commentNode);
	        return;
	      }
	      this.userList.forEach(function (commentData) {
	        if (commentData.PERSONAL_PHOTO === '') {
	          if (commentData.PERSONAL_GENDER === 'M') {
	            commentData.PERSONAL_PHOTO = "/local/modules/up.cake/install/templates/cake/images/profileMale.png";
	          } else {
	            commentData.PERSONAL_PHOTO = "/local/modules/up.cake/install/templates/cake/images/profileFemale.png";
	          }
	        }
	        var commentNode = main_core.Tag.render(_templateObject || (_templateObject = babelHelpers.taggedTemplateLiteral(["<div id=\"box-subs-list\" class=\"box box-user-search\">\n\t\t\t\t<article class=\"media\">\n\t\t\t\t\t<div class=\"media-left\">\n\t\t\t\t\t\t<a href=\"/users/", "/\">\n<!--\t\t\t\t\t\t\t<figure class=\"image is-64x64\">-->\n\t\t\t\t\t\t\t\t<img src=\"", "\" height=\"150\" width=\"150\" alt=\"image\">\n<!--\t\t\t\t\t\t\t</figure>-->\n\t\t\t\t\t\t</a>\n\t\t\t\t\t</div>\n\t\t\t\t\t\n\t\t\t\t\t<div class=\"media-content\">\n\t\t\t\t\t\t<div class=\"content\">\n\t\t\t\t\t\t\t<p>\n\t\t\t\t\t\t\t<a href=\"/users/", "/\">\n\t\t\t\t\t\t\t\t<strong>", "</strong>\n\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t<br> <br>\n\t\t\t\t\t\t\t\t", "\n\t\t\t\t\t\t\t</p>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t</article>\n\t\t\t</div>"])), commentData.ID, commentData.PERSONAL_PHOTO, commentData.ID, commentData.NAME + ' ' + commentData.LAST_NAME + ' (' + commentData.LOGIN + ')', commentData.PERSONAL_NOTES.substring(0, _this3.LENGTH_COMMENT));
	        _this3.rootNode.appendChild(commentNode);
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
	  return SubscribeList;
	}();

	exports.SubscribeList = SubscribeList;

}((this.BX.Up.Cake = this.BX.Up.Cake || {}),BX));
