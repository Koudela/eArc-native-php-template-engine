<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * template component
 *
 * @package earc/native-php-template-engine
 * @link https://github.com/Koudela/eArc-native-php-template-engine
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\NativePHPTemplateEngine;

interface TemplateModelInterface
{
    /**
     * @param class-string|null $fQCN The fully qualified class name of the template
     * or null to let the method guess the template.

     * @return TemplateInterface An instance of the data template model from
     * the implementing object.
     */
    public function getTemplate(string $fQCN = null): TemplateInterface;
}
