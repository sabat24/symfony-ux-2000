<?php

declare(strict_types=1);

namespace App\Order\FormType;

use App\CourseMeeting\Dto\CourseMeetingDto;
use App\CourseMeeting\FormType\CourseMeetingChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class OrderType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (empty($options['course_meetings'])) {
            return;
        }

        $builder
            ->add('courseMeeting', CourseMeetingChoiceType::class, [
                'course_meetings' => $options['course_meetings'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired(['course_meetings'])
            ->setAllowedTypes('course_meetings', CourseMeetingDto::class . '[]');
    }
}
