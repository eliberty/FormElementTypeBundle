<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MarkdownEditorType
 * responsability: overload the textarea fields and turning it into markdown editor.
 */
class MarkdownEditorType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'markdown_editor_widget',
        ]);
    }

    /**
     * @return string|\Symfony\Component\Form\FormTypeInterface|null
     */
    public function getParent()
    {
        return TextareaType::class;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'eliberty_markdown_editor';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
