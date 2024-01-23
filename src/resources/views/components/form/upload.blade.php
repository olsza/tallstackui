@php
    \TallStackUi\Foundation\Exceptions\MissingLivewireException::throwIf($livewire, 'upload');
    if ($delete && !method_exists($this, $deleteMethod)) throw new Exception('The [upload] component delete method [' . $deleteMethod . '] does not exist in [' . get_class($this) . '].');
    $property = $bind($attributes, null, $livewire)[0];
    $personalize = $classes();
    $value = $this->{$property};
@endphp

<div x-data="tallstackui_formUpload(
        @js($this->getId()),
        @js($property),
        @js($multiple),
        @js($error),
        @js(__('tallstack-ui::messages.upload.placeholder')),
        @js(__('tallstack-ui::messages.upload.uploaded')))"
     x-ref="wrapper"
     x-cloak
     x-on:livewire-upload-start="uploading = true"
     x-on:livewire-upload-finish="uploading = false"
     x-on:livewire-upload-error="uploading = false"
     x-on:livewire-upload-progress="progress = $event.detail.progress"
     @class(['relative rounded-md'])>
     <x-input :value="__('tallstack-ui::messages.upload.placeholder')"
              :$label
              :$hint
              x-on:click="show = !show"
              x-ref="input"
              readonly
              icon="arrow-up-tray"
              class="cursor-pointer"
              position="right"
              dusk="tallstackui_upload_input"
              invalidate />
    @if ($preview)
        <div x-show="preview" 
             x-on:click="preview = false; show = true"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @class($personalize['preview.backdrop'])
             dusk="tallstackui_file_preview_backdrop">
             <div @class($personalize['preview.wrapper'])>
                <button @class($personalize['preview.button.wrapper']) x-on:click="preview = false; show = true">
                    <x-dynamic-component :component="TallStackUi::component('icon')"
                                         icon="x-mark"
                                         :class="$personalize['preview.button.icon']" />
                </button>
                <img x-bind:src="image" @class($personalize['preview.image'])>
            </div>
        </div>
    @endif
    <div x-cloak
         x-show="show"
         x-on:click.away="show = false"
         x-transition:enter="transition duration-100 ease-out"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-anchor.bottom-end="$refs.wrapper"
         @class($personalize['box.wrapper.first'])>
        <div @class($personalize['box.wrapper.second'])>
            <div @class(['flex flex-col w-full items-center justify-center', 'mb-2' => $footer->isNotEmpty()])>
                <div @class($personalize['placeholder.wrapper']) :class="{ 'bg-primary-100': dragging }">
                    <div class="inline-flex items-center justify-center space-x-2">
                        <x-dynamic-component :component="TallStackUi::component('icon')"
                                             icon="{{ $personalize['placeholder.icon.icon'] }}"
                                             @class($personalize['placeholder.icon.class']) />
                        <p @class($personalize['placeholder.title'])>
                            {{ __('tallstack-ui::messages.upload.upload') }}
                        </p>
                    </div>
                    @if (is_string($tip))
                        <p @class($personalize['placeholder.tip'])>{{ $tip }}</p>
                    @else
                        {{ $tip }}
                    @endif
                    <input id="{{ $property }}"
                           type="file"
                           dusk="tallstackui_file_select"
                           @if (!app()->runningUnitTests()) @class($personalize['placeholder.input']) @endif
                           x-ref="files"
                           {{ $attributes->only(['accept', 'x-on:upload']) }}
                           x-on:change="upload()"
                           x-on:dragover="dragging = true"
                           x-on:dragleave="dragging = false"
                           x-on:drop="dragging = false;"
                           @if ($multiple) multiple @endif />
                </div>
            </div>
            <div @class([$personalize['error.wrapper'], 'mb-2' => $footer->isNotEmpty()]) x-show="@js($error) && error">
                <p @class($personalize['error.message']) x-text="warning"></p>
            </div>
            <div x-show="uploading"
                 role="progressbar"
                 @class([$personalize['upload.wrapper'], 'mb-2' => $footer->isNotEmpty()])>
                <div @class($personalize['upload.progress']) x-bind:style="'width: ' + progress + '%'"></div>
            </div>
            @if ($value)
                <div @class($personalize['item.wrapper']) x-ref="items">
                    @php /** @var \Illuminate\Http\UploadedFile $file */ @endphp
                    <ul role="list" @class($personalize['item.ul'])>
                        @foreach(\Illuminate\Support\Arr::wrap($value) as $key => $file)
                            <li @class([$personalize['item.li'], 'py-2' => is_array($value) && count($value) > 1])>
                                <div class="flex min-w-0 gap-x-4">
                                    @if (in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ $file->temporaryUrl() }}"
                                         dusk="tallstackui_file_preview"
                                         @if ($preview) x-on:click="image = @js($file->temporaryUrl()); preview = true; show = false" @endif
                                         @class([$personalize['item.image'], 'cursor-pointer' => $preview])>
                                    @else
                                        <x-dynamic-component :component="TallStackUi::component('icon')"
                                                             icon="document-text"
                                                             :class="$personalize['item.document']" />
                                    @endif
                                    <div class="min-w-0 flex-auto">
                                        <p @class($personalize['item.title'])>{{ $file->getClientOriginalName() }}</p>
                                        <x-dynamic-component :component="TallStackUi::component('error')"
                                                             :property="is_array($value) ? $property . '.' . $key : $property" />
                                        @if (class_exists(\Illuminate\Support\Number::class))
                                            <p @class($personalize['item.size'])>
                                                <span>{{ __('tallstack-ui::messages.upload.size') }}: </span>
                                                <span>{{ \Illuminate\Support\Number::fileSize($file->getSize()) }}</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex shrink-0 flex-col items-end">
                                    @if ($delete)
                                        <button type="button"
                                                {{ $attributes->only('x-on:remove') }}
                                                x-on:click="remove(@js($deleteMethod), @js($file->getClientOriginalName()), @js($file->getFilename()))">
                                            <x-dynamic-component :component="TallStackUi::component('icon')"
                                                                 icon="trash"
                                                                 @class($personalize['item.delete']) />
                                        </button>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($footer->isNotEmpty())
                @unless ($footer->attributes->has('when-uploaded') && !$value)
                    {{ $footer }}
                @endunless
            @endif
        </div>
    </div>
</div>