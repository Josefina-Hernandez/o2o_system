/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/tostem/admin/pmaintenance/js/pmaintenance.js":
/*!***********************************************************************!*\
  !*** ./resources/assets/tostem/admin/pmaintenance/js/pmaintenance.js ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  bs_input_file(".input-file");
  update_table_height();

  window.onresize = function (event) {
    update_table_height();
  };
});
$(document).off("click", ".clear_input_search");
$(document).on("click", ".clear_input_search", function () {
  $('.start-date').val('');
  $('.end-date').val('');
});
$(document).off("click", ".search-date");
$(document).on("click", ".search-date", function () {
  var $_time_strart = $('.start-date').val();
  var $_time_end = $('.end-date').val();

  if ($_time_strart == '') {
    alert('Please Select Time Start!');
    return false;
  }

  if ($_time_end == '') {
    alert('Please Select Time End!');
    return false;
  }

  var formData = new FormData();
  formData.append('time_start', $_time_strart);
  formData.append('time_end', $_time_end);
  formData.append("_token", config._token);
  $(".loader").show();
  jQuery.ajax({
    type: 'POST',
    url: config.routes._searchdata,
    async: true,
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    complete: function complete() {
      $(".loader").hide();
    },
    success: function success(data) {
      $('#list-content').empty();
      $('#list-content').html(data.html);
    }
  });
});
$(document).off("click", "#import-fle");
$(document).on("click", "#import-fle", function () {
  var formData = new FormData();
  var files = $('#file-import')[0].files[0];

  if (files == undefined) {
    alert('Please input file!');
    return false;
  }

  formData.append('file', files);
  formData.append("_token", config._token);
  $(".loader").show();
  jQuery.ajax({
    type: 'POST',
    url: config.routes._upload,
    async: true,
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    complete: function complete() {
      $(".loader").hide();

      _reset_file_input();
    },
    success: function success(data) {
      if (data.status == 'OK') {
        alert(data.msg);
        $('#list-content').empty();
        $('#list-content').html(data.html);
        update_table_height();
      }

      if (data.status == 'NG') {
        alert(data.msg);

        if (data.html != undefined) {
          $('#list-content').empty();
          $('#list-content').html(data.html);
          update_table_height();
        }
      }

      if (data.status == 'err_column') {
        alert('There is an error with template of importing file. Template format is incorrect');
        return false;
      }

      if (data.status == 'err_data') {
        alert('Required cell value: ' + data.pos_null);
        return false;
      }
    },
    error: function error(jqXHR, exception) {
      upload_status();
      load_view_all_data();
      update_table_height();
      var msg = 'Import error! system error';
      alert(msg);
    }
  });
});
$(document).off("click", "#download-file-import");
$(document).on("click", "#download-file-import", function () {
  var formData = new FormData();
  var $his_id = $(this).attr('his-id');
  formData.append('his_id', $his_id);
  formData.append('key_download', 0);
  formData.append("_token", config._token);
  $(".loader").show();
  jQuery.ajax({
    type: 'POST',
    url: config.routes._checkdownload,
    async: true,
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    complete: function complete() {
      $(".loader").hide();
    },
    success: function success(data) {
      if (data.status == 'OK') {
        var param = "?his_id=" + data.his_id + "&key_download=" + data.key_download;
        window.location.href = config.routes._download + param;
      }

      if (data.status == 'NG') {
        var msg = 'File not exist!';
        alert(msg);
      }
    },
    error: function error(jqXHR, exception) {
      var msg = 'Download error!';
      alert(msg);
    }
  });
});
$(document).off("click", "#download-filelog-import");
$(document).on("click", "#download-filelog-import", function () {
  var formData = new FormData();
  var $his_id = $(this).attr('his-id');
  formData.append('his_id', $his_id);
  formData.append('key_download', 1);
  formData.append("_token", config._token);
  $(".loader").show();
  jQuery.ajax({
    type: 'POST',
    url: config.routes._checkdownload,
    async: true,
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    complete: function complete() {
      $(".loader").hide();
    },
    success: function success(data) {
      if (data.status == 'OK') {
        var param = "?his_id=" + data.his_id + "&key_download=" + data.key_download;
        window.location.href = config.routes._download + param;
      }

      if (data.status == 'NG') {
        var msg = 'File not exist!';
        alert(msg);
      }
    },
    error: function error(jqXHR, exception) {
      var msg = 'Download error!';
      alert(msg);
    }
  });
});

function bs_input_file($element) {
  $($element).before(function () {
    if (!$(this).prev().hasClass('input-ghost')) {
      var element = $("<input type='file' id='file-import' class='input-ghost' style='visibility:hidden; height:0'>");
      element.attr("name", $(this).attr("name"));
      element.change(function () {
        element.next(element).find('input').val(element.val().split('\\').pop());
      });
      $(this).find("button.btn-choose").click(function () {
        element.click();
      });
      $(this).find("button.btn-reset").click(function () {
        element.val(null);
        $(this).parents(".input-file").find('input').val('');
      });
      $(this).find('input').css("cursor", "pointer");
      $(this).find('input').mousedown(function () {
        $(this).parents('.input-file').prev().click();
        return false;
      });
      return element;
    }
  });
}

function update_table_height() {
  var box = $("#parentdata");
  var window_h_margin = 345;
  var window_h = $('#content-body').height();
  var set_h = window_h - window_h_margin;
  box.height(set_h);
}

function upload_status() {
  var formData = new FormData();
  formData.append("_token", config._token);
  jQuery.ajax({
    type: 'POST',
    url: config.routes._uploadstatus,
    async: false,
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    complete: function complete() {}
  });
}

function load_view_all_data() {
  var formData = new FormData();
  formData.append("_token", config._token);
  jQuery.ajax({
    type: 'POST',
    url: config.routes._viewalldata,
    async: false,
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    success: function success(data) {
      $('#list-content').empty();
      $('#list-content').html(data.html);
    }
  });
}

function _reset_file_input() {
  $('#file-import').val('');
  $('#fileInput').val('');
}

/***/ }),

/***/ 3:
/*!*****************************************************************************!*\
  !*** multi ./resources/assets/tostem/admin/pmaintenance/js/pmaintenance.js ***!
  \*****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\Public\docker\src\tostem_src\resources\assets\tostem\admin\pmaintenance\js\pmaintenance.js */"./resources/assets/tostem/admin/pmaintenance/js/pmaintenance.js");


/***/ })

/******/ });