<?php
/**
 * File containing the DefaultController class part of the BcKnockoutJSBundle package.
 *
 * @copyright Copyright (C) Brookins Consulting. All rights reserved.
 * @license For full copyright and license information view LICENSE and COPYRIGHT.md file distributed with this source code.
 * @version //autogentag//
 */

namespace BrookinsConsulting\BcKnockoutJSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use BrookinsConsulting\BcKnockoutJSBundle\Form\OrderType;

/**
 * @Route("/ko")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $order = $em->getRepository('Padam87BaseBundle:Order')->findOneBy(array());

        $form = $this->createForm(new OrderType(), $order);

        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bindRequest($this->getRequest());

            $order = $form->getData();

            $em->persist($order);
            $em->flush();

            return $this->redirect($this->generateUrl("bcknockoutjs_default_index"));
        }

        return array(
            'form' => $form->createView()
        );
    }
}
