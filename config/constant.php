<?php

/* --- System Group --- */
if (!defined('GROUP_ADMIN')) { define('GROUP_ADMIN', 1); } // Default
if (!defined('GROUP_MEMBER')) { define('GROUP_MEMBER', 2); }
    
/* --- User status --- */
if (!defined('USER_STATUS_BLOCK')) {define('USER_STATUS_BLOCK', 0);}
if (!defined('USER_STATUS_ACTIVE')) {define('USER_STATUS_ACTIVE', 1);}
if (!defined('USER_STATUS_DELETED')) {define('USER_STATUS_DELETED', 2);}

/* --- Email template --- */
if (!defined('EMAIL_TEMPLATE_SIGNUP')) {define('EMAIL_TEMPLATE_SIGNUP', 1);}
if (!defined('EMAIL_TEMPLATE_FORGOT_PASSWORD')) {define('EMAIL_TEMPLATE_FORGOT_PASSWORD', 2);}

/* --- Ajax status --- */
if (!defined('AJAX_STATUS_SUCCESS')) {define('AJAX_STATUS_SUCCESS', 'success');}
if (!defined('AJAX_STATUS_ERROR')) {define('AJAX_STATUS_ERROR', 'error');}

/* --- Static page --- */
if (!defined('PAGE_TERMS_OF_USE')) {define('PAGE_TERMS_OF_USE', 'terms_of_use');}
if (!defined('PAGE_PRIVACY_POLICY')) {define('PAGE_PRIVACY_POLICY', 'privacy_policy');}

/* --- Settings fields --- */
if (!defined('SETTING_FIELD_ADDRESS')) {define('SETTING_FIELD_ADDRESS', 'address');}
if (!defined('SETTING_FIELD_PHONE')) {define('SETTING_FIELD_PHONE', 'phone_number');}
if (!defined('SETTING_FIELD_FACEBOOK')) {define('SETTING_FIELD_FACEBOOK', 'facebook_link');}
if (!defined('SETTING_FIELD_CONTACT_INFO')) {define('SETTING_FIELD_CONTACT_INFO', 'contact_info');}

/* --- Settings type --- */
if (!defined('SETTING_TYPE_TEXT')) {define('SETTING_TYPE_TEXT', 'text');}
if (!defined('SETTING_TYPE_FILE')) {define('SETTING_TYPE_FILE', 'file');}
if (!defined('SETTING_TYPE_TEXTAREA')) {define('SETTING_TYPE_TEXTAREA', 'textarea');}
if (!defined('SETTING_TYPE_RICHTEXTAREA')) {define('SETTING_TYPE_RICHTEXTAREA', 'richtextarea');}

/* --- Error type file --- */
if (!defined('FILE_ERROR_MAX_SIZE')) {define('FILE_ERROR_MAX_SIZE', 1);}
if (!defined('FILE_ERROR_EXTENSION')) {define('FILE_ERROR_EXTENSION', 2);}
if (!defined('FILE_ERROR_EMPTY')) {define('FILE_ERROR_EMPTY', 3);}

/* --- Path upload files --- */
if (!defined('PATH_IMAGE_FILE')) {define('PATH_IMAGE_FILE', WWW_ROOT.'upload'.DS);}

/* defind phpunit command */
if (!defined('PHPUNIT_RUNNING')) {define('PHPUNIT_RUNNING', false);}

