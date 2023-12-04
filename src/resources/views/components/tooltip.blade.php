@php($personalize = tallstackui_personalization('tooltip', $personalization()))

<div @class($personalize['wrapper']) x-data>
    <x-dynamic-component component="tallstack-ui::icon.{{ $style }}.{{ $icon }}"
                         data-position="{{ $position }}"
                         x-tooltip="{!! $text !!}"
                        {{ $attributes->class([$personalize['sizes.' . $size], $colors['icon']]) }}
    />
</div>
