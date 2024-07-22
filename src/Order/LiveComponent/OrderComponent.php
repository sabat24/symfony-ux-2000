<?php

declare(strict_types=1);

namespace App\Order\LiveComponent;

use App\CourseMeeting\Dto\CourseMeetingDto;
use App\Order\FormType\OrderType;
use App\Product\Provider\ProductProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsLiveComponent(
    'order',
    'component/order.html.twig',
)]
final class OrderComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public function __construct(
        private readonly ProductProvider $productProvider,
    ) {
    }

    /** @var CourseMeetingDto[] $courseMeetings */
    #[LiveProp(writable: true, hydrateWith: 'hydrateCourseMeetings', dehydrateWith: 'dehydrateCourseMeetings')]
    public array $courseMeetings;

    #[PreMount(1)]
    public function setProperties(array $data): array
    {
        $product = $this->productProvider->getProduct();
        $data['courseMeetings'] = $product->courseMeetings;

        return $data;
    }

    /**
     * @param array<string, string|string[]> $data
     * @return array<string, string|string[]>
     */
    #[PreMount]
    public function configureProperties(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['courseMeetings',]);

        return $resolver->resolve($data);
    }

    /**
     * @param array<array{id: int, variantCode: string, realizationDate: array{date: string}, placeName: string,
     *                             earlyClubMembershipPrice: int, clubMembershipPrice: int,
     *                             earlyNonClubMembershipPrice: int, nonClubMembershipPrice: int, consultantId:
     *                             int|null}> $data
     * @return CourseMeetingDto[]
     * @throws \Exception
     */
    public function hydrateCourseMeetings(array $data): array
    {
        $courseMeetings = [];
        foreach ($data as $courseMeeting) {
            $courseMeetingDto = new CourseMeetingDto();
            $courseMeetingDto->id = $courseMeeting['id'];
            $courseMeetingDto->variantCode = $courseMeeting['variantCode'];
            $courseMeetingDto->realizationDate = new \DateTime($courseMeeting['realizationDate']['date']);
            $courseMeetingDto->placeName = $courseMeeting['placeName'];
            $courseMeetingDto->earlyClubMembershipPrice = $courseMeeting['earlyClubMembershipPrice'];
            $courseMeetingDto->clubMembershipPrice = $courseMeeting['clubMembershipPrice'];
            $courseMeetingDto->earlyNonClubMembershipPrice = $courseMeeting['earlyNonClubMembershipPrice'];
            $courseMeetingDto->nonClubMembershipPrice = $courseMeeting['nonClubMembershipPrice'];
            $courseMeetingDto->consultantId = $courseMeeting['consultantId'];
            $courseMeetings[] = $courseMeetingDto;
        }

        return $courseMeetings;
    }

    /**
     * @param CourseMeetingDto[] $data
     * @return array<array{id: int, variantCode: string, realizationDate: array{date: string}, placeName: string,
     *                         earlyClubMembershipPrice: string|null, clubMembershipPrice: string|null,
     *                         earlyNonClubMembershipPrice: string|null, nonClubMembershipPrice: string|null,
     *                         consultantId: int|null}>
     */
    public function dehydrateCourseMeetings(array $data): array
    {
        $courseMeetings = [];
        foreach ($data as $courseMeeting) {
            /** @var array{id: int, variantCode: string, realizationDate: array{date: string}, placeName: string, earlyClubMembershipPrice: string|null, clubMembershipPrice: string|null, earlyNonClubMembershipPrice: string|null, nonClubMembershipPrice: string|null, consultantId: int|null} $courseMeetingArray */
            $courseMeetingArray = (array) $courseMeeting;
            $courseMeetings[] = $courseMeetingArray;
        }

        return $courseMeetings;
    }

    protected function instantiateForm(): FormInterface
    {
        $currentData = [
            'courseMeeting' => empty($this->courseMeetings) ? [] : current($this->courseMeetings),
        ];

        return $this->createForm(OrderType::class, $currentData, ['course_meetings' => $this->courseMeetings]);
    }
}
