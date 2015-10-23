<?php

return array(
    /**
     * link_multiple_providers
     *
     * Can multiple providers be attached to one user account
     */
    'link_multiple_providers' => true,
    /**
     * auto_registration
     *
     * If true, a login via a provider will automatically create a dummy
     * local user account with a random password, if a nickname and an
     * email address is present
     */
    'auto_registration' => false,
    /**
     * default_group
     *
     * Group id to be assigned to newly created users
     */
    'default_group' => 1,
    /**
     * debug
     *
     * Uncomment if you would like to view debug messages
     */
    'debug' => false,
    /**
     * A random string used for signing of auth response.
     *
     * You HAVE to set this value in your application config file!
     */
    'security_salt' => 'fdsfadnsklclanfnaernfninrjoaj9ncaruicfpsirfiuensi54tf50jeiorfhae',
    /**
     * Higher value, better security, slower hashing;
     * Lower value, lower security, faster hashing.
     */
    'security_iteration' => 300,
    /**
     * Time limit for valid $auth response, starting from $auth response generation to validation.
     */
    'security_timeout' => '2 minutes',
    /**
     * Strategy
     * Refer to individual strategy's documentation on configuration requirements.
     */
    'Strategy' => array(
        'Facebook' => [
            'app_id' => '720949771381958',
            'app_secret' => '6241e5e31d84afb629280240d5547153',
            'scope' => array('public_profile', 'email', 'user_friends', 'publish_actions'),
            'display' => 'popup'
        ]
    ),
    'provider' => 'Facebook',
    'table' => 'user_providers',
    'path' => '/admin/facebook/login/',
    'callback_url' => '/admin/facebook/callback/',
);
