/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./resources/assets/tostem/front/cart/cart.js":
/*!****************************************************!*\
  !*** ./resources/assets/tostem/front/cart/cart.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

(function ($) {
  var timer;

  if (typeof cart_vue == "undefined") {
    Vue.config.devtools = true;
    var cart_vue = new Vue({
      el: '#cart-vue',
      data: {
        details: {
          sub_total: 0,
          total: 0,
          total_quantity: 0
        },
        itemCount: 0,
        items: [],
        item: {},
        product_: 'product_',
        id_product: null,
        itemObjKey: null,
        message: null,
        quotation_no: '',
        validate_mail: null,
        button_click: null,
        user_name: '',
        //Add BP_O2OQ-4 hainp 20200605
        max_decimal: 0,
        //Add BP_O2OQ-7 hainp 20200710
        disable_button: false,
        //Add BP_O2OQ-25 hainp 20210625
        length_reference_no: 8 //Add BP_O2OQ-25 hainp 20210625

      },
      mounted: function mounted() {
        this.loadItems();
      },
      methods: {
        /**
        * Redirect if token expired
        */
        tokenMismatch: function tokenMismatch() {
          _loading.css('display', 'none');

          this.$modal.show('dialog', {
            text: lang_text.session_expired,
            buttons: [{
              title: lang_text.ok,
              "default": true,
              // Will be triggered by default if 'Enter' pressed.
              handler: function handler() {
                window.location.href = _urlBaseLang;
              }
            }]
          });
        },
        addItem: function addItem() {
          var _this2 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
            var _this, response;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
              while (1) {
                switch (_context.prev = _context.next) {
                  case 0:
                    _this = _this2;
                    _context.prev = 1;
                    _context.next = 4;
                    return axios.post(_urlBaseLang + '/cart', {
                      id: _this.item.id,
                      name: _this.item.name,
                      price: _this.item.price,
                      qty: _this.item.qty
                    })["catch"](function (error) {
                      if (error.response.status == 401) {
                        _this2.tokenMismatch();
                      }
                    });

                  case 4:
                    response = _context.sent;
                    _context.next = 7;
                    return _this.loadItems();

                  case 7:
                    _context.next = 12;
                    break;

                  case 9:
                    _context.prev = 9;
                    _context.t0 = _context["catch"](1);
                    console.log(Object.keys(_context.t0), _context.t0.message);

                  case 12:
                  case "end":
                    return _context.stop();
                }
              }
            }, _callee, null, [[1, 9]]);
          }))();
        },
        uploadQuantityItem: function uploadQuantityItem(id, itemObjKey) {
          var _this3 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
            var _this, select, quantity;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
              while (1) {
                switch (_context2.prev = _context2.next) {
                  case 0:
                    _this = _this3;
                    select = $('#' + _this.product_ + id + " [name=quantity]");
                    quantity = select.val();
                    _context2.prev = 3;
                    _context2.next = 6;
                    return axios.post(_urlBaseLang + '/cart/update_quantity', {
                      id: id,
                      quantity: quantity
                    })["catch"](function (error) {
                      if (error.response.status == 401) {
                        _this3.tokenMismatch();
                      }
                    });

                  case 6:
                    select.children("option").attr('selected', false);
                    _this.items[itemObjKey].quantity = quantity;
                    select.children("option:selected").attr('selected', 'selected');
                    _context2.next = 11;
                    return _this.loadCartDetails();

                  case 11:
                    _context2.next = 16;
                    break;

                  case 13:
                    _context2.prev = 13;
                    _context2.t0 = _context2["catch"](3);
                    console.log(Object.keys(_context2.t0), _context2.t0.message);

                  case 16:
                  case "end":
                    return _context2.stop();
                }
              }
            }, _callee2, null, [[3, 13]]);
          }))();
        },
        // Edit Start BP_O2OQ-25 hainp 20210621
        uploadRefenceNo: function uploadRefenceNo(el_target, id, itemObjKey) {
          var _this4 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
            var _this, input, reference_no, regex;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
              while (1) {
                switch (_context5.prev = _context5.next) {
                  case 0:
                    _this = _this4, input = $(el_target.target), reference_no = input.val(), regex = /[,'"]/g; // nếu max lenght > default thì return

                    if (!(reference_no.length > _this.length_reference_no)) {
                      _context5.next = 5;
                      break;
                    }

                    input.val(el_target.target._value);
                    _this.items[itemObjKey].reference_no = el_target.target._value;
                    return _context5.abrupt("return");

                  case 5:
                    if (reference_no.match(regex)) {
                      _this.items[itemObjKey].reference_no_error = true;

                      _this.setStatusButton();

                      input.addClass('error'); // gán lại selection cũ trước khi mở popup

                      el_target.target.oldValue = el_target.target._value;
                      el_target.target.oldSelectionStart = el_target.target.selectionStart;
                      el_target.target.oldSelectionEnd = el_target.target.selectionEnd;

                      _this4.$modal.show('dialog', {
                        text: lang_text.mes_reference_no_input_error,
                        buttons: [{
                          title: lang_text.ok,
                          "default": true,
                          handler: function () {
                            var _handler = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
                              return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
                                while (1) {
                                  switch (_context3.prev = _context3.next) {
                                    case 0:
                                      _this.$modal.hide('dialog'); // 3 line: disable button và xóa border error


                                      _this.items[itemObjKey].reference_no_error = false;

                                      _this.setStatusButton();

                                      input.removeClass('error'); // 3 line: replace các kí tự ,''

                                      reference_no = reference_no.replace(/[,'"]/ig, '');
                                      input.val(reference_no);
                                      _this.items[itemObjKey].reference_no = reference_no; // call ajax save reference no

                                      _context3.next = 9;
                                      return _this.saveReferenceNo(input, id, itemObjKey, reference_no);

                                    case 9:
                                      // 2 line: focus lại input và gán lại selection cũ
                                      input.focus();
                                      input[0].setSelectionRange(el_target.target.oldSelectionStart, el_target.target.oldSelectionEnd);

                                    case 11:
                                    case "end":
                                      return _context3.stop();
                                  }
                                }
                              }, _callee3);
                            }));

                            function handler() {
                              return _handler.apply(this, arguments);
                            }

                            return handler;
                          }()
                        }]
                      });
                    } else {
                      clearTimeout(timer); // Nếu text không có các kí tự ,'" thì input 1,5s sau sẽ call ajax save reference no

                      timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
                          while (1) {
                            switch (_context4.prev = _context4.next) {
                              case 0:
                                _context4.next = 2;
                                return _this.saveReferenceNo(input, id, itemObjKey, reference_no);

                              case 2:
                              case "end":
                                return _context4.stop();
                            }
                          }
                        }, _callee4);
                      })), 1500);
                    }

                  case 6:
                  case "end":
                    return _context5.stop();
                }
              }
            }, _callee5);
          }))();
        },
        saveReferenceNo: function saveReferenceNo(input, id, itemObjKey, reference_no) {
          var _this5 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
            var _this;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
              while (1) {
                switch (_context6.prev = _context6.next) {
                  case 0:
                    _this = _this5;
                    input.prop('readonly', true);
                    _context6.prev = 2;
                    _context6.next = 5;
                    return axios.post(_urlBaseLang + '/cart/update_reference_no', {
                      id: id,
                      reference_no: reference_no
                    })["catch"](function (error) {
                      if (error.response.status == 401) {
                        _this.tokenMismatch();
                      }
                    });

                  case 5:
                    _this.items[itemObjKey].reference_no = reference_no;
                    _this.items[itemObjKey].reference_no_error = false;
                    _context6.next = 9;
                    return _this.loadCartDetails();

                  case 9:
                    _this.setStatusButton();

                    input.prop('readonly', false);
                    _context6.next = 20;
                    break;

                  case 13:
                    _context6.prev = 13;
                    _context6.t0 = _context6["catch"](2);
                    console.log(Object.keys(_context6.t0), _context6.t0.message);
                    _this.items[itemObjKey].reference_no_error = true;

                    _this.setStatusButton();

                    input.addClass('error');
                    input.prop('readonly', false);

                  case 20:
                  case "end":
                    return _context6.stop();
                }
              }
            }, _callee6, null, [[2, 13]]);
          }))();
        },
        setStatusButton: function setStatusButton() {
          var _this = this,
              count = 0;

          _this.items.forEach(function (element) {
            if (typeof element.reference_no_error !== "undefined" && element.reference_no_error == true) {
              _this.disable_button = true;
            } else {
              count++;
            }
          });

          if (_.size(_this.items) == count) {
            _this.disable_button = false;
          }
        },
        // Edit End BP_O2OQ-25 hainp 20210621
        confirmRemove: function confirmRemove(id, itemObjKey) {
          var _this6 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
            var _this;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
              while (1) {
                switch (_context7.prev = _context7.next) {
                  case 0:
                    _this = _this6;
                    _this.id_product = id;
                    _this.itemObjKey = itemObjKey;

                    _this.$modal.show('remove-product');

                  case 4:
                  case "end":
                    return _context7.stop();
                }
              }
            }, _callee7);
          }))();
        },
        removeItem: function removeItem() {
          var _this7 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
            var _this;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
              while (1) {
                switch (_context8.prev = _context8.next) {
                  case 0:
                    _this = _this7;

                    if (_this.id_product == null || _this.itemObjKey == null) {
                      console.error('not found product to remove');

                      _this.$modal.hide('remove-product');
                    } else {
                      axios["delete"](_urlBaseLang + '/cart/' + _this.id_product).then(function (response) {
                        _this.items.splice(_this.itemObjKey, 1);

                        _this.loadCartDetails();

                        _this.$modal.hide('remove-product');
                      })["catch"](function (error) {
                        console.log(error.response);

                        _this.$modal.hide('remove-product');

                        if (error.response.status == 401) {
                          _this7.tokenMismatch();
                        }
                      });
                    }

                  case 2:
                  case "end":
                    return _context8.stop();
                }
              }
            }, _callee8);
          }))();
        },
        loadItems: function loadItems() {
          var _this8 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
            var totals_elm, _this, response;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
              while (1) {
                switch (_context9.prev = _context9.next) {
                  case 0:
                    _loading.css('display', 'block');

                    totals_elm = $('.totals');
                    _this = _this8;
                    _context9.prev = 3;
                    _context9.next = 6;
                    return axios.get(_urlBaseLang + '/cart')["catch"](function (error) {
                      if (error.response.status == 401) {
                        _this8.tokenMismatch();
                      }
                    });

                  case 6:
                    response = _context9.sent;
                    _this.items = response.data.data;
                    _this.itemCount = response.data.data.length;
                    _context9.next = 11;
                    return _this.loadCartDetails();

                  case 11:
                    _this.fixHeightCart();

                    _context9.next = 19;
                    break;

                  case 14:
                    _context9.prev = 14;
                    _context9.t0 = _context9["catch"](3);
                    console.log(Object.keys(_context9.t0), _context9.t0.message);

                    _loading.css('display', 'none');

                    totals_elm.css('display', 'block');

                  case 19:
                    _loading.css('display', 'none');

                    totals_elm.css('display', 'block');

                  case 21:
                  case "end":
                    return _context9.stop();
                }
              }
            }, _callee9, null, [[3, 14]]);
          }))();
        },
        loadCartDetails: function loadCartDetails() {
          var _this9 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
            var _this, response;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
              while (1) {
                switch (_context10.prev = _context10.next) {
                  case 0:
                    _this = _this9;
                    _context10.prev = 1;
                    _context10.next = 4;
                    return axios.get(_urlBaseLang + '/cart/details');

                  case 4:
                    response = _context10.sent;
                    axios.get(_urlBaseLang + '/cart/get_quantity_cart').then(function (res) {
                      $('#cart-number').text(res.data);
                    });
                    _this.details = response.data.data;
                    _this.quotation_no = response.data.data.quotation_no;
                    _this.user_name = response.data.data.user_name; //Add BP_O2OQ-4 hainp 20200605

                    _this.max_decimal = response.data.data.max_decimal; //Add BP_O2OQ-7 hainp 20200710
                    //await _this.createQuotation();

                    _context10.next = 15;
                    break;

                  case 12:
                    _context10.prev = 12;
                    _context10.t0 = _context10["catch"](1);
                    console.log(Object.keys(_context10.t0), _context10.t0.message); // this.tokenMismatch()

                  case 15:
                  case "end":
                    return _context10.stop();
                }
              }
            }, _callee10, null, [[1, 12]]);
          }))();
        },
        mail: function mail() {
          var _this10 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
            var _this;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
              while (1) {
                switch (_context11.prev = _context11.next) {
                  case 0:
                    _this = _this10;
                    _this.validate_mail = null; // Edit Start BP_O2OQ-25 hainp 20210625

                    _this.setStatusButton();

                    if (!_this.disable_button) {
                      _context11.next = 5;
                      break;
                    }

                    return _context11.abrupt("return", false);

                  case 5:
                    // Edit End BP_O2OQ-25 hainp 20210625
                    _this.$modal.show('send-mail');

                  case 6:
                  case "end":
                    return _context11.stop();
                }
              }
            }, _callee11);
          }))();
        },
        sendMail: function sendMail() {
          var _this11 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
            var _this, email, make_html_cart;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
              while (1) {
                switch (_context12.prev = _context12.next) {
                  case 0:
                    _this = _this11;
                    _this.button_click = 0;

                    _loading.css('display', 'block');

                    email = $('#email-send').val();
                    _context12.t0 = email == "";

                    if (_context12.t0) {
                      _context12.next = 10;
                      break;
                    }

                    _context12.next = 8;
                    return _this.validateEmail(email);

                  case 8:
                    _context12.t1 = _context12.sent;
                    _context12.t0 = _context12.t1 == false;

                  case 10:
                    if (!_context12.t0) {
                      _context12.next = 14;
                      break;
                    }

                    _this.validate_mail = lang_text.mes_email_error;

                    _loading.css('display', 'none');

                    return _context12.abrupt("return", false);

                  case 14:
                    _this.validate_mail = null;
                    _context12.next = 17;
                    return _this.make_html_cart();

                  case 17:
                    make_html_cart = _context12.sent;
                    _context12.next = 20;
                    return _this.createQuotation();

                  case 20:
                    if (!(make_html_cart == true)) {
                      _context12.next = 25;
                      break;
                    }

                    _context12.next = 23;
                    return axios.post(_urlBaseLang + '/cart/mail', {
                      email: email
                    }).then(function (response) {
                      _this.$modal.hide('send-mail');

                      console.log(response.status);

                      if (response.data.status != 'OK') {
                        _this.message = response.data.messagepage;

                        _this.$modal.show('notification');
                      } else {
                        _this.message = response.data.messagepage;

                        _this.$modal.show('notification');
                      }

                      _loading.css('display', 'none');
                    });

                  case 23:
                    _context12.next = 26;
                    break;

                  case 25:
                    _loading.css('display', 'none');

                  case 26:
                  case "end":
                    return _context12.stop();
                }
              }
            }, _callee12);
          }))();
        },
        validateEmail: function validateEmail(email) {
          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
            var re;
            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
              while (1) {
                switch (_context13.prev = _context13.next) {
                  case 0:
                    re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return _context13.abrupt("return", re.test(String(email).toLowerCase()));

                  case 2:
                  case "end":
                    return _context13.stop();
                }
              }
            }, _callee13);
          }))();
        },
        downloadPdfCart: function downloadPdfCart() {
          var _this12 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
            var _this;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
              while (1) {
                switch (_context15.prev = _context15.next) {
                  case 0:
                    _this = _this12;
                    _this.button_click = 1;

                    _loading.css('display', 'block'); // Edit Start BP_O2OQ-25 hainp 20210625


                    _this.setStatusButton();

                    if (!_this.disable_button) {
                      _context15.next = 7;
                      break;
                    }

                    _loading.css('display', 'none');

                    return _context15.abrupt("return", false);

                  case 7:
                    // Edit End BP_O2OQ-25 hainp 20210625
                    try {
                      axios.get(_base_app + '/check-token-expired').then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14() {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
                          while (1) {
                            switch (_context14.prev = _context14.next) {
                              case 0:
                                _context14.next = 2;
                                return _this.make_html_cart();

                              case 2:
                                _context14.next = 4;
                                return _this.createQuotation();

                              case 4:
                                window.location.href = _urlBaseLang + '/cart/downloadpdf';

                              case 5:
                              case "end":
                                return _context14.stop();
                            }
                          }
                        }, _callee14);
                      })))["catch"](function (error) {
                        if (error.response.status == 401) {
                          _this12.tokenMismatch();
                        }
                      });
                    } catch (error) {
                      console.log(Object.keys(error), error.message);

                      _loading.css('display', 'none');
                    }

                    _loading.css('display', 'none');

                  case 9:
                  case "end":
                    return _context15.stop();
                }
              }
            }, _callee15);
          }))();
        },
        make_html_cart: function make_html_cart() {
          var _this13 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee16() {
            var html;
            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee16$(_context16) {
              while (1) {
                switch (_context16.prev = _context16.next) {
                  case 0:
                    _context16.prev = 0;
                    html = $('#cart-content').html();
                    _context16.next = 4;
                    return axios.post(_urlBaseLang + '/cart/downloadpdf', {
                      html: html
                    })["catch"](function (error) {
                      console.log(error);

                      if (error.response.status == 401) {
                        _this13.tokenMismatch();
                      }
                    });

                  case 4:
                    _context16.next = 11;
                    break;

                  case 6:
                    _context16.prev = 6;
                    _context16.t0 = _context16["catch"](0);
                    console.log(Object.keys(_context16.t0), _context16.t0.message);

                    _loading.css('display', 'none'); // this.tokenMismatch()


                    return _context16.abrupt("return", false);

                  case 11:
                    return _context16.abrupt("return", true);

                  case 12:
                  case "end":
                    return _context16.stop();
                }
              }
            }, _callee16, null, [[0, 6]]);
          }))();
        },
        createQuotation: function createQuotation() {
          var _this14 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee17() {
            var _this;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee17$(_context17) {
              while (1) {
                switch (_context17.prev = _context17.next) {
                  case 0:
                    _this = _this14;
                    _context17.next = 3;
                    return axios.post(_urlBaseLang + '/cart/quotation', {
                      button_click: _this.button_click
                    }).then(function (response) {
                      if (response.data.status === 'success') {
                        _this.quotation_no = response.data.file_name;
                        _this.user_name = response.data.user_name; //Add BP_O2OQ-4 hainp 20200608

                        //Add BP_O2OQ-4 hainp 20200608
                        _this.max_decimal = response.data.max_decimal; //Add BP_O2OQ-7 hainp 20200710
                      } else {
                        console.log(response);
                      }
                    })["catch"](function (error) {
                      console.log(error);

                      if (error.response.status == 401) {
                        _this14.tokenMismatch();
                      }
                    });

                  case 3:
                  case "end":
                    return _context17.stop();
                }
              }
            }, _callee17);
          }))();
        },
        downloadCsvCart: function downloadCsvCart() {
          var _this15 = this;

          return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee18() {
            var _this, make_html_cart;

            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee18$(_context18) {
              while (1) {
                switch (_context18.prev = _context18.next) {
                  case 0:
                    _this = _this15;
                    _this.button_click = 2;

                    _loading.css('display', 'block');

                    _context18.next = 5;
                    return _this.make_html_cart();

                  case 5:
                    make_html_cart = _context18.sent;
                    _context18.next = 8;
                    return _this.createQuotation();

                  case 8:
                    _loading.css('display', 'none');

                    if (make_html_cart == true) {
                      window.location.href = _urlBaseLang + '/cart/downloadcsv';
                    }

                  case 10:
                  case "end":
                    return _context18.stop();
                }
              }
            }, _callee18);
          }))();
        },
        formatPrice: function formatPrice(value) {
          var val = (value / 1).toFixed(this.max_decimal); //Edit BP_O2OQ-7 hainp 20200710
          //console.log(val);
          // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");//Remove BP_O2OQ-7 hainp 20200709
          //Add Start BP_O2OQ-7 hainp 20200709
          //Know whether there is a decimal point in the number, and use different regular expressions depending on that:
          // /(\d)(?=(\d{3})+$)/g for integers
          // /(\d)(?=(\d{3})+\.)/g for decimals
          // Use two regular expressions, one to match the decimal portion, and a second to do a replace on it.

          return val.toString().replace(/^[+-]?\d+/, function (_int) {
            return _int.replace(/(\d)(?=(\d{3})+$)/g, '$1,');
          }); //Add End BP_O2OQ-7 hainp 20200709
        },
        fixHeightCart: function fixHeightCart() {
          var orders_no_element = $('.product-series');
          orders_no_element.each(function (key, item) {
            var children = $(item).find('.series-name');

            if (children.length > 1) {
              var parents = children.closest('.product');
              var product_order = parents.find('.product-order_no').find('.order-no');
              var product_price = parents.find('.product-price').find('.price-item');
              var product_total_price = parents.find('.product-line-price').find('.total-item');
              children.each(function (child_key, child_item) {
                var height = $(child_item).height();
                product_order.eq(child_key).height(height);
                product_price.eq(child_key).height(height);
                product_total_price.eq(child_key).height(height);
              });
            }
          });
        }
      }
    });
  }
})(jQuery);

