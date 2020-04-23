<?php declare(strict_types=1);

namespace eArc\NativePHPTemplateEngine\helpers\html\common;

use eArc\NativePHPTemplateEngine\IteratorTemplateModel;

class Attributes extends IteratorTemplateModel
{
    /** @var string|null */
    protected $nameGetter;
    /** @var string|null */
    protected $valueGetter;

    public function __construct(iterable $collection, ?string $nameGetter = null, ?string $valueGetter = null)
    {
        $this->nameGetter = $nameGetter;
        $this->valueGetter = $valueGetter;

        parent::__construct($collection);
    }

    protected function template(): void
    {
        foreach ($this->iterable as $name => $attribute) {
            echo ' '.(!$this->nameGetter ? $name : call_user_func([$attribute, $this->nameGetter])).
                '=\''.(!$this->valueGetter ? $attribute : call_user_func([$attribute, $this->valueGetter])).'\'';
        }
    }
}
