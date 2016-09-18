@if (isset($file->get_tags()[$tag]))
    @if (count($file->get_tags()[$tag]) === 1)
        {{ array_first($file->get_tags()[$tag]) }}
    @else
        <ul>
            @foreach ($file->get_tags()[$tag] as $key => $value)
                <li>{{ $key }} => {{ $value }}</li>
            @endforeach
        </ul>
    @endif
@endif

@if (isset($file->get_suggested_tags()[$tag]))
    <div class="suggested">
        @if (count($file->get_suggested_tags()[$tag]) === 1)
            {{ array_first($file->get_suggested_tags()[$tag]) }}
        @else
            <ul>
                @foreach ($file->get_suggested_tags()[$tag] as $key => $value)
                    <li>{{ $value }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif