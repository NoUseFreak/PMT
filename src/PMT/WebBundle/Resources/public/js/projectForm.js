var collectionHolder = $('ul.milestones');
collectionHolder.find('li').each(function() {
    addMilestoneFormDeleteLink($(this));
});

var formTemplate = '<div class="col-lg-5">'
    + '<label for="project_edit_milestones_2_name" class="required">Name</label><input type="text" id="project_edit_milestones_2_name" name="project_edit[milestones][2][name]" required="required" />'
    + '</div>'
    + '<div class="col-lg-5">'
    + '<label for="project_edit_milestones_2_dueDate">Due date</label><input type="date" id="project_edit_milestones_2_dueDate" name="project_edit[milestones][2][dueDate]" />'
    + '</div>'
    + '<div class="col-lg-2 actions"></div>';
var $addMilestoneLink = $('<a href="#" class="add_milestone_link">Add a milestone</a>');
var $newLinkLi = $('<li></li>').append($addMilestoneLink);

function addMilestoneForm(collectionHolder, $newLinkLi) {
    var index = collectionHolder.data('index');
    var newForm = formTemplate.replace(/__name__/g, index);

    collectionHolder.data('index', index + 1);

    var $newFormLi = $('<li class="row"></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addMilestoneFormDeleteLink($newFormLi);

    $('input[type="date"]').datepicker({
        format: 'yyyy-mm-dd'
    });
}

function addMilestoneFormDeleteLink($milestoneFormLi) {
    var $removeFormA = $('<a href="#"><i class="glyphicon glyphicon-remove" title="delete this milestone"></a>');
    $milestoneFormLi.find('div.actions').append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $milestoneFormLi.remove();
    });
}

$(function () {
    $('select').select2();
    $('#issue_tags').select2({
        'tags': true,
        'multiple': true,
        'minimumInputLength': 2,
        'ajax': {
            'url': "/ajax/tags.json",
            'dataType': 'json',
            'type': 'post',
            'data': function (term, page) {
                return {
                    'q': term,
                    'add_new': true
                };
            },
            'results': function (data, page) {
                return {results: data.tags};
            }
        }
    });
    $('input[type="date"]').datepicker({
        format: 'yyyy-mm-dd'
    });
    collectionHolder.append($newLinkLi);
    collectionHolder.data('index', collectionHolder.find(':input').length);

    $addMilestoneLink.on('click', function(e) {
        e.preventDefault();
        addMilestoneForm(collectionHolder, $newLinkLi);
    });
});
