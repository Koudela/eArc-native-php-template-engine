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

namespace eArc\NativePHPTemplateEngine\helpers;

use eArc\NativePHPTemplateEngine\AbstractTemplateModel;
use eArc\NativePHPTemplateEngine\TemplateInterface;
use InvalidArgumentException;

class CollectionTemplateModel extends AbstractTemplateModel
{
    /** @var iterable|TemplateInterface[] */
    protected $collection = [];

    /**
     * @param iterable|TemplateInterface[]|TemplateModelInterface[] $collection or array of primitives
     * @param array                                                 $args
     */
    public function __construct(iterable $collection, ...$args)
    {
        foreach ($collection as $key => $item) {
            $this->collection[$key] =  $this->transformItem($item, ...$args);
        }
    }

    /**
     * @param TemplateInterface|TemplateModelInterface $item or primitive value
     * @param array                                    $args
     */
    public function addItem($item, ...$args)
    {
        $this->collection[] = $this->transformItem($item, ...$args);
    }

    protected function transformItem($item, ...$args) {
        if (!is_object($item) || $item instanceof TemplateInterface) {
            return $item;
        }

        if ($item instanceof TemplateModelInterface) {
            return $item->getTemplate(...$args);
        }

        if (is_subclass_of($args[0], TemplateInterface::class)) {
            $fQCN = $args[0];

            return new $fQCN(...array_replace($args, [$item]));
        }

        throw new InvalidArgumentException(sprintf(
            'Iterable has to have values of type `%s` or `%s` but `%s` was provided.',
            TemplateInterface::class,
            TemplateModelInterface::class,
            get_class($item)
        ));
    }

    protected function template(): void
    {
        foreach ($this->collection as $templateModel) {
            echo $templateModel;
        }
    }
}
