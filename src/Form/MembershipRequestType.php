<?php

namespace AppBundle\Form;

use AppBundle\Membership\MembershipRequest;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembershipRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', GenderType::class)
            ->add('firstName', TextType::class, [
                'filter_emojis' => true,
            ])
            ->add('lastName', TextType::class, [
                'filter_emojis' => true,
            ])
            ->add('emailAddress', EmailType::class)
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'choice',
                'years' => $options['years'],
                'placeholder' => [
                    'year' => 'AAAA',
                    'month' => 'MM',
                    'day' => 'JJ',
                ],
            ])
            ->add('position', ActivityPositionType::class)
            ->add('address', AddressType::class)
            ->add('phone', PhoneNumberType::class, [
                'required' => false,
                'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
            ])
            ->add('conditions', CheckboxType::class, [
                'required' => false,
            ])
            ->add('comMobile', CheckboxType::class, [
                'required' => false,
            ])
            ->add('comEmail', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $years = range((int) date('Y') - 15, (int) date('Y') - 120);

        $resolver->setDefaults([
            'data_class' => MembershipRequest::class,
            'translation_domain' => false,
            'validation_groups' => ['Default', 'Registration'],
            'years' => array_combine($years, $years),
        ]);
    }
}
