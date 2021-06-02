# eArc-native-php-template-engine

Lightweight dependency free template component of the
[earc framework](https://github.com/Koudela/eArc-core) for an 
[SOLID](https://en.wikipedia.org/wiki/SOLID) rendering approach.

Use the power of object-oriented programming to make your templates reusable
and easy to understand.

## table of Contents

- [Install](#install)
- [bootstrap](#bootstrap)
- [configure](#configure)
- [basic usage](#basic-usage)
  - [the template](#the-template)
  - [property logic](#property-logic)
  - [rendering](#rendering)
  - [rendering JSON objects](#rendering-json-objects)
- [helpers](#helpers)  
  - [the template model interface](#the-template-model-interface)
  - [the collection template model](#the-collection-template-model)
  - [html](#html)
    - [attributes](#attributes)
    - [select](#select)
- [releases](#releases)
  - [release 0.3](#release-03)
  - [release 0.2](#release-02)
  - [release 0.1](#release-01)
  - [release 0.0](#release-00)
  
## install

```shell script
$ composer require earc/native-php-template-engine
```

## bootstrap

The earc/native-php-template-engine does not require any bootstrapping.

## configure

The earc/native-php-template-engine does not require any configuration.

## basic usage

You can render `HTML`, `XML` and any other structured or unstructured output.

### the template

Templates are simple objects extending the `AbstractTemplateModel`. All the power
of the object oriented programming can be used - even dependency injection.

The templates implement the `template` method. Everything echoed out inside this
method will be the result of rendering the template. You can take advantage of 
the fact that php treats code outside of the php tags as plain output. 

```php
use eArc\NativePHPTemplateEngine\AbstractTemplateModel;

class MyTemplate extends AbstractTemplateModel
{
    /** @var object */
    protected $object;
    /** @var int */
    public $value;
    
    public function __construct(object $object, int $value)
    {
        $this->object = $object;
        $this->value = $value;    
    }

    public function template() : void
    { ?>
        <h1>Hello World</h1>
        <p>I have found a value `<?= $this->value ?>`.</p>
        <p>May be the object with the id `<?= $this->object->getId() ?>`
            can tell me what to do with it.</p>
    <?php }
}
```

Hint: Recognise the short echoing syntax of php (`<?= .* ?>`).

Best practice is to use only properties in the `template` method that can be cast 
to a string. All logic has to be outsourced in services, entities, models, 
transformer, etc. Even `ifs` and `loops` should not be visible inside the `template`
method although they can be recognized via the underlying property.

### property logic

Even if all logic is stripped from the `template` method, three basic `operations`
have to remain inside the template model: `if`, `include` and `loop`. They are
realized via the property type:

1. **IF**: This is realized by `nullable` properties. (`null` will be cast to the 
empty string.) 

2. **INCLUDE**: Complex tree structures can be implemented by using templates within 
templates.

    ```php
    use eArc\NativePHPTemplateEngine\AbstractTemplateModel;
    
    class MyRootTemplate extends AbstractTemplateModel
    {
        /** @var AbstractTemplateModel */
        protected $head;
        /** @var AbstractTemplateModel */
        protected $body;
        
        public function __construct(AbstractTemplateModel $head, AbstractTemplateModel $body)
        {
            $this->head = $head;    
            $this->body = $body;
        }
    
        public function template() : void
        { ?><!DOCTYPE html>
    <html lang="en">
    <head>
        <title>I am fixed content.</title>
        <?= $this->head ?>
    </head>
    <body>
        <?= $this->body ?>
    </body>
        <?php }
    }
    ```

3. **LOOP**: To render a `loop` for an `iterable` inject the `iterable` into a new 
`IteratorTemplateModel` instance.

    ```php
    use eArc\NativePHPTemplateEngine\AbstractTemplateModel;
    use eArc\NativePHPTemplateEngine\IteratorTemplateModel;
    
    class MyTemplate extends AbstractTemplateModel
    {
        /** @var IteratorTemplateModel */
        protected $loop;
        
        public function __construct(iterable $iterable)
        {
            $this->loop = new IteratorTemplateModel($iterable);    
        }
    
        public function template() : void
        { ?>
            <div>
                The iterables items are cast to string on rendering:
                <?= $this->loop ?>
            </div>
        <?php }
    }
    ```

The property logic helps you to follow the single responsibility principle in 
your templates. Keeping your code clean, and your templates easy to understand.

### rendering

To render the template simply cast the template model/object to string.

```php
$template = new MyTemplate($object, $value);

$renderedTemplate = (string) $template;
```

You can echo the class directly. PHP does the cast implicitly.

```php
echo new MyTemplate($object, $value);
```

### rendering JSON objects

Sometimes you do not need the html but the data. `json_encode` transforms the
public properties. This can be used to combine two purposes in one output data
model.

```php
echo json_encode(new MyTemplate($object, $value);
```

If you like you can send them both of course.

```php
$template = new MyTemplate($object, $value);

echo json_encode(['data' => $template, 'html' => (string) $template]);
```

## helpers

To make the basic usage work the earc/native-php-template-engine uses 41 lines 
of code only. 

There may be times when you need some extra assistance for faster coding. The
earc/native-php-template-engine is shipped with a growing number of helpers.

### the template model interface

Writing templates is about enhancing data output. Complex data types are most of
the time objects - known as entities if they are persistable. Wouldn't it be nice
if they could be cast to string directly?

Using the `__toString()` method has several drawbacks:
1. It may be used for another purpose already.
2. There may exist more than one template for an object.
3. The template may need some extra information to be build.

Using the `TemplateModelInterface` provides a far more flexible way. Casting is
simple enough:

```php
(string) $entity->getTemplate();
``` 

It is a two-step casting in principle. First the entity object is cast to the related template
object. Then the template object is cast to a string.

If there is more than one template provide the templates fully qualified class
name:

```php
(string) $entity->getTemplate(MyEntityTemplate::class);
```

If the template needs some additional information to be build it should not be
build via the objects' template factory. Such a factory would go beyond the 
purpose of casting and thus violates the single responsibility principle. Use the 
traditional way:

```php
(string) new MyEntityTemplate($entity, $additionalParameter);
```

It is your responsibility to implement the `TemplateModelInterface` of course.

```php
use eArc\NativePHPTemplateEngine\helpers\TemplateModelInterface;

class SomeEntity implements TemplateModelInterface
{
    // ...
    
    public function getTemplate(?string $fQCN = null)
    {
        if (null === $fQCN) {
            return new SomeEntityDefaultTemplate($this);
        }

        return new $fQCN($this);
    }
}
```

### the collection template model

The `IteratorTemplateModel` works fine as long as the casting of the items yields
the desired result. Preprocessing would be a possibility, but it is a stupid enough
task:

```php
use eArc\NativePHPTemplateEngine\AbstractTemplateModel;
use eArc\NativePHPTemplateEngine\IteratorTemplateModel;

class MyTableTemplate extends AbstractTemplateModel
{
    // ...
    public function __construct($collection)
    {
        $tmplCollection = [];
        foreach ($collection as $entity) {
            $tmplCollection[] = new EntityDefaultTemplate($entity);
        }
        $this->collection = new IteratorTemplateModel($tmplCollection);
    }
    // ...
}
```

The `CollectionTemplateModel` does the boring part for you.

```php
    use eArc\NativePHPTemplateEngine\helpers\CollectionTemplateModel;
    // ...
    $this->collection = new CollectionTemplateModel($collection, EntityDefaultTemplate::class);
```

If the items of your Collection implement the `TemplateModelInterface` the fully
qualified class name can be dropped.

```php
     use eArc\NativePHPTemplateEngine\helpers\CollectionTemplateModel;
    // ...
    $this->collection = new CollectionTemplateModel($collection);
```

Even arguments can be passed to the templates constructors.

```php
     use eArc\NativePHPTemplateEngine\helpers\CollectionTemplateModel;
    // ...

    // calls internally: new EntityDefaultTemplate($collectionItem, $some, $arguments)
    $this->collection = new CollectionTemplateModel($collection, EntityDefaultTemplate::class, $some, $arguments);

    //...
    
```

### html 
#### attributes
#### select

## releases

### release 1.0

- PHP ^8.0 only
- simplification of api
- access level public for rendered properties
- constructor of `IteratorTemplateModel` accepts `iterable<string|TemplateInterface>`
- general html element template

### release 0.3

- support for PHP ^8.0

### release 0.2

- added `callable` type to arguments for `OptionTemplateModel` and `OptGroupTemplateModel`

### release 0.1

- added `TemplateInterface` and `TemplateTrait`

### release 0.0

- initial release