return [
    'Core' => [
        'Tablename' => [
            0 => 'Businesses',
            1 => 'Fashions',
            2 => 'Games',
            3 => 'Photographies',
            4 => 'Technologies'
        ],
        'Users'=> [
            'gender'=>[0=>__('Female'),1=>__('Male')],
            'group'=> [
                GROUP_ADMIN => __('Group admin'),
                GROUP_MEMBER => __('Group member')
            ]
        ],
        'System'=> [
            'active'=> [
                1 => __('True'),
                0 => __('False')
            ],
            'language' => [
                'vie' => [
                    'key' => 'vi_VN',
                    'name' => __('Vietnamese'),
                    'flag' => 'flag-vn'
                ],
                'jap' => [
                    'key' => 'ja_JP',
                    'name' => __('Japanese'),
                    'flag' => 'flag-jp'
                ],
                'eng' => [
                    'key' => 'en_US',
                    'name' => __('English'),
                    'flag' => 'flag-us'
                ]
            ]
        ],
        'Settings' => [
            SETTING_FIELD_ADDRESS => SETTING_TYPE_TEXT,
            SETTING_FIELD_PHONE => SETTING_TYPE_TEXT,
            SETTING_FIELD_FACEBOOK => SETTING_TYPE_TEXT,
            SETTING_FIELD_CONTACT_INFO => SETTING_TYPE_RICHTEXTAREA,
        ],
        'Pages' => [
            PAGE_TERMS_OF_USE => __('Terms of use'),
            PAGE_PRIVACY_POLICY => __('Privacy policy'),
        ],
        'EmailTemplates' => [
            EMAIL_TEMPLATE_SIGNUP => __('Signup'),
            EMAIL_TEMPLATE_FORGOT_PASSWORD => __('Forgot password')
        ],
        'Errors' => [
            'File' => [
                FILE_ERROR_EMPTY => __('This file is require'),
                FILE_ERROR_MAX_SIZE => __('File size exceeds allowable'),
                FILE_ERROR_EXTENSION => __('This file is not valid')
            ]
        ],
        'Countries' => [
            0 => 'Afghanistan',
            1 => 'Albania',
            2 => 'Algeria',
            3 => 'American Samoa',
            4 => 'Andorra',
            5 => 'Angola',
            6 => 'Anguilla',
            7 => 'Antarctica',
            8 => 'Antigua and Barbuda',
            9 => 'Argentina',
            10 => 'Armenia',
            11 => 'Aruba',
            12 => 'Australia',
            13 => 'Austria',
            14 => 'Azerbaijan',
            15 => 'Bahamas',
            16 => 'Bahrain',
            17 => 'Bangladesh',
            18 => 'Barbados',
            19 => 'Belarus',
            20 => 'Belgium',
            21 => 'Belize',
            22 => 'Benin',
            23 => 'Bermuda',
            24 => 'Bhutan',
            25 => 'Bolivia',
            26 => 'Bosnia and Herzegowina',
            27 => 'Botswana',
            28 => 'Bouvet Island',
            29 => 'Brazil',
            30 => 'British Indian Ocean Territory',
            31 => 'Brunei Darussalam',
            32 => 'Bulgaria',
            33 => 'Burkina Faso',
            34 => 'Burundi',
            35 => 'Cambodia',
            36 => 'Cameroon',
            37 => 'Canada',
            38 => 'Cape Verde',
            39 => 'Cayman Islands',
            40 => 'Central African Republic',
            41 => 'Chad',
            42 => 'Chile',
            43 => 'China',
            44 => 'Christmas Island',
            45 => 'Cocos (Keeling) Islands',
            46 => 'Colombia',
            47 => 'Comoros',
            48 => 'Congo',
            49 => 'Congo, the Democratic Republic of the',
            50 => 'Cook Islands',
            51 => 'Costa Rica',
            52 => 'Cote d\'Ivoire',
            53 => 'Croatia (Hrvatska)',
            54 => 'Cuba',
            55 => 'Cyprus',
            56 => 'Czech Republic',
            57 => 'Denmark',
            58 => 'Djibouti',
            59 => 'Dominica',
            60 => 'Dominican Republic',
            61 => 'East Timor',
            62 => 'Ecuador',
            63 => 'Egypt',
            64 => 'El Salvador',
            65 => 'Equatorial Guinea',
            66 => 'Eritrea',
            67 => 'Estonia',
            68 => 'Ethiopia',
            69 => 'Falkland Islands (Malvinas)',
            70 => 'Faroe Islands',
            71 => 'Fiji',
            72 => 'Finland',
            73 => 'France',
            74 => 'France Metropolitan',
            75 => 'French Guiana',
            76 => 'French Polynesia',
            77 => 'French Southern Territories',
            78 => 'Gabon',
            79 => 'Gambia',
            80 => 'Georgia',
            81 => 'Germany',
            82 => 'Ghana',
            83 => 'Gibraltar',
            84 => 'Greece',
            85 => 'Greenland',
            86 => 'Grenada',
            87 => 'Guadeloupe',
            88 => 'Guam',
            89 => 'Guatemala',
            90 => 'Guinea',
            91 => 'Guinea-Bissau',
            92 => 'Guyana',
            93 => 'Haiti',
            94 => 'Heard and Mc Donald Islands',
            95 => 'Holy See (Vatican City State)',
            96 => 'Honduras',
            97 => 'Hong Kong',
            98 => 'Hungary',
            99 => 'Iceland',
            100 => 'India',
            101 => 'Indonesia',
            102 => 'Iran (Islamic Republic of)',
            103 => 'Iraq',
            104 => 'Ireland',
            105 => 'Israel',
            106 => 'Italy',
            107 => 'Jamaica',
            108 => 'Japan',
            109 => 'Jordan',
            110 => 'Kazakhstan',
            111 => 'Kenya',
            112 => 'Kiribati',
            113 => 'Korea, Democratic People\'s Republic of',
            114 => 'Korea, Republic of',
            115 => 'Kuwait',
            116 => 'Kyrgyzstan',
            117 => 'Lao, People\'s Democratic Republic',
            118 => 'Latvia',
            119 => 'Lebanon',
            120 => 'Lesotho',
            121 => 'Liberia',
            122 => 'Libyan Arab Jamahiriya',
            123 => 'Liechtenstein',
            124 => 'Lithuania',
            125 => 'Luxembourg',
            126 => 'Macau',
            127 => 'Macedonia, The Former Yugoslav Republic of',
            128 => 'Madagascar',
            129 => 'Malawi',
            130 => 'Malaysia',
            131 => 'Maldives',
            132 => 'Mali',
            133 => 'Malta',
            134 => 'Marshall Islands',
            135 => 'Martinique',
            136 => 'Mauritania',
            137 => 'Mauritius',
            138 => 'Mayotte',
            139 => 'Mexico',
            140 => 'Micronesia, Federated States of',
            141 => 'Moldova, Republic of',
            142 => 'Monaco',
            143 => 'Mongolia',
            144 => 'Montserrat',
            145 => 'Morocco',
            146 => 'Mozambique',
            147 => 'Myanmar',
            148 => 'Namibia',
            149 => 'Nauru',
            150 => 'Nepal',
            151 => 'Netherlands',
            152 => 'Netherlands Antilles',
            153 => 'New Caledonia',
            154 => 'New Zealand',
            155 => 'Nicaragua',
            156 => 'Niger',
            157 => 'Nigeria',
            158 => 'Niue',
            159 => 'Norfolk Island',
            160 => 'Northern Mariana Islands',
            161 => 'Norway',
            162 => 'Oman',
            163 => 'Pakistan',
            164 => 'Palau',
            165 => 'Panama',
            166 => 'Papua New Guinea',
            167 => 'Paraguay',
            168 => 'Peru',
            169 => 'Philippines',
            170 => 'Pitcairn',
            171 => 'Poland',
            172 => 'Portugal',
            173 => 'Puerto Rico',
            174 => 'Qatar',
            175 => 'Reunion',
            176 => 'Romania',
            177 => 'Russian Federation',
            178 => 'Rwanda',
            179 => 'Saint Kitts and Nevis',
            180 => 'Saint Lucia',
            181 => 'Saint Vincent and the Grenadines',
            182 => 'Samoa',
            183 => 'San Marino',
            184 => 'Sao Tome and Principe',
            185 => 'Saudi Arabia',
            186 => 'Senegal',
            187 => 'Seychelles',
            188 => 'Sierra Leone',
            189 => 'Singapore',
            190 => 'Slovakia (Slovak Republic)',
            191 => 'Slovenia',
            192 => 'Solomon Islands',
            193 => 'Somalia',
            194 => 'South Africa',
            195 => 'South Georgia and the South Sandwich Islands',
            196 => 'Spain',
            197 => 'Sri Lanka',
            198 => 'St. Helena',
            199 => 'St. Pierre and Miquelon',
            200 => 'Sudan',
            201 => 'Suriname',
            202 => 'Svalbard and Jan Mayen Islands',
            203 => 'Swaziland',
            204 => 'Sweden',
            205 => 'Switzerland',
            206 => 'Syrian Arab Republic',
            207 => 'Taiwan, Province of China',
            208 => 'Tajikistan',
            209 => 'Tanzania, United Republic of',
            210 => 'Thailand',
            211 => 'Togo',
            212 => 'Tokelau',
            213 => 'Tonga',
            214 => 'Trinidad and Tobago',
            215 => 'Tunisia',
            216 => 'Turkey',
            217 => 'Turkmenistan',
            218 => 'Turks and Caicos Islands',
            219 => 'Tuvalu',
            220 => 'Uganda',
            221 => 'Ukraine',
            222 => 'United Arab Emirates',
            223 => 'United Kingdom',
            224 => 'United States',
            225 => 'United States Minor Outlying Islands',
            226 => 'Uruguay',
            227 => 'Uzbekistan',
            228 => 'Vanuatu',
            229 => 'Venezuela',
            230 => 'Vietnam',
            231 => 'Virgin Islands (British)',
            232 => 'Virgin Islands (U.S.)',
            233 => 'Wallis and Futuna Islands',
            234 => 'Western Sahara',
            235 => 'Yemen',
            236 => 'Yugoslavia',
            237 => 'Zambia',
            238 => 'Zimbabwe'
        ]
    ]
];
?>