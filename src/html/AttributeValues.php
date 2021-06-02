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
use Generator;
use IteratorAggregate;

class AttributeValues extends AbstractTemplateModel implements IteratorAggregate
{
    /** @var array<string> */
    public array $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    protected function template(): void
    {
        echo implode(' ', $this->values);
    }

    public function getIterator(): Generator
    {
        foreach ($this->values as $key => $value) {
            yield $key => $value;
        }
    }
}
