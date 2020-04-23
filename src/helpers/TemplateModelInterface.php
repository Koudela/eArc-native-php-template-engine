<?php declare(strict_types=1);

namespace eArc\NativePHPTemplateEngine\helpers;

use eArc\NativePHPTemplateEngine\AbstractTemplateModel;

interface TemplateModelInterface
{
    /**
     * @param string|null $fQCN The fully qualified class name of the template or
     * null to let the method guess the template.

     * @return AbstractTemplateModel An instance of the data template model from
     * the implementing object.
     */
    public function getTemplate(?string $fQCN = null);
}
