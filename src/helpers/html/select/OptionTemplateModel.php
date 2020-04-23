<?php declare(strict_types=1);

namespace eArc\NativePHPTemplateEngine\helpers\html\select;

use eArc\NativePHPTemplateEngine\IteratorTemplateModel;

class OptionTemplateModel extends IteratorTemplateModel
{
    /** @var string */
    protected $contentGetter;
    /** @var string|null */
    protected $valueGetter;
    /** @var string|null */
    protected $selectedGetter;
    /** @var string|null */
    protected $disabledGetter;
    /** @var FirstOption */
    protected $firstOption;

    public function __construct(iterable $iterable, string $contentGetter, ?string $valueGetter = null, ?string $selectedGetter = null, ?string $disabledGetter = null, ?FirstOption $firstOption = null)
    {
        $this->contentGetter = $contentGetter;
        $this->valueGetter = $valueGetter;
        $this->selectedGetter = $selectedGetter;
        $this->disabledGetter = $disabledGetter;
        $this->firstOption = $firstOption;

        parent::__construct($iterable);
    }

    protected function template(): void
    {
        echo $this->firstOption;

        foreach ($this->iterable as $option) {
            $contentCallable = [$option, $this->contentGetter];
            $valueCallable = [$option, $this->valueGetter];
            $selectedCallable = [$option, $this->selectedGetter];
            $disabledCallable = [$option, $this->disabledGetter];

            echo '<option'.
                    (is_callable($valueCallable) ? ' value="'.call_user_func($valueCallable).'"' : '').
                    (is_callable($selectedCallable) && call_user_func($selectedCallable) ? ' selected="selected"' : '').
                    (is_callable($disabledCallable) && call_user_func($disabledCallable) ? ' disabled="disabled"' : '').
                '>'.call_user_func($contentCallable).'</option>';
        }
    }
}
