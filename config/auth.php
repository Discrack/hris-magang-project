<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here. Here are the default sessions and API guards defined for
    | your application.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms to authenticate a user.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources and "providers" here.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
            // PASTIKAN BARIS INI ADA UNTUK MENENTUKAN FIELD OTENTIKASI
            // Jika Anda ingin mengotentikasi berdasarkan 'username' bukan 'email', tambahkan 'username' di sini
            // Namun, Auth::attempt() akan otomatis mencari 'username' jika ada di credentials,
            // jadi ini biasanya tidak perlu diubah kecuali ada kebutuhan khusus.
            // Pastikan tidak ada 'identifier' atau 'username' yang hardcoded di sini
            // yang mungkin bertentangan. Laravel akan otomatis menggunakan kolom 'username'
            // jika ada di array credentials yang Anda berikan ke Auth::attempt().
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify how the password reset functionality should be configured
    | for your application. This still utilizes the applications user tables.
    |
    | The expiry time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and prompts the user to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];