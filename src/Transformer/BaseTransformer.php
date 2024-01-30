<?php

declare(strict_types=1);

namespace App\Transformer;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class BaseTransformer
{
    private PropertyAccessor $accessor;

    public function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function convertEntityToDto(mixed $entity, mixed $dto): mixed
    {
        foreach($dto as $property => $value){
            if (!$this->accessor->isReadable($entity, $property) || !$this->accessor->isWritable($dto, $property)) {
                continue;
            }

            $value2 = $this->accessor->getValue($entity, $property);
            $this->accessor->setValue($dto, $property, $value2);
        }

        return $dto;
    }
}
