<?php
/**
 * File containing the OrderType class part of the BcKnockoutJSBundle package.
 *
 * @copyright Copyright (C) Brookins Consulting. All rights reserved.
 * @license For full copyright and license information view LICENSE and COPYRIGHT.md file distributed with this source code.
 * @version //autogentag//
 */

namespace BrookinsConsulting\BcKnockoutJSBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends \Padam87\BaseBundle\Form\OrderType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('items')
            ->add('items', 'knockout', array(
                'type'         => new \Padam87\BaseBundle\Form\OrderItemType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference'  => false,
            ))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Padam87\BaseBundle\Entity\Order'
        );
    }

    public function getName()
    {
        return 'order';
    }
}
