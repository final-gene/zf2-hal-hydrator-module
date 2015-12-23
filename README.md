# ZF-HAL-Hydrator-Module

## Introduction

This module provides a hydrator which can be used to manual map the name of REST-Entity classes to
custom keys.

## Installation

### Install the package

Run in your shell: 
```
$ composer require "final-gene/zf-hal-hydrator-module"
```

### Load the module

Add the key `FinalGene\ZfHalHydratorModule` in your `application.config.php`

### Configure the ZF-Hal hydrator
```php
'zf-hal' => [
    'renderer' => [
        'default_hydrator' => 'FinalGene\ZfHalHydratorModule\RestEntityHydrator'
    ]
],
```
Or configure the hydrator for specific class types via the `metadata_map` key ([documentation](https://github.com/zfcampus/zf-hal#key-metadata_map)) (sub-key `hydrator`).
Look at the documentation of zf-hal for further details.

## Configuration

### User Configuration

The top-level key used to configure this module is `zf-hal-hydrator-module`.

#### Key: `map`

An array of class names (key) and their intended name in the output (value).

#### User configuration example:

```php
'map' => [
    'FinalGene\FooModule\Rest\Entity\BarEntity' => 'final-gene:foo-bar'
]
```

### System Configuration

```php
'service_manager' => [
    'factories' => [
        'FinalGene\ZfHalHydratorModule\ModuleOptions' => 'FinalGene\ZfHalHydratorModule\Options\ModuleOptionsFactory'
    ],
],
'hydrators' => [
    'factories' => [
        'FinalGene\ZfHalHydratorModule\RestEntityHydrator' => 'FinalGene\ZfHalHydratorModule\Hydrator\HalEntityHydratorFactory'
    ],
],
```
