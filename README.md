# BC KnockoutJS

Integrates knockout.js into Symfony2, provides automatic code generation for collections.

## 1. Example ##

    $builder
        ->add('items', 'knockout', array(
            'type'         => new OrderItemType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'prototype'    => true,
            'by_reference'  => false,
        ))
    ;

I have added the items field with the KnockoutType, which extends the CollectionType, and handled the same way as a collection.

## 2. Installation

### 2.1. Composer:

    "brookinsconsulting/bcknockoutjsbundle": "dev-master",

### 2.2. AppKernel:

    $bundles = array(
        ...
        new BrookinsConsulting\BcKnockoutJSBundle\BcKnockoutJSBundle(),
    );

### 2.3. config.yml:

    imports:
        ...
        - { resource: "@BcKnockoutJSBundle/Resources/config/config.yml" }

    # BcKockoutJS Bundle Configuration
    jms_di_extra:
        locations:
            all_bundles: false
            bundles: [BcKnockoutJSBundle]
            directories: ["%kernel.root_dir%/../src"]

jms\_di\_extra configuration is unnecessary if you have set all_bundles to true which is strongly discouraged for performance reasons by the upstream dependant bundle in question.

### 2.4. Add the js to your page.

    <script src="{{ asset('bundles/bcknockoutjs/js/knockout-2.1.0.js') }}"></script>

### 2.5. Create your view

    {{ knockout(form.vars.knockout)|raw }}
    {{ form_widget(form) }}

## 3. Dependencies

This package does infact depend upon the 'jms/di-extra-bundle' bundle.
 
For testing purposes the original author used his now private BaseBundle, if you want to test it, you have to include it in your composer.json file too.

## 4. Stuff to do

- Generator. Right now the command is there, but its not working properly.


