@extends('layout')

@section('title')
    PHP ID3Tag Modifier &gt; Rename Files
@endsection

@section('body')
    <h1>Rename and move files</h1>
    <h6><b>{{ count($files) }}</b> .mp3 files in the directory</h6>
        <table class="table table-hover table-condensed file-list-table">
            <tr>
                <th class="large">Current title</th>
                <th class="large">New title</th>
                <th class="short">Move</th>
                <th class="short">Delete</th>
            </tr>

            @foreach ($files as $file)
                <tr>
                    <form method="POST" action="">
                        {{ csrf_field() }}
                        <input type="hidden" name="filepath" value="{{ $file->get_full_path() }}" />
                        <td class="large">{{ $file->get_name() }}</td>
                        <td class="large form-group"><input type="text" name="title" value="{{ $file->get_name() }}" class="form-control" /></td>
                        <td class="short centered"><button type="submit" class="btn btn-outline-primary btn-sm">Move</button></td>
                        <td class="short centered"><button class="btn btn-outline-danger btn-sm">Delete</button></td>
                    </form>
                </tr>
            @endforeach
        </table>
@endsection