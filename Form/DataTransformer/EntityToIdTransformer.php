<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class EntityToIdTransformer.
 */
class EntityToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $class;

    /**
     * @param ObjectManager $objectManager
     * @param $class
     */
    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->class         = $class;
    }

    /**
     * @param mixed $entity
     *
     * @return mixed
     */
    public function transform($entity)
    {
        if (null === $entity || !\is_object($entity) || !method_exists($entity, 'getId')) {
            return;
        }

        return $entity->getId();
    }

    /**
     * @param mixed $id
     *
     * @return mixed|object|null
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $entity = $this->objectManager
            ->getRepository($this->class)
            ->find($id);

        if (null === $entity) {
            throw new TransformationFailedException();
        }

        return $entity;
    }
}
