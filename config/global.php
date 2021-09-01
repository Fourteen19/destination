<?php

return [

    'tag_names' => [
        'high_priority' => 'High priority',
    ],

    'school_year' => [
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => 'post education',
    ],

    //default text used in the backend to initialise the "client settings"
    'default_client_settings' => [
        'login_intro' => '<p>To access MyDirections please login using the form below</p>',
        'careers_intro' => '<p>To make sure we give you the right level of support and the sort of content that will help you make good decisions in the future, we’d like to know a bit more about what stage you are at when thinking about your career.</p>',
        'subjets_intro' => '<p>Next we-re going to look at the subjects that you enjoy and are good at, compared to those that you are less interested in or don’t want to study in the future.</p>',
        'routes_intro' => '<p>Next were going to look at the route you are going take, from where you are now to your career in the future.</p>',
        'sectors_intro' => '<p>Finally were going to look at the sort of sectors you might be interested in working in.</p>',
        'assessment_completed' => ''
    ],

    'default_summary_images' => [
        'summary_slot1' => 'https://via.placeholder.com/2074x1056/f8c4af/c8a59c?text=Banner',
        'summary_slot2-3' => 'https://via.placeholder.com/771x512.png?text=Article+Image',
        'summary_slot4-5-6' => 'https://via.placeholder.com/1006x670.png?text=Article+Image',
        'summary_you_might_like' => 'https://via.placeholder.com/737x737/5379a6/5379a6?text=Banner',
        'search' => 'https://via.placeholder.com/740x440.png?text=Article+Image'
    ],

    'admin_user_type' => [
        'System_Administrator' =>  'System Administrator',
        'Global_Content_Admin' => 'Global Content Admin',
        'Client_Admin' => 'Client Admin',
        'Client_Content_Admin' => 'Client Content Admin',
        'Advisor' => 'Adviser',
        'Teacher' => 'Teacher',
        'Third_Party_Admin' => 'Third Party Admin',
        'Employer' => 'Employer',
    ],

    'templates' => [
        'article' => 'Article',
        'accordion' => 'Accordion',
        'activity' => 'Work Experience Activity',
        'employer' => 'Employer Profile',
    ],

    'admin_title' => [
            'Mr'=>'Mr',
            'Mrs'=>'Mrs',
            'Ms'=>'Ms',
            'Miss'=>'Miss',
            'Dr'=>'Dr'
    ],

    'terms' => [
        'spring' => "Spring",
        'autumn' => "Autumn-Winter",
        'summer' => "Summer",
    ],

    'admins' => [
        'photo' => [
            'upload' => [
                'max_filesize' => 100,
                'required_size' => [
                    'height' => 300,
                    'width' => 300,
                ],
            ]
        ],
    ],

    'articles' => [
        'banner' => [
            'upload' => [
                'required_size' => [
                    'height' => 528,
                    'width' => 1369,
                ],
            ]
        ],
        'summary' => [
            'upload' => [
                'required_size' => [
                    'height' => 528,
                    'width' => 1369,
                ],
            ]
        ],

        'nb_related_articles_in_article' => 3, //nb related articles to display in an article.

    ],



    'activities' => [
        'banner' => [
            'upload' => [
                'required_size' => [
                    'height' => 800,
                    'width' => 1194,
                ],
            ]
        ],
        'summary' => [
            'upload' => [
                'required_size' => [
                    'height' => 800,
                    'width' => 1194,
                ],
            ]
        ],

    ],


    'events' => [
        'banner' => [
            'upload' => [
                'required_size' => [
                    'height' => 528,
                    'width' => 1369,
                ],
            ]
        ],
        'summary' => [
            'upload' => [
                'required_size' => [
                    'height' => 528,
                    'width' => 528,
                ],
            ]
        ],
        'future_events' => [
            'load_more_number' => 6   //dictates the number of events to load via ajax in the upcoming events section
        ]

    ],


    '24-hour-clock' => [
        'hours' => ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09',
                   '10', '11', '12', '13', '14', '15', '16', '17', '18', '19',
                   '20', '21', '22', '23'],
        'mins' => ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09',
                   '10', '11', '12', '13', '14', '15', '16', '17', '18', '19',
                   '20', '21', '22', '23', '24', '25', '26', '27', '28', '29',
                   '30', '31', '32', '33', '34', '35', '36', '37', '38', '39',
                   '40', '41', '42', '43', '44', '45', '46', '47', '48', '49',
                   '50', '51', '52', '53', '54', '55', '56', '57', '58', '59'],
    ],


    'vacancies' => [
        'image' => [
            'upload' => [
                'max_filesize' => 300,
                'required_size' => [
                    'height' => 800,
                    'width' => 1000,
                ],
            ]
        ],

        'opportunities_vacancies' => [
            'load_more_number' => 3,
        ],

    ],



    'months' => [
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
    ],



];
