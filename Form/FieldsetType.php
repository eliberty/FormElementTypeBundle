<?php
/**
 * Created by PhpStorm.
 * User: tmolin
 * Date: 03/09/15
 * Time: 16:56.
 */

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FieldsetType.
 */
class FieldsetType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'title'    => false,
            'subforms' => [],
            'options'  => [],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!empty($options['subforms'])) {
            foreach ($options['subforms'] as $f) {
                $builder->add($f['name'], $f['type'], $f['attr']);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (false !== $options['title']) {
            $view->vars['title'] = $options['title'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eliberty_fieldset';
    }
}
