<div
    style="grid-area: {{ $gridArea }}"
    class="overflow-hidden rounded relative {{ $show ? '' : 'none' }}"
    :class="darkMode ? 'bg-gray-800' : 'bg-white'"
>
    <div class="absolute inset-0 overflow-hidden p-2">
        @isset($title)
            <h1>{{ $title }}</h1>
        @endif

        {{ $slot }}
    </div>
</div>
