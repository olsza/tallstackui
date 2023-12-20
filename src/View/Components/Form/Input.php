<?php

namespace TallStackUi\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use TallStackUi\Foundation\Attributes\SkipDebug;
use TallStackUi\Foundation\Attributes\SoftPersonalization;
use TallStackUi\Foundation\Personalization\Contracts\Personalization;
use TallStackUi\View\Components\BaseComponent;
use TallStackUi\View\Components\Form\Traits\DefaultInputClasses;
use TallStackUi\View\Components\Form\Traits\DetermineInputId;

#[SoftPersonalization('form.input')]
class Input extends BaseComponent implements Personalization
{
    use DefaultInputClasses;
    use DetermineInputId;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?string $icon = null,
        #[SkipDebug]
        public ?string $position = 'left',
        public ?string $prefix = null,
        public ?string $suffix = null,
        public ?bool $invalidate = null,
    ) {
        $this->position = $this->position === 'left' ? 'left' : 'right';
    }

    public function blade(): View
    {
        return view('tallstack-ui::components.form.input');
    }

    public function personalization(): array
    {
        return Arr::dot([
            'input' => [
                'class' => [...$this->input()],
                'paddings' => [
                    'left' => 'pl-10',
                    'right' => 'pr-10',
                ],
            ],
            'icon' => [
                'wrapper' => 'pointer-events-none absolute inset-y-0 flex items-center text-secondary-500 dark:text-dark-400',
                'paddings' => [
                    'left' => 'left-0 pl-3',
                    'right' => 'right-0 pr-3',
                ],
                'size' => 'h-5 w-5',
                'color' => 'text-gray-500 dark:text-dark-400',
            ],
            'error' => $this->error(),
        ]);
    }
}
