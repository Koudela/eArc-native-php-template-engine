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

class IteratorTemplateModel extends AbstractTemplateModel
{
    /** @var iterable|TemplateInterface[] */
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
