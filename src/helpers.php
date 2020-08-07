<?php

use DebugMx\OuraRing\OuraRing;

if (!function_exists('ouraring')) {
    function debugbar(): OuraRing
    {
        return app(OuraRing::class);
    }
}