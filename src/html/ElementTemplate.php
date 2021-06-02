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
use eArc\NativePHPTemplateEngine\IteratorTemplateModel;
use eArc\NativePHPTemplateEngine\TemplateInterface;

class ElementTemplate extends AbstractTemplateModel
{
    public string $name;
    public string|Attributes $attributes;
    public string|TemplateInterface|null $content;

    /** @param string|iterable<string,string|string,TemplateInterface|Attribute>|Attributes $attributes */
    public function __construct(string $name, string|iterable|Attributes $attributes, string|iterable|TemplateInterface $content = '')
    {
        $this->name = $name;
        $this->attributes = is_iterable($attributes) ? new Attributes($attributes) : $attributes;
        $this->content = is_iterable($content) ? new IteratorTemplateModel($content) : $content;
    }

    protected function template(): void
    {
        if ('' !== $this->content) {
            echo "<{$this->name}{$this->attributes}>{$this->content}</{$this->name}>";
        } else {
            echo "<{$this->name}{$this->attributes} />";
        }
    }
}
