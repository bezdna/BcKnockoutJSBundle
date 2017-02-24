<?php
/**
 * File containing the GenerateCommand class part of the BcKnockoutJSBundle package.
 *
 * @copyright Copyright (C) Brookins Consulting. All rights reserved.
 * @license For full copyright and license information view LICENSE and COPYRIGHT.md file distributed with this source code.
 * @version //autogentag//
 */

namespace BrookinsConsulting\BcKnockoutJSBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('bc:bcknockoutjs:generate')
            ->setDescription('Generates a VM for the given form')
            ->addArgument('form', InputArgument::REQUIRED, 'namespaced name of the form')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kernel = $this->getApplication()->getKernel();
        $container = $kernel->getContainer();
        $formName = $input->getArgument('form');
        $form = $container->get('form.factory')->create(new $formName());
        $view = $form->createView();

        $twigKo = $container->get('twig.extension.knockout');
        $twigKo->initRuntime($container->get('twig'));

        $vM = $twigKo->createViewModel($view->vars['knockout'], false);
        $dirname = $kernel->getRootDir() . '/Resources/knockout';
        $filename = $dirname . '/' . $view->vars['name'] . '.ko.js';

        if (!is_dir($dirname)) {
            mkdir($dirname);
        }

        file_put_contents($filename, $vM);
    }
}