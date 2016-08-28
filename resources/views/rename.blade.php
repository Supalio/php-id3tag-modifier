@extends('layout')

@section('title')
    PHP ID3Tag Modifier &gt; Rename Files
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ elixir('js/rename.js') }}"></script>
@endsection

@section('body')
    @if (session()->has('files_moved') && session()->has('files_in_error'))
        <div class="alert alert-info" role="alert">
            <strong>{{ session('files_moved') }}</strong> files were successfully moved
            @if (session('files_in_error') > 0)
                but <strong>{{ session('files_in_error') }}</strong> were not
            @endif
            .
        </div>
    @endif

    <h1>Rename and move files</h1>
    <h6><b>{{ count($files) }}</b> .mp3 files in the directory</h6>
    <table class="table table-hover table-condensed file-list-table">
        <tr>
            <th class="large">Current title</th>
            <th class="large">New title</th>
            <th class="short">Move</th>
            <th class="short">Delete</th>
        </tr>

        @if ($files)
            <form method="POST" action="{{ route('moveFiles') }}">
                {{ csrf_field() }}
                @each('partials.filetomove', $files, 'file')
                <tr>
                    <td></td>
                    <td><button type="submit" class="btn btn-outline-primary btn-large ">Move all files</button></td>
                    <td></td>
                    <td></td>
                </tr>
            </form>
        @endif
    </table>
@endsection