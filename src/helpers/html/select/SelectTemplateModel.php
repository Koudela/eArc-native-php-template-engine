<?php declare(strict_types=1);

namespace eArc\NativePHPTemplateEngine\helpers\html\select;

use eArc\NativePHPTemplateEngine\AbstractTemplateModel;
use eArc\NativePHPTemplateEngine\helpers\html\common\Attributes;

class SelectTemplateModel extends AbstractTemplateModel
{
    /** @var OptionTemplateModel|OptGroupTemplateModel */
    protected $options;
    /** @var Attributes|null */
    protected $attributes;

    /**
     * @param OptionTemplateModel|OptGroupTemplateModel $options
     * @param Attributes|null                           $attributes
     */
    public function __construct($options, ?Attributes $attributes = null)
    {
        $this->options = $options;
        $this->attributes = $attributes;
    }

    protected function template(): void
    { ?>
        <select<?= $this->attributes ?>><?= $this->options ?></select>
    <?php }
}
