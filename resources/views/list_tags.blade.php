@extends('layout')

@section('title')
    PHP ID3Tag Modifier &gt; Edit Tags
@endsection

@section('scripts')
    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
        var tagFileUrl = "{{ route('tagFile') }}";
        var deleteUrl = "{{ route('deleteFile') }}";
    </script>
    <script type="text/javascript" src="{{ asset(elixir('js/tags.js')) }}"></script>
    <script type="text/javascript" src="{{ asset(elixir('js/rename.js')) }}"></script>
@endsection

@section('body')
    @if (session()->has('files_tagged') && session()->has('files_in_error'))
        <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            <strong>{{ session('files_tagged') }}</strong> files were successfully tagged
            @if (session('files_in_error') > 0)
                but <strong>{{ session('files_in_error') }}</strong> were not
            @endif
            .
        </div>
    @endif

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

            <form method="POST" action="{{ route('tagFiles') }}">
                {{ csrf_field() }}
                @if ($files)
                    @each('partials.filetotag', $files, 'file')
                @endif

                <tr>
                    <td colspan="13" class="valid-button"><button type="submit" class="btn btn-outline-primary btn-large">Tag all files</button></td>
                </tr>
            </form>
        </tbody>
    </table>
@endsection