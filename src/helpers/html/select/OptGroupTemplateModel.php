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

namespace eArc\NativePHPTemplateEngine\helpers\html\select;

use eArc\NativePHPTemplateEngine\IteratorTemplateModel;

class OptGroupTemplateModel extends IteratorTemplateModel
{
    /** @var callable|string */
    protected $optionsGetter;
    /** @var callable|string */
    protected $labelGetter;
    /** @var callable|string|null */
    protected $disabledGetter;
    /** @var callable|string */
    protected $optionContentGetter;
    /** @var callable|string|null */
    protected $optionValueGetter;
    /** @var callable|string|null */
    protected $optionSelectedGetter;
    /** @var callable|string|null */
    protected $optionDisabledGetter;
    /** @var FirstOption */
    protected $firstOption;

    public function __construct(iterable $iterable, $optionsGetter, $labelGetter, $disabledGetter, $optionContentGetter, $optionValueGetter = null, $optionSelectedGetter = null, $optionDisabledGetter = null, ?FirstOption $firstOption = null)
    {
        $this->optionsGetter = $optionsGetter;
        $this->labelGetter = $labelGetter;
        $this->disabledGetter = $disabledGetter;
        $this->optionContentGetter = $optionContentGetter;
        $this->optionValueGetter = $optionValueGetter;
        $this->optionSelectedGetter = $optionSelectedGetter;
        $this->optionDisabledGetter = $optionDisabledGetter;
        $this->firstOption = $firstOption;

        parent::__construct($iterable);
    }

    protected function template(): void
    {
        echo $this->firstOption;

        foreach ($this->iterable as $optGroup) {
            echo '<optgroup label="'.$this->getLabel($optGroup).'"'.
                        ($this->isDisabled($optGroup) ? ' disabled="disabled"' : '').
                '>';
            echo new OptionTemplateModel($this->getOptions($optGroup), $this->optionContentGetter, $this->optionValueGetter, $this->optionSelectedGetter, $this->optionDisabledGetter);
            echo '</optgroup>';
        }
    }

    protected function getLabel($optGroup): string
    {
        if (is_callable($this->labelGetter)) {
            return call_user_func($this->labelGetter, $optGroup);
        }

        return call_user_func([$optGroup, $this->labelGetter]);
    }

    protected function isDisabled($optGroup): bool
    {
        if (null === $this->disabledGetter) {
            return false;
        }

        if (is_callable($this->disabledGetter)) {
            return call_user_func($this->disabledGetter, $optGroup);
        }

        $callable = [$optGroup, $this->disabledGetter];

        return is_callable($callable) && call_user_func($callable);
    }

    protected function getOptions($optGroup): iterable
    {
        if (is_callable($this->optionsGetter)) {
            return call_user_func($this->optionsGetter, $optGroup);
        }

        return call_user_func([$optGroup, $this->optionsGetter]);
    }
}
