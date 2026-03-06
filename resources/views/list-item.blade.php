@php
    // Handle both old format (string) and new format (array with content and items)
    if (is_string($item)) {
        // Old format: simple string
        $content = $item;
        $nestedItems = [];
    } else {
        // New format: array with content and optional nested items
        $content = $item['content'] ?? '';
        $nestedItems = isset($item['items']) && is_array($item['items']) && !empty($item['items']) ? $item['items'] : [];
    }
    $nestedStyle = $style; // Use same style for nested lists
@endphp

<li>
    {!! $content !!}
    @if (!empty($nestedItems))
        {!! ($nestedStyle == 'unordered') ? '<ul>' : '<ol>' !!}
        @foreach ($nestedItems as $nestedItem)
            @include('nova-editor-js::list-item', ['item' => $nestedItem, 'style' => $nestedStyle])
        @endforeach
        {!! ($nestedStyle == 'unordered') ? '</ul>' : '</ol>' !!}
    @endif
</li>