@php($personalize = tallstackui_personalization('alert', $personalization()))

<div @class([$personalize['wrapper'], $colors['background']])
     x-data="{ show : true }"
     x-show="show">
    <div @class([$personalize['content.wrapper'], 'items-center' => $title && $text === null])>
        <div @class([$personalize['content.base']])>
            <div @class(['mr-2' => $icon, 'mt-1' => $icon && $title])>
                @if ($icon)
                    <x-icon :$icon @class([$personalize['icon.size'], $colors['text']]) />
                @endif
            </div>
            <div @class([$colors['text']])>
                @if ($title)
                    <h3 @class([$personalize['text.title'], $colors['text'] => $title !== null])>{{ $title }}</h3>
                @endif
                <p @class([$personalize['text.description'], 'mt-2' => $title !== null])>{{ $text ?? $slot }}</p>
            </div>
        </div>
        @if ($closeable)
            <div @class($personalize['close.wrapper'])>
                <button dusk="alert-close-button" class="cursor-pointer" x-on:click="show = false">
                    <x-icon icon="x-mark" @class([$personalize['close.size'], $colors['text']]) />
                </button>
            </div>
        @endif
    </div>
</div>
