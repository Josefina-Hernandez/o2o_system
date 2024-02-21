/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************************!*\
  !*** ./resources/assets/tostem/common/js/tostem_admin.js ***!
  \***********************************************************/
$('.rendect-page').mousedown(function (event) {
  var _link_rendect = $(this).attr('data-href');

  if (event.which == 2 || event.ctrlKey && event.which == 1) {
    $(".loader").show();
    axios.post(_link_check_auth_login).then(function (response) {
      if (response.data.status == 'OK') {
        $(".loader").hide();
        window.open(_link_rendect, '_blank');
      } else {
        alert(response.data.msg);
        window.location.reload();
      }
    })["catch"](function (error) {
      alert('Your session has expired.');
      window.location.reload();
    });
  } else if (event.which == 1) {
    $(".loader").show();
    axios.post(_link_check_auth_login).then(function (response) {
      console.log(response);

      if (response.data.status == 'OK') {
        window.location.href = _link_rendect;
      } else {
        alert(response.data.msg);
        window.location.reload();
      }
    })["catch"](function (error) {
      alert('Your session has expired.');
      window.location.reload();
    });
  }
});
/******/ })()
;
//# sourceMappingURL=tostem_admin.js.map