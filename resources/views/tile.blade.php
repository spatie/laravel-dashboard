<div
    style="grid-area: {{ $gridArea }}"
    class="overflow-hidden rounded relative bg-tile {{ $show ? '' : 'none' }}"
>
    <div
        class="absolute inset-0 overflow-hidden p-4"
        @if($fade)
            style="-webkit-mask-image: linear-gradient(black, black calc(100% - 1rem), transparent)"
        @endif
    >
        {{ $slot }}
    </div>
</div>
