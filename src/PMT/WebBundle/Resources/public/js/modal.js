$('.modal-footer').on('click', '.btn.btn-primary.modal-save', function(e) {
    $(this).parents('.modal').find('form').submit();
});
