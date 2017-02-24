<?php
/**
 * File containing the KnockoutExtension class part of the BcKnockoutJSBundle package.
 *
 * @copyright Copyright (C) Brookins Consulting. All rights reserved.
 * @license For full copyright and license information view LICENSE and COPYRIGHT.md file distributed with this source code.
 * @version //autogentag//
 */

namespace BrookinsConsulting\BcKnockoutJSBundle\Twig;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_Environment;

/**
 * @Service("twig.extension.knockout")
 * @Tag("twig.extension")
 */
class KnockoutExtension extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('knockout', array($this, 'createViewModel'),
                array('needs_environment' => true)),
        );
    }

    public function createViewModel(Twig_Environment $environment, $params, $script = true)
    {
        $knockout = $environment->render("BcKnockoutJSBundle::knockout.js.twig", $params);

        if ($script === true) {
            $knockout = '<script>' . $knockout . '</script>';
        }

        return $knockout;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'bc_knockout';
    }
}
