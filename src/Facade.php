<?php

namespace DebugMx\OuraRing;

/**
 * @method static string authorizeBaseUri()
 * @method static string apiBaseUri()
 *
 * @see \DebugMx\OuraRing\OuraRing
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return OuraRing::class;
    }
}
