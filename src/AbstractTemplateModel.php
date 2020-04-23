<?php declare(strict_types=1);

namespace eArc\NativePHPTemplateEngine;

abstract class AbstractTemplateModel
{
    public function __toString(): string
    {
        ob_start();
        $this->template();
        $markup = ob_get_contents();
        ob_end_clean();

        return $markup;
    }

    abstract protected function template(): void;
}
