$(document).ready(function () {
  $('.sidebar-menu-link-item').click(function () {
    $('.sidebar-menu-link-item').removeClass(' active');
    $(this).addClass(' active');
  });
});