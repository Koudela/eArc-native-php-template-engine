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

use Generator;
use IteratorAggregate;

class IteratorTemplateModel extends AbstractTemplateModel implements IteratorAggregate
{
    /** @var iterable<string|TemplateInterface> */
    public iterable $iterable = [];

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

    public function getIterator(): Generator
    {
        foreach ($this->iterable as $key => $template) {
            yield $key => $template;
        }
    }
}
