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
    /** @var string */
    protected $optionsGetter;
    /** @var string */
    protected $labelGetter;
    /** @var string|null */
    protected $disabledGetter;
    /** @var string */
    protected $optionContentGetter;
    /** @var string|null */
    protected $optionValueGetter;
    /** @var string|null */
    protected $optionSelectedGetter;
    /** @var string|null */
    protected $optionDisabledGetter;
    /** @var FirstOption */
    protected $firstOption;

    public function __construct(iterable $iterable, string $optionsGetter, string $labelGetter, ?string $disabledGetter, string $optionContentGetter, ?string $optionValueGetter = null, ?string $optionSelectedGetter = null, ?string $optionDisabledGetter = null, ?FirstOption $firstOption = null)
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
            $optionsCallable = [$optGroup, $this->optionsGetter];
            $labelCallable = [$optGroup, $this->labelGetter];
            $disabledCallable = [$optGroup, $this->disabledGetter];

            echo '<optgroup label="'.call_user_func($labelCallable).'"'.
                        (is_callable($disabledCallable) && call_user_func($disabledCallable) ? ' disabled="disabled"' : '').
                '>';
            echo new OptionTemplateModel(call_user_func($optionsCallable), $this->optionContentGetter, $this->optionValueGetter, $this->optionSelectedGetter, $this->optionDisabledGetter);
            echo '</optgroup>';
        }
    }
}
