<?php

if (!function_exists('isAdmin')) {
    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    function isActive($key, $activeClassName = 'active')
    {

        if(is_array($key)){
            return in_array(Route::currentRouteName(), $key) ? $activeClassName : '';
        }
        return Route::currentRouteName() == $key ? $activeClassName : '';
    }
}