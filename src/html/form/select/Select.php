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

namespace eArc\NativePHPTemplateEngine\html\form\select;

use eArc\NativePHPTemplateEngine\html\Attributes;
use eArc\NativePHPTemplateEngine\html\ElementTemplate;

class Select extends ElementTemplate
{
    /** @param string|iterable<Option|OptGroup|string> $options */
    public function __construct(string|array|Attributes $attributes, string|iterable $options)
    {
        parent::__construct('select', $attributes, $options);
    }
}
