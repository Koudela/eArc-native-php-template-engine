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

namespace eArc\NativePHPTemplateEngine\helpers\html\select;

use eArc\NativePHPTemplateEngine\IteratorTemplateModel;

class OptionTemplateModel extends IteratorTemplateModel
{
    /** @var callable|string */
    protected $contentGetter;
    /** @var callable|string|null */
    protected $valueGetter;
    /** @var callable|string|null */
    protected $selectedGetter;
    /** @var callable|string|null */
    protected $disabledGetter;
    /** @var FirstOption */
    protected $firstOption;

    public function __construct(iterable $iterable, $contentGetter, $valueGetter = null, $selectedGetter = null, $disabledGetter = null, ?FirstOption $firstOption = null)
    {
        $this->contentGetter = $contentGetter;
        $this->valueGetter = $valueGetter;
        $this->selectedGetter = $selectedGetter;
        $this->disabledGetter = $disabledGetter;
        $this->firstOption = $firstOption;

        parent::__construct($iterable);
    }

    protected function template(): void
    {
        echo $this->firstOption;

        foreach ($this->iterable as $option) {
            echo '<option'.
                    $this->getValue($option).
                    ($this->isSelected($option) ? ' selected="selected"' : '').
                    ($this->isDisabled($option) ? ' disabled="disabled"' : '').
                '>'.$this->getContent($option).'</option>';
        }
    }

    protected function getContent($option): string
    {
        if (is_callable($this->contentGetter)) {
            return call_user_func($this->contentGetter, $option);
        }

        return call_user_func([$option, $this->contentGetter]);
    }

    protected function getValue($option): string
    {
        if (null === $this->valueGetter) {
            return '';
        }

        $value = is_callable($this->valueGetter) ? call_user_func($this->valueGetter) : call_user_func([$option, $this->valueGetter]);

        return ' value="'.$value.'"';
    }

    protected function isSelected($option): bool
    {
        if (null === $this->selectedGetter) {
            return false;
        }

        if (is_callable($this->selectedGetter)) {
            return call_user_func($this->selectedGetter, $option);
        }

        $callable = [$option, $this->selectedGetter];

        return is_callable($callable) && call_user_func($callable);
    }

    protected function isDisabled($option): bool
    {
        if (null === $this->disabledGetter) {
            return false;
        }

        if (is_callable($this->disabledGetter)) {
            return call_user_func($this->disabledGetter, $option);
        }

        $callable = [$option, $this->disabledGetter];

        return is_callable($callable) && call_user_func($callable);
    }
}
