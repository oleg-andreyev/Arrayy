<?php

namespace Arrayy\tests;

use Arrayy\Collection\Collection;
use Arrayy\TypeCheck\TypeCheckArray;
use Arrayy\TypeCheck\TypeCheckInterface;
use Arrayy\TypeCheck\TypeCheckSimple;

class StdBaseClassCollection extends Collection
{
    /**
     * The type (FQCN) associated with this collection.
     *
     * @return string|string[]|TypeCheckArray|TypeCheckInterface[]
     */
    public function getType()
    {
        return TypeCheckArray::create(
            [
                new TypeCheckSimple(\stdClass::class),
            ]
        );
    }
}
