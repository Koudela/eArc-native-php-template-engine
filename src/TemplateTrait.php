<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * template component
 *
 * @package earc/native-php-template-engine
 * @link https://github.com/Koudela/eArc-native-php-template-engine
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\NativePHPTemplateEngine;

trait TemplateTrait
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
