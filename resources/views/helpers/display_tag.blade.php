@if (isset($file->get_tags()[$tag]))
    @if (count($file->get_tags()[$tag]) === 1)
        <input type="text" name="{{ $tag }}[{{ $key }}]" value="{{ array_first($file->get_tags()[$tag]) }}" class="form-control form-{{ $tag }}" />
    @else
        <ul>
            @foreach ($file->get_tags()[$tag] as $key => $value)
                <li>{{ $key }} => {{ $value }}</li>
            @endforeach
        </ul>
    @endif
@else
    <input type="text" name="{{ $tag }}[{{ $key }}]" value="" class="form-control form-{{ $tag }}" />
@endif

@if (isset($file->get_suggested_tags()[$tag]))
    <div class="suggested">
        @if (count($file->get_suggested_tags()[$tag]) === 1)
            <a href="#" class="tag-suggestion">{{ array_first($file->get_suggested_tags()[$tag]) }}</a>
        @else
            <ul>
                @foreach ($file->get_suggested_tags()[$tag] as $key => $value)
                    <li><a href="#" class="tag-suggestion">{{ $value }}</a></li>
                @endforeach
            </ul>
        @endif
    </div>
@endif