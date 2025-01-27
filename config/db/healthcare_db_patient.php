<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => env('HEALTHCARE_DB_PATIENT_DSN'),
    'username' => env('HEALTHCARE_DB_AUTH_USERNAME'),
    'password' => env('HEALTHCARE_DB_AUTH_PASSWORD'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
