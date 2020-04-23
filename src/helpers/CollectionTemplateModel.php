<?php declare(strict_types=1);

namespace eArc\NativePHPTemplateEngine\helpers;

use eArc\NativePHPTemplateEngine\AbstractTemplateModel;
use InvalidArgumentException;

class CollectionTemplateModel extends AbstractTemplateModel
{
    /** @var iterable|AbstractTemplateModel[] */
    protected $collection = [];

    /**
     * @param iterable|AbstractTemplateModel[]|TemplateModelInterface[] $collection
     * @param array                                                     $args
     */
    public function __construct(iterable $collection, ...$args)
    {
        foreach ($collection as $key => $item) {
            $this->collection[$key] =  $this->transformItem($item, ...$args);
        }
    }

    protected function transformItem($item, ...$args) {
        if (!is_object($item) || $item instanceof AbstractTemplateModel) {
            return $item;
        }

        if ($item instanceof TemplateModelInterface) {
            return $item->getTemplate(...$args);
        }

        if (is_subclass_of($args[0], AbstractTemplateModel::class)) {
            $fQCN = $args[0];

            return new $fQCN(...array_replace($args, [$item]));
        }

        throw new InvalidArgumentException(sprintf(
            'Iterable has to have values of type `%s` or `%s` but `%s` was provided.',
            AbstractTemplateModel::class,
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
