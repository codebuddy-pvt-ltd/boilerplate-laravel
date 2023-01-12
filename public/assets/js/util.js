$(function () {
  $('body').on('click', '.__btn-open-sidebar', function (e) {
    e.preventDefault();
    const target = $(this).data('target');
    $(target).toggleClass('active');
  });

  $('body').on('click', '.__btn-close-sidebar', function (e) {
    e.preventDefault();
    $(this).parents('.sidebar-wrapper').removeClass('active');
  });

  $('body').on('click', '.__btn-cancel-sidebar', function (e) {
    e.preventDefault();
    $('body').find('.__btn-close-sidebar').trigger('click');
  });

  $('body').on('change', '.file-input input', function () {
    const reader = new FileReader();
    reader.addEventListener('load', function () {
      document.querySelector(
        '.img'
      ).style.backgroundImage = `url(${reader.result})`;
    });
    reader.readAsDataURL(this.files[0]);
  });
});
