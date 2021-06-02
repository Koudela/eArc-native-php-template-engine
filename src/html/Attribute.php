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

namespace eArc\NativePHPTemplateEngine\html;

use eArc\NativePHPTemplateEngine\AbstractTemplateModel;

class Attribute extends AbstractTemplateModel
{
    protected string $name;
    protected string|AttributeValues $value;

    public function __construct(string $name, string|AttributeValues $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    protected function template(): void
    {
        echo " {$this->name}=\"$this->value\"";
    }
}
