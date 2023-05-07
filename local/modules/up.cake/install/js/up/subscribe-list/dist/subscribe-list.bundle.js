this.BX = this.BX || {};
this.BX.Up = this.BX.Up || {};
(function (exports,main_core) {
	'use strict';

	var SubscribeList = /*#__PURE__*/function () {
	  function SubscribeList() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
	      name: 'SubscribeList'
	    };
	    babelHelpers.classCallCheck(this, SubscribeList);
	    this.name = options.name;
	  }
	  babelHelpers.createClass(SubscribeList, [{
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
