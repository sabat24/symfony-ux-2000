<?php

declare(strict_types=1);

namespace App\CourseMeeting\FormType;

use App\CourseMeeting\Dto\CourseMeetingDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CourseMeetingChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'choices' => static fn(Options $options): iterable => $options['course_meetings'],
                'choice_value' => 'variantCode',
                'choice_label' => static fn(CourseMeetingDto $courseMeeting): string =>
                    $courseMeeting->getRealizationDateFormatted(),
                'choice_attr' => static fn(CourseMeetingDto $courseMeeting): array => [
                    'data-placeName' => $courseMeeting->placeName,
                    'data-consultantId' => $courseMeeting->consultantId,
                ],
                'choice_translation_domain' => false,
                'multiple' => false,
                'expanded' => true,
            ])
            ->setRequired(['course_meetings'])
            ->setAllowedTypes('course_meetings', CourseMeetingDto::class . '[]');
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
