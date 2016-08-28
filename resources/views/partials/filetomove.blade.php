<tr>
    <input type="hidden" name="filepath[{{ $key }}]" value="{{ $file->get_full_path() }}" />

    <td class="large">{{ $file->get_name() }}</td>
    <td class="large form-group"><input type="text" name="title[{{ $key }}]" value="{{ $file->get_name() }}" class="form-control" /></td>

    <td class="short centered"><button class="btn btn-outline-primary btn-sm">Move</button></td>
    <td class="short centered"><button class="btn btn-outline-danger btn-sm">Delete</button></td>
</tr>