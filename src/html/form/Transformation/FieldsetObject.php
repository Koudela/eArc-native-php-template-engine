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

namespace eArc\NativePHPTemplateEngine\html\form\Transformation;

use eArc\NativePHPTemplateEngine\html\Attributes;
use eArc\NativePHPTemplateEngine\html\ElementTemplate;
use eArc\NativePHPTemplateEngine\TemplateInterface;
use eArc\ParameterTransformer\Configuration;
use eArc\ParameterTransformer\Exceptions\DiException;
use eArc\ParameterTransformer\Exceptions\FactoryException;
use eArc\ParameterTransformer\Exceptions\NoInputException;
use eArc\ParameterTransformer\Exceptions\NullValueException;
use eArc\ParameterTransformer\ParameterTransformer;

class FieldsetObject extends ElementTemplate
{
    public function __construct(string|iterable|Attributes $attributes, string|iterable|TemplateInterface $content)
    {
        parent::__construct('fieldset', $attributes, $content);
    }

    /**
     * @throws DiException | FactoryException | NullValueException | NoInputException
     */
    public function transform(object $object): object
    {
        return di_get(ParameterTransformer::class)
            ->objectTransform($object, $this->getInput(), $this->getConfig());
    }

    protected function getConfig(): Configuration
    {
        return new Configuration();
    }

    protected function getInput(): array
    {
        parse_str(file_get_contents('php://input'), $values);

        return $values;
    }
}