/***/ }),

/***/ "./resources/assets/tostem/admin/pmaintenance/scss/pmaintenance.scss":
/*!***************************************************************************!*\
  !*** ./resources/assets/tostem/admin/pmaintenance/scss/pmaintenance.scss ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/tostem/admin/pmaintenance/scss/jquery-ui.scss":
/*!************************************************************************!*\
  !*** ./resources/assets/tostem/admin/pmaintenance/scss/jquery-ui.scss ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/tostem/admin/quotationresult/scss/quotationresult.scss":
/*!*********************************************************************************!*\
  !*** ./resources/assets/tostem/admin/quotationresult/scss/quotationresult.scss ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/tostem/admin/accessanalysis/scss/accessanalysis.scss":
/*!*******************************************************************************!*\
  !*** ./resources/assets/tostem/admin/accessanalysis/scss/accessanalysis.scss ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/tostem/front/cart/cart.scss":
/*!******************************************************!*\
  !*** ./resources/assets/tostem/front/cart/cart.scss ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/tostem/front/login/login.scss":
/*!********************************************************!*\
  !*** ./resources/assets/tostem/front/login/login.scss ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/tostem/front/quotation_system/quotation.scss":
/*!***********************************************************************!*\
  !*** ./resources/assets/tostem/front/quotation_system/quotation.scss ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/tostem/front/quotation_system/products/product.scss":
/*!******************************************************************************!*\
  !*** ./resources/assets/tostem/front/quotation_system/products/product.scss ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/sass/users.scss":
/*!******************************************!*\
  !*** ./resources/assets/sass/users.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/***/ ((module) => {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
    return obj[key];
  }
  try {
    // IE 8 has a broken Object.defineProperty that only works on DOM objects.
    define({}, "");
  } catch (err) {
    define = function(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  define(IteratorPrototype, iteratorSymbol, function () {
    return this;
  });

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = GeneratorFunctionPrototype;
  define(Gp, "constructor", GeneratorFunctionPrototype);
  define(GeneratorFunctionPrototype, "constructor", GeneratorFunction);
  GeneratorFunction.displayName = define(
    GeneratorFunctionPrototype,
    toStringTagSymbol,
    "GeneratorFunction"
  );

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      define(prototype, method, function(arg) {
        return this._invoke(method, arg);
      });
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      define(genFun, toStringTagSymbol, "GeneratorFunction");
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return PromiseImpl.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return PromiseImpl.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  define(AsyncIterator.prototype, asyncIteratorSymbol, function () {
    return this;
  });
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    if (PromiseImpl === void 0) PromiseImpl = Promise;

    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList),
      PromiseImpl
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  define(Gp, toStringTagSymbol, "Generator");

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  define(Gp, iteratorSymbol, function() {
    return this;
  });

  define(Gp, "toString", function() {
    return "[object Generator]";
  });

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : 0
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, in modern engines
  // we can explicitly access globalThis. In older engines we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  if (typeof globalThis === "object") {
    globalThis.regeneratorRuntime = runtime;
  } else {
    Function("r", "regeneratorRuntime = r")(runtime);
  }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/tostem/front/cart/cart": 0,
/******/ 			"css/users": 0,
/******/ 			"tostem/front/quotation_system/products/product": 0,
/******/ 			"tostem/front/quotation_system/quotation": 0,
/******/ 			"tostem/front/login/login": 0,
/******/ 			"tostem/front/cart/cart": 0,
/******/ 			"tostem/admin/accessanalysis/css/accessanalysis": 0,
/******/ 			"tostem/admin/quotationresult/css/quotationresult": 0,
/******/ 			"tostem/admin/pmaintenance/css/jquery-ui": 0,
/******/ 			"tostem/admin/pmaintenance/css/pmaintenance": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/tostem/front/cart/cart.js")))
/******/ 	__webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/tostem/front/cart/cart.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/tostem/front/login/login.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/tostem/front/quotation_system/quotation.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/tostem/front/quotation_system/products/product.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/sass/users.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/tostem/admin/pmaintenance/scss/pmaintenance.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/tostem/admin/pmaintenance/scss/jquery-ui.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/tostem/admin/quotationresult/scss/quotationresult.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/users","tostem/front/quotation_system/products/product","tostem/front/quotation_system/quotation","tostem/front/login/login","tostem/front/cart/cart","tostem/admin/accessanalysis/css/accessanalysis","tostem/admin/quotationresult/css/quotationresult","tostem/admin/pmaintenance/css/jquery-ui","tostem/admin/pmaintenance/css/pmaintenance"], () => (__webpack_require__("./resources/assets/tostem/admin/accessanalysis/scss/accessanalysis.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=cart.js.map