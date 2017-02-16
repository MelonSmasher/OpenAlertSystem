$(document).ready(function () {
  if ($.cookie('accessToken')) {
    localStorage.setItem('accessToken', $.cookie('accessToken'));
    $.removeCookie('accessToken');
  }
});