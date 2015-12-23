<?php

use FinalGene\ZfHalHydratorModule\Options\ModuleOptions;
use FinalGene\ZfHalHydratorModule\Options\ModuleOptionsFactory;

return [
    'service_manager' => [
        'factories' => [
            ModuleOptions::class => ModuleOptionsFactory::class,
        ],
    ],
];
