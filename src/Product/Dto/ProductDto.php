<?php

declare(strict_types=1);

namespace App\Product\Dto;

use App\CourseMeeting\Dto\CourseMeetingDto;

final class ProductDto
{
    /**
     * @param CourseMeetingDto[] $courseMeetings
     */
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $additionalDescription,
        public readonly ?string $listDescription,
        public readonly string $imageUrl,
        public readonly int $imageWidth,
        public readonly int $imageHeight,
        public readonly ?string $videoUrl,
        public readonly ?string $videoPreviewImageUrl,
        public readonly string $slug,
        public readonly int $defaultConsultantId = 0,
        public readonly array $courseMeetings = [],
        public readonly ?string $announcementText = null,
    ) {
    }
}
