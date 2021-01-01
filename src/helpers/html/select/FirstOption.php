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

use eArc\NativePHPTemplateEngine\AbstractTemplateModel;

class FirstOption extends AbstractTemplateModel
{
    /** @var string */
    protected $content;
    /** @var string|null */
    protected $value;
    /** @var bool */
    protected $selected;
    /** @var bool */
    protected $disabled;

    public function __construct(string $content, ?string $value = null, bool $selected = true, bool $disabled = false)
    {
        $this->content = $content;
        $this->value = $value;
        $this->selected = $selected;
        $this->disabled = $disabled;
    }

    protected function template(): void
    { ?>
        <option<?=
        ($this->value ? ' value="'.$this->value.'"' : '').
        ($this->selected ? ' selected="selected"' : '').
        ($this->disabled ? ' disabled="disabled"' : '')
        ?>><?= $this->content ?></option>
    <?php }
}
