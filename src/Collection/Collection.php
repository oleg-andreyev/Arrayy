<?php

declare(strict_types=1);

namespace Arrayy\Collection;

use Arrayy\ArrayyIterator;
use Arrayy\TypeCheck\TypeCheckArray;
use Arrayy\TypeCheck\TypeCheckInterface;

/**
 * A collection represents a group of objects.
 *
 * Each object in the collection is of a specific, defined type.
 *
 * This is a direct implementation of `CollectionSetTypeInterface`,
 * which provides a simple api for your collections.
 *
 * Example usage:
 *
 * ``` php
 * $collection = new \Arrayy\Collection\Collection(\My\FooInterface::class);
 * $collection->add(new \My\Foo());
 * $collection->add(new \My\Foo());
 *
 * foreach ($collection as $foo) {
 *     if ($foo instanceof \My\FooInterface) {
 *         // Do something with $foo
 *     }
 * }
 * ```
 *
 * It is preferable to subclass `AbstractCollection` to create your own typed
 * collections. For example:
 *
 * ``` php
 * namespace My;
 *
 * class FooCollection extends \Arrayy\Collection\AbstractCollection
 * {
 *     public function getType()
 *     {
 *         return FooInterface::class;
 *     }
 * }
 * ```
 *
 * And then use it similarly to the earlier example:
 *
 * ``` php
 * namespace My;
 *
 * $fooCollection = new \My\FooCollection();
 * $fooCollection->add(new \My\Foo());
 * $fooCollection->add(new \My\Foo());
 *
 * foreach ($fooCollection as $foo) {
 *     if ($foo instanceof \My\FooInterface) {
 *         // Do something with $foo
 *     }
 * }
 * ```
 *
 * INFO: this collection thingy is inspired by https://github.com/ramsey/collection/
 */
class Collection extends AbstractCollection
{
    /**
     * Constructs a collection object of the specified type, optionally with the
     * specified data.
     *
     * @param mixed                                    $data
     *                                                                               <p>
     *                                                                               The initial items to store in the collection.
     *                                                                               </p>
     * @param string                                   $iteratorClass                optional <p>
     *                                                                               You can overwrite the ArrayyIterator, but mostly you don't
     *                                                                               need this option.
     *                                                                               </p>
     * @param bool                                     $checkPropertiesInConstructor optional <p>
     *                                                                               You need to extend the "Arrayy"-class and you need to set
     *                                                                               the $checkPropertiesMismatchInConstructor class property
     *                                                                               to
     *                                                                               true, otherwise this option didn't not work anyway.
     *                                                                               </p>
     * @param TypeCheckArray|TypeCheckInterface[]|null $type
     */
    public function __construct(
        $data = [],
        string $iteratorClass = null,
        bool $checkPropertiesInConstructor = null,
        TypeCheckArray $type = null
    ) {
        // fallback
        if ($iteratorClass === null) {
            $iteratorClass = ArrayyIterator::class;
        }
        if ($checkPropertiesInConstructor === null) {
            $checkPropertiesInConstructor = true;
        }

        if ($type !== null) {
            $this->properties = $type;
        }

        parent::__construct(
            $data,
            $iteratorClass,
            $checkPropertiesInConstructor
        );
    }

    /**
     * @param string|TypeCheckArray|TypeCheckInterface[] $type
     * @param array                                      $data
     * @param bool                                       $checkPropertiesInConstructorAndType
     *
     * @return static
     */
    public static function construct(
        $type,
        $data = [],
        bool $checkPropertiesInConstructorAndType = true
    ): self {
        $type = self::convertIntoTypeCheckArray($type);

        return new static(
            $data,
            ArrayyIterator::class,
            $checkPropertiesInConstructorAndType,
            $type
        );
    }

    /**
     * The type (FQCN) associated with this collection.
     *
     * @return TypeCheckArray|TypeCheckInterface[]
     */
    public function getType()
    {
        return $this->properties;
    }

    /**
     * Get a base Collection instance from this Collection.
     *
     * @return self
     */
    public function toBase(): self
    {
        /** @noinspection SelfClassReferencingInspection */
        return Collection::construct($this->getType(), $this->getArray());
    }
}
