<div style="grid-area: {{ $gridArea }};{{ ! $show ? 'display:none' : '' }}"
     class="grid overflow-hidden bg-tile rounded">
    <div class="absolute pin overflow-hidden p-padding">
        @if ($title === '')
            <h1>{{ $title }}</h1>
        @endif
        {{ $slot }}
    </div>
</div>
