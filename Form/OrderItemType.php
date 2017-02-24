<?php
/**
 * File containing the OrderItemType class part of the BcKnockoutJSBundle package.
 *
 * @copyright Copyright (C) Brookins Consulting. All rights reserved.
 * @license For full copyright and license information view LICENSE and COPYRIGHT.md file distributed with this source code.
 * @version //autogentag//
 */

namespace BrookinsConsulting\BcKnockoutJSBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class OrderItemType extends \Padam87\BaseBundle\Form\OrderItemType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Padam87\BaseBundle\Entity\OrderItem'
        );
    }

    public function getName()
    {
        return 'order';
    }
}
