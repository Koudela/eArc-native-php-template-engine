<?php declare(strict_types=1);

namespace eArc\NativePHPTemplateEngine;

class IteratorTemplateModel extends AbstractTemplateModel
{
    /** @var iterable|AbstractTemplateModel[] */
    protected $iterable = [];

    public function __construct(iterable $iterable)
    {
        $this->iterable = $iterable;
    }

    protected function template(): void
    {
        foreach ($this->iterable as $template) {
            echo $template;
        }
    }
}
