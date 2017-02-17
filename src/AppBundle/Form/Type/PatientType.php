<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use AppBundle\Entity\Patient;

class PatientType extends AbstractType
{
    const FORM_NAME = 'patient';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Full name: '
                ]
            )
            ->add(
                'gender',
                ChoiceType::class,
                [
                    'choices' => [
                        Patient::GENDER_MALE => 'Male',
                        Patient::GENDER_FEMALE => 'Female',
                        Patient::GENDER_OTHER => 'Other'
                    ]
                ]
            )
            ->add(
                'dob',
                BirthdayType::class,
                [
                    'label' => 'Date of birth: '
                ]
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::FORM_NAME;
    }
}
