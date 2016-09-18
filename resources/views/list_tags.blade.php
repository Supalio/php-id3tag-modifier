@extends('layout')

@section('title')
    PHP ID3Tag Modifier &gt; Edit Tags
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ elixir('js/tags.js') }}"></script>
    <script type="text/javascript" src="{{ elixir('js/rename.js') }}"></script>
@endsection

@section('body')
    <h1>Edit Tags</h1>
    <h6><b>{{ count($files) }}</b> .mp3 files in the directory</h6>

    <table class="table table-hover table-condensed tag-file-table">
        <tbody>
            <tr>
                <th>Cover</th>
                <th>File Name</th>
                <th>Artist</th>
                <th>Title</th>
                <th>Album</th>
                <th>Album Artist</th>
                <th>Label</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Track #</th>
                <th>BPM</th>
                <th>Key</th>
                <th>Action</th>
            </tr>

            @if ($files)
                @each('partials.filetotag', $files, 'file')
            @endif
        </tbody>
    </table>
@endsection