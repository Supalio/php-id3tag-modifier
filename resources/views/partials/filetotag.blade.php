<tr>
    <td class="image">
        @if (isset($file->get_tags()['image']))
            <img src="data:{{ $file->get_tags()['image']['image_mime'] }};base64,{{ base64_encode($file->get_tags()['image']['data']) }}" width="50" height="50" /><br />
            <span>{{ $file->get_tags()['image']['image_width'] }}x{{ $file->get_tags()['image']['image_height'] }}</span>
        @endif
    </td>
    <td class="filename">
        <a href="#" target="_blank">{{ $file->get_name() }}</a>
    </td>
    <td>@include('helpers.display_tag', ['tag' => 'artist'])</td>
    <td>@include('helpers.display_tag', ['tag' => 'title'])</td>
    <td>@include('helpers.display_tag', ['tag' => 'album'])</td>
    <td>@include('helpers.display_tag', ['tag' => 'band'])</td>
    <td>@include('helpers.display_tag', ['tag' => 'content_group_description'])</td>
    <td>@include('helpers.display_tag', ['tag' => 'genre'])</td>
    <td class="year">@include('helpers.display_tag', ['tag' => 'year'])</td>
    <td class="track">@include('helpers.display_tag', ['tag' => 'track_number'])</td>
    <td class="bpm">@include('helpers.display_tag', ['tag' => 'bpm'])</td>
    <td class="key">@include('helpers.display_tag', ['tag' => 'initial_key'])</td>
    <td class="action">
        <button type="button" onclick="tagAction(this)" class="btn btn-outline-primary btn-sm">Tag</button>
        <button type="button" onclick="deleteAction(this)" class="btn btn-outline-danger btn-sm">Del</button>
    </td>
</tr>