$(function () {

    moment.defaultFormat = 'DD-MM-YYYY HH:mm:ss';

    $('time.moment')
        .html(function () {
            return moment($(this).attr('datetime')).fromNow();
        })
        .tooltip({
            title: function() {
                return moment($(this).attr('datetime')).format();
            }
        });
});
