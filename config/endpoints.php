<?php

return [
    [
        'name' => 'Search emojis',
        'description' => 'Search for emojis by keyword',
        'path' => '/search?q=party',
        'params' => [
            [
                'name' => 'q',
                'type' => 'string',
                'required' => true,
                'description' => 'Keyword to search for'
            ],
            [
                'name' => 'limit',
                'type' => 'integer',
                'required' => false,
                'description' => 'Number of results to return (maximum 50)'
            ],
            [
                'name' => 'categories',
                'type' => 'list of integers',
                'required' => false,
                'description' => 'Filter response by categories ids'
            ],
            [
                'name' => 'sub_categories',
                'type' => 'list of integers',
                'required' => false,
                'description' => 'Filter response by sub_categories ids'
            ],
            [
                'name' => 'versions',
                'type' => 'list of floats',
                'required' => false,
                'description' => 'Filter response by specifics unicode versions'
            ],
        ],
        'example' => '/search?q=party&categories=7,8,6&sub_categories=61,66,63&versions=0.6,13.0',
        'response' => [
            'total' => 4,
            'results' => [
                [
                    'id' => 1691,
                    'name' => 'party popper',
                    'emoji' => '🎉',
                    'unicode' => '1F389',
                    'version' => 0.6,
                    'category' => [
                        'id' => 7,
                        'name' => 'Activities'
                    ],
                    'sub_category' => [
                        'id' => 67,
                        'name' => 'Activities'
                    ],
                    'children' => []
                ],
                [
                    'id' => 1248,
                    'name' => 'dress',
                    'emoji' => '👗',
                    'unicode' => '1F457',
                    'version' => 0.6,
                    'category' => [
                        'id' => 8,
                        'name' => 'Objects'
                    ],
                    'sub_category' => [
                        'id' => 66,
                        'name' => 'clothing'
                    ],
                    'children' => []
                ],
                [
                    'id' => 1687,
                    'name' => 'fireworks',
                    'emoji' => '🎆',
                    'unicode' => '1F386',
                    'version' => 0.6,
                    'category' => [
                        'id' => 7,
                        'name' => 'Activities'
                    ],
                    'sub_category' => [
                        'id' => 61,
                        'name' => 'event'
                    ],
                    'children' => []
                ]
            ]
        ]
    ],
    [
        'name' => 'Random emojis',
        'description' => 'Retrieve emojis in random order',
        'path' => '/random',
        'params' => [
            [
                'name' => 'limit',
                'type' => 'integer',
                'required' => false,
                'description' => 'Number of results to return'
            ],
            [
                'name' => 'categories',
                'type' => 'List of Integers',
                'required' => false,
                'description' => 'Filter response by categories ids'
            ],
            [
                'name' => 'sub_categories',
                'type' => 'List of Integers',
                'required' => false,
                'description' => 'Filter response by sub_categories ids'
            ],
            [
                'name' => 'versions',
                'type' => 'List of Floats',
                'required' => false,
                'description' => 'Filter response by specifics versions	'
            ],
        ],
        'example' => '/random?&categories=7,8,6&sub_categories=61,66,63&versions=0.6,13.0&limit=2',
        'response' => [
            'total' => 2,
            'results' => [
                [
                    'id' => 1260,
                    'name' => 'woman’s sandal',
                    'emoji' => '👡',
                    'unicode' => '1F461',
                    'version' => 0.6,
                    'category' => [
                        'id' => 8,
                        'name' => 'Objects'
                    ],
                    'sub_category' => [
                        'id' => 66,
                        'name' => 'clothing'
                    ],
                    'children' => []
                ],
                [
                    'id' => 1686,
                    'name' => 'Christmas tree',
                    'emoji' => '🎄',
                    'unicode' => '1F384',
                    'version' => 0.6,
                    'category' => [
                        'id' => 7,
                        'name' => 'Activities'
                    ],
                    'sub_category' => [
                        'id' => 61,
                        'name' => 'event'
                    ],
                    'children' => []
                ]
            ]
        ]
    ],
    [
        'name' => 'Popular emojis',
        'description' => 'Retrieve emojis in popular order based on copy count',
        'path' => '/popular',
        'params' => [
            [
                'name' => 'limit',
                'type' => 'integer',
                'required' => false,
                'description' => 'Number of results to return'
            ],
            [
                'name' => 'categories',
                'type' => 'List of Integers',
                'required' => false,
                'description' => 'Filter response by categories ids'
            ],
            [
                'name' => 'sub_categories',
                'type' => 'List of Integers',
                'required' => false,
                'description' => 'Filter response by sub_categories ids'
            ],
            [
                'name' => 'versions',
                'type' => 'List of Floats',
                'required' => false,
                'description' => 'Filter response by specifics versions	'
            ],
        ],
        'example' => '/popular?&categories=7,8,6&sub_categories=61,66,63&versions=0.6,13.0&limit=2',
        'response' => [
            'total' => 2,
            'results' => [
                [
                    'id' => 1261,
                    'name' => 'woman’s boot',
                    'emoji' => '👢',
                    'unicode' => '1F462',
                    'version' => 0.6,
                    'category' => [
                        'id' => 8,
                        'name' => 'Objects'
                    ],
                    'sub_category' => [
                        'id' => 66,
                        'name' => 'clothing'
                    ],
                    'children' => []
                ],
                [
                    'id' => 1259,
                    'name' => 'high-heeled shoe',
                    'emoji' => '🎄',
                    'unicode' => '1F460',
                    'version' => 0.6,
                    'category' => [
                        'id' => 8,
                        'name' => 'Objects'
                    ],
                    'sub_category' => [
                        'id' => 66,
                        'name' => 'clothing'
                    ],
                    'children' => []
                ]
            ]
        ]
    ],
    [
        'name' => 'Categories',
        'description' => 'Retrieve all categories and sub categories',
        'path' => '/categories',
        'example' => '/categories',
        'response' => [
            'total' => 10,
            'results' => [
                [
                    'id' => 1,
                    'name' => 'Smileys & Emotion',
                    'emojis_count' => 163,
                    'sub_categories' => [
                        [
                            'id' => 1,
                            'name' => 'face-smiling',
                            'emojis_count' => 14
                        ],
                        [
                            'id' => 2,
                            'name' => 'face-affection',
                            'emojis_count' => 9
                        ]
                    ]
                ]
            ]
        ]
    ],
    [
        'name' => 'Emoji',
        'description' => 'Retrieve metadata for a single emoji.',
        'path' => '/emojis/{id}',
        'example' => '/emojis/1',
        'response' => [
            'id' => 1,
            'name' => 'grinning face',
            'emoji' => '😀',
            'unicode' => '1F600',
            'version' => 1.0,
            'category' => [
                'id' => 1,
                'name' => 'Smileys & Emotion'
            ],
            'sub_category' => [
                'id' => 1,
                'name' => 'face-smiling'
            ],
            'children' => []
        ]
    ]

];
