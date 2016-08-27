@extends('layout')

@section('title')
    PHP ID3Tag Modifier &gt; Rename Files
@endsection

@section('style')
@endsection

@section('scripts')
@endsection

@section('body')
    <h1>Rename files</h1>
        <table class="table table-hover table-condensed file-list-table">
            <tr>
                <th>Current title</th>
                <th>New title</th>
                <th class="short">Move</th>
                <th class="short">Delete</th>
            </tr>

            @foreach ($files as $file)
                <tr>
                    <td>{{ $file->get_name() }}</td>
                    <td>{{ $file->get_name() }}</td>
                    <td class="short centered"><button class="btn btn-outline-primary btn-sm">Move</button></td>
                    <td class="short centered"><button class="btn btn-outline-danger btn-sm">Delete</button></td>
                </tr>
            @endforeach
        </table>
@endsection