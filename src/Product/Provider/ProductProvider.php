<?php

declare(strict_types=1);

namespace App\Product\Provider;

use App\Product\Dto\ProductDto;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class ProductProvider
{
    public function __construct(
        protected readonly SerializerInterface $serializer,
    ) {
    }

    public function getProduct(): ProductDto
    {
        $productData = file_get_contents('../data/mock-product.json');

        /** @var ProductDto $deserializedResponse */
        $deserializedResponse = $this->serializer->deserialize(
            $productData,
            ProductDto::class,
            JsonEncoder::FORMAT,
            ['product:item:read'],
        );

        return $deserializedResponse;
    }
}
