function moveAction(element) {
    var $this = $(element);
    var $row = $this.parents('tr');

    makeRequest($row, moveUrl, function(response) {
        if (response.result) {
            $row.html('<td colspan="4" class="alert alert-success" role="alert">The file was successfully moved !</td>');
        } else {
            $row.html('<td colspan="4" class="alert alert-danger" role="alert">Error while moving the file</td>');
        }
    });
}

function deleteAction(element) {
    var $this = $(element);
    var $row = $this.parents('tr');
    
    makeRequest($row, deleteUrl, function(response) {
        if (response.result) {
            $row.html('<td colspan="4" class="alert alert-success" role="alert">The file was successfully deleted !</td>');
        } else {
            $row.html('<td colspan="4" class="alert alert-danger" role="alert">Error while deleting the file</td>');
        }
    });
}

function makeRequest($row, url, callback) {
    var filepath = $row.find('.form-filepath').val();
    var title = $row.find('.form-title').val();

    $.post(
        url,
        {
            'filepath': filepath,
            'title'   : title,
            '_token'  : csrf_token
        },
        callback,
        'json'
    );
}