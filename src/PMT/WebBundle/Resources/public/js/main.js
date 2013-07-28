$(function () {

    moment.defaultFormat = 'DD-MM-YYYY HH:mm:ss';

    function updateDateTime() {
        $('time.moment')
            .html(function () {
                return moment($(this).attr('datetime')).fromNow();
            })
            .tooltip({
                title: function() {
                    return moment($(this).attr('datetime')).format();
                }
            });
        $('[class^="icon-issue-"]').tooltip();
    }

    window.setInterval(function() {
        updateDateTime();
    }, 2000);
    updateDateTime();

    $(document)
        .on('fos_comment_add_comment', '.fos_comment_comment_new_form', function(data) {
            // place the comment in the correct place
            $(data.currentTarget.nextSibling.nextSibling).prependTo($(this).parent().next('ul'));
        });
});
