<?php

use FinalGene\ZfHalHydratorModule\Hydrator\HalEntityHydratorFactory;

return [
    'hydrators' => [
        'factories' => [
            'FinalGene\ZfHalHydratorModule\Hydrator\HalEntityHydrator' => HalEntityHydratorFactory::class,
        ],
    ],
];
