<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Eliberty\Bundle\FormElementTypeBundle\Form\DataTransformer\SkiCardTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class KeycardAlfiType.
 */
class KeycardAlfiType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $part1Options = $part2Options = $part3Options = [
            'required' => $options['required'],
            'label'    => ' - ',
        ];
        $part1Options['label_render'] = false;
        $part1Options['attr']         = ['maxlength' => 5, 'class' => 'keycard-part-part1'];
        $part2Options['attr']         = ['maxlength' => 5, 'class' => 'keycard-part-part2'];
        $part3Options['attr']         = ['maxlength' => 4, 'class' => 'keycard-part-part3'];

        $builder
            ->add('part1', 'text', $part1Options)
            ->add('part2', 'text', $part2Options)
            ->add('part3', 'text', $part3Options)
            ->addViewTransformer($this->getTransformer());
    }

    /**
     * @return SkiCardTransformer
     */
    public function getTransformer()
    {
        return new SkiCardTransformer(['part1', 'part2', 'part3']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $compound = function (Options $options) {
            return true;
        };

        $emptyValue = $emptyValueDefault = function (Options $options) {
            return $options['required'] ? null : '';
        };

        $emptyValueNormalizer = function (Options $options, $emptyValue) use ($emptyValueDefault) {
            if (\is_array($emptyValue)) {
                $default = $emptyValueDefault($options);

                return array_merge(
                    ['part1' => $default, 'part2' => $default, 'part3' => $default],
                    $emptyValue
                );
            }

            return [
                'part1' => $emptyValue,
                'part2' => $emptyValue,
                'part3' => $emptyValue,
            ];
        };

        $resolver->setDefaults(
            [
                'compound'       => $compound,
                'required'       => false,
                'empty_value'    => $emptyValue,
                'error_bubbling' => true,
                'data_class'     => null,
            ]
        );

        $resolver->setNormalizer('empty_value', $emptyValueNormalizer);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'eliberty_keycard_alfi';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
