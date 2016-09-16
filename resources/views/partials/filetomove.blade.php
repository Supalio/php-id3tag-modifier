<tr>
    <input type="hidden" name="filepath[{{ $key }}]" value="{{ $file->get_full_path() }}" class="form-filepath" />

    <td class="large">{{ $file->get_name() }}</td>
    <td class="large form-group"><input type="text" name="title[{{ $key }}]" value="{{ app('suggester')->get_suggested_name($file) }}" class="form-control form-title" /></td>

    <td class="short centered"><button type="button" onclick="moveAction(this)" class="btn btn-outline-primary btn-sm">Move</button></td>
    <td class="short centered"><button type="button" onclick="deleteAction(this)" class="btn btn-outline-danger btn-sm">Delete</button></td>
</tr>