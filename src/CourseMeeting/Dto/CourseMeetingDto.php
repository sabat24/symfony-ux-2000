<?php

declare(strict_types=1);

namespace App\CourseMeeting\Dto;

use Webmozart\Assert\Assert;

final class CourseMeetingDto
{
    public int $id;
    public string $variantCode;
    public \DateTime $realizationDate;
    public string $placeName;
    public int $earlyClubMembershipPrice;
    public int $clubMembershipPrice;
    public int $earlyNonClubMembershipPrice;
    public int $nonClubMembershipPrice;
    public ?int $consultantId;

    public function getRealizationDateFormatted(): string
    {
        $dateFormatter = new \IntlDateFormatter(
            'en_GB',
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            pattern: 'd MMMM y, H:mm',
        );

        $dateFormatted = $dateFormatter->format($this->realizationDate);
        Assert::string($dateFormatted);

        return $dateFormatted;
    }
}
