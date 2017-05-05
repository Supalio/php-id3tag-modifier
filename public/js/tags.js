/**** FUNCTIONS ****/
// When clicking on the "Set" button, set all tags to suggested values
function setAllTags(element) {
    var $this = $(element);
    var $row = $this.parents('tr');

    $row.find('td').has('a.tag-suggestion').each(function() {
        $(this).find('input.form-control').val(
            $(this).find('a.tag-suggestion:first').text()
        );
    });
}

// When clicking on the "Tag" button, make the request to update the tags
function tagAction(element) {
    var $this = $(element);
    var $row = $this.parents('tr');

    var filepath = $row.find('.form-filepath').val();

    $.post(
        tagFileUrl,
        {
            'filepath': filepath,
            'tags'    : {
                            artist:       $row.find('.form-artist').val(),
                            title:        $row.find('.form-title').val(),
                            album:        $row.find('.form-album').val(),
                            band:         $row.find('.form-band').val(),
                            publisher:    $row.find('.form-publisher').val(),
                            genre:        $row.find('.form-genre').val(),
                            year:         $row.find('.form-year').val(),
                            track_number: $row.find('.form-track_number').val(),
                            bpm:          $row.find('.form-bpm').val(),
                            initial_key:  $row.find('.form-initial_key').val(),
                        },
            '_token'  : csrf_token
        },
        function(response) {
            if (response.result.errors.length > 0) {
                $row.html('<td colspan="13" class="alert alert-danger" role="alert">Error while tagging the file<ul class="errors"></ul></td>');
                $(response.result.errors).each(function(i, error) {
                    $row.find('.errors').append("<li>" + error + "</li>");
                });
            } else {
                $row.html('<td colspan="13" class="alert alert-success" role="alert">The file was successfully tagged !</td>');
                if (response.result.warnings) console.log(response.result.warnings);
            }
        },
        'json'
    );
}

/**** BEGIN SCRIPT ****/
$(document).ready(function() {
    
    // Show a warning if current value differs from at least one suggested value
    $('a.tag-suggestion').each(function() {
        $input = $(this).parents('td').find('input.form-control');
        if ($(this).text() !== $input.val()) $input.parent().addClass('has-warning');
    });

    // When clicking on suggestion links, the value of the form will update automatically
    $('a.tag-suggestion').click(function(event) {
        event.preventDefault();
        $(this).parents('td').find('input.form-control').val($(this).text());
    });

});