<?php

return [
    /**
     * Search Paths.
     *
     * Specify the local poths to search for files
     */
    'disks' => [
        'local',
    ],

    /**
     * ASW Bucket Name.
     *
     * This is the AWS S3 bucket where the local files will be saved to
     */
    'aws_bucket' => 'your-bucket-name',

    /**
     * Storage Path
     *
     * This is the default storage path to look for files.  You should not have to change this from
     * storage_path('app/') but feel free to modify it for your environment.
     */
    'storage_path' => storage_path('app/')
];
