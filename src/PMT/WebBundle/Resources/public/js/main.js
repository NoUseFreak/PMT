$(function() {
    $('time.moment').html(function() {
        return moment($(this).attr('datetime')).fromNow();
    })
});
