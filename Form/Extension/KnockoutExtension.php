<?php
/**
 * File containing the KnockoutType class part of the BcKnockoutJSBundle package.
 *
 * @copyright Copyright (C) Brookins Consulting. All rights reserved.
 * @license For full copyright and license information view LICENSE and COPYRIGHT.md file distributed with this source code.
 * @version //autogentag//
 */

namespace BrookinsConsulting\BcKnockoutJSBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;
use Doctrine\Common\Collections\Collection;

/**
 * @Service("form.type_extension.knockout")
 * @Tag("form.type_extension", attributes = {"alias" = "form", "extended_type" = "Symfony\Component\Form\Extension\Core\Type\FormType"})
 */
class KnockoutExtension extends AbstractTypeExtension
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $knockout = array(
            'name' => $form->getName(),
            'fields' => $this->buildViewModelFields($form->getChildren()),
            'bindings' => $this->buildViewModelBindings($form->getChildren()),
            'collections' => $this->getCollections($form->getChildren(), $view),
        );

        $view->set('knockout', $knockout);
    }

    protected function buildViewModelFields(array $children)
    {
        $fields = array();

        foreach ($children as $field) {
            $name = $field->getName();
            $data = $field->getData();

            if($name === '_token') continue;

            if ($field->hasChildren() || $data instanceof Collection) {
                $fields[$name] = $this->buildViewModelFields($field->getChildren());

                if (is_object($data) && !$data instanceof Collection) { // if entity
                    $fields[$name]['id'] = $data->getId();
                }
            } else {
                if ($data instanceof \DateTime) {
                    $data = $data->format('Y-m-d H:i:s');
                }

                if (is_object($data)) {
                     $data = $data->getId();
                }

                $fields[$name] = $data === NULL ? "" : $data;
            }
        }

        return $fields;
    }

    protected function buildViewModelBindings(array $children, $pre = "")
    {
        $bindings = array();

        foreach ($children as $field) {
            if($field->getName() === '_token') continue;

            if ($field->getConfig()->getType()->getInnerType()->getName() == 'knockout') {
                 // TODO
            } else {
                if ($field->hasChildren()) {
                    $newPre = empty($pre) ? $field->getName() : $pre . '.' . $field->getName();

                    foreach ($this->buildViewModelBindings($field->getChildren(), $newPre) as $k => $binding) {
                        $bindings[$k] = $binding;
                    }
                } else {
                    if (empty($pre)) {
                        $bindings[$field->getName()] = "value: " . $field->getName();
                    } else {
                        $bindings[str_replace(".", "_", $pre) . '_' . $field->getName()] = "value: " . $pre . '.' . $field->getName();
                    }
                }
            }
        }

        return $bindings;
    }

    protected function getCollections(array $children, $parentView)
    {
        $collections = array();

        foreach ($children as $field) {
            if ($field->getConfig()->getType()->getInnerType()->getName() == 'knockout') {
                $prototypeData = array(
                    'id' => ""
                );

                foreach (array_keys($field->createView($parentView)->get("prototype")->getChildren()) as $name) {
                    $prototypeData[$name] = "";
                }

                $collections[$field->getName()] = $prototypeData;
            }
        }

        return $collections;
    }

    public function getDefaultOptions()
    {
        return array(
            'knockout' => false,
        );
    }

    public function getExtendedType()
    {
        return 'form';
    }
}
