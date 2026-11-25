<?php

return [
    'name'    => 'Soil Sons Welfare Foundation',

    /* Full legal / display name used in headings and metadata. */
    'legal_name' => 'Soil Sons Welfare Foundation',

    /* Public base URL of the site. Used by the canonical tags and schema.org
       data in the page heads. Change it once here when you go live. */
    'url' => env('SITE_URL', 'http://localhost/soil_sons/public'),

    /* Base URL path for theme assets in public/assets ("/" when public/ is the docroot). */
    'asset_base' => env('ASSET_BASE'),   // null = auto-detect from the request (works in a sub-folder too)

    'phone'   => env('SITE_PHONE', '+91 74181 44991'),
    'phone_alt' => env('SITE_PHONE_ALT', '+91 74181 44992'),

    /* Office landline */
    'landline' => env('SITE_LANDLINE', '0452 400 2111'),
    'email'   => env('SITE_EMAIL', ''),
    'address' => 'No. 68/0, Ahimsapuram, Mela Street, Puthiyavisalam (Sivagami Street), Sellur, Madurai, Tamil Nadu 625002',

    /* Where contact-form enquiries are delivered. */
    'enquiry_email' => env('ENQUIRY_EMAIL', ''),

    /* Social profiles shown in the header/footer. Leave empty to hide an icon. */
    'social' => [
        'facebook'  => env('SOCIAL_FACEBOOK', ''),
        'instagram' => env('SOCIAL_INSTAGRAM', ''),
        'youtube'   => env('SOCIAL_YOUTUBE', ''),
    ],

    'contact_success' => 'Thanks for reaching out. Our team will contact you shortly.',
];
