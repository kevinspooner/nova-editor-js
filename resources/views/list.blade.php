<div class="editor-js-block">
    {!! ($style == 'unordered') ? '<ul>' : '<ol>' !!}
    @foreach ($items as $item)
        @include('nova-editor-js::list-item', ['item' => $item, 'style' => $style])
    @endforeach
    {!! ($style == 'unordered') ? '</ul>' : '</ol>' !!}
</div>
