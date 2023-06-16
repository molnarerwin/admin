<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'hover' => true,
        'columns' => [
            'name' => [
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.name',
                        'url' => [
                            'route' => 'vanilo.admin.shipping-method.show',
                            'parameters' => ['$model']
                        ],
                        'onlyIfCan' => 'view shipping methods',
                    ],
                    'secondary' => [
                        'text' => '$model.getCarrier().name()',
                        'url' => [
                            'route' => 'vanilo.admin.carrier.show',
                            'parameters' => ['$model.carrier'],
                        ],
                        'onlyIfCan' => 'view carriers',
                    ],
                ],
                'title' => __('Name'),
            ],
            'zone' => [
                'title' => __('Zone'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['info', 'secondary']],
                    'text' => '$model.zone.name',
                    'modifier' => sprintf('text_if_empty:%s', __('Unrestricted'))
                ]
            ],
            'calculator' => [
                'title' => __('Calculator'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.getCalculator().getName()',
                ],
            ],
            'is_active' => [
                'title' => __('Status'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_active',
                    'modifier' => sprintf('bool2text:%s,%s', __('active'), __('inactive'))
                ]
            ],
            'created_at' => [
                'valign' => 'middle',
                'type' => 'show_datetime',
                'title' => __('Created'),
            ],
        ]
    ]
];