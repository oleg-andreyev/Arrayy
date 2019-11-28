<?php

declare(strict_types=1);

namespace Arrayy\Type;

use Arrayy\Collection\Collection;
use Arrayy\TypeCheck\TypeCheckArray;
use Arrayy\TypeCheck\TypeCheckInterface;

final class IntCollection extends Collection implements \Arrayy\Type\TypeInterface
{
    /**
     * The type (FQCN) associated with this collection.
     *
     * @return string|string[]|TypeCheckArray|TypeCheckInterface[]
     */
    public function getType()
    {
        return 'int';
    }
}
