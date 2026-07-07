<?php

return [
    /**
     * Current application version
     * This is automatically updated by the CI/CD pipeline during deployments
     */
    'current' => trim(file_get_contents(base_path('.version'))) ?? '0.0.0',
    
    /**
     * Build information
     */
    'build' => [
        'timestamp' => env('BUILD_TIMESTAMP'),
        'commit' => env('BUILD_COMMIT'),
        'branch' => env('BUILD_BRANCH', 'main'),
    ],
];
