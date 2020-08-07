<?php

namespace DebugMx\OuraRing\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class OuraRingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_loads_correctly()
    {
        $this->loadLaravelMigrations();

        $this->ouraring()->boot();
 
        $this->assertStringStartsWith('https://cloud.ouraring.com', $this->ouraring()->authorizeBaseUri());
        $this->assertEquals('https://api.ouraring.com/oauth/token', $this->ouraring()->endpointUrl('/oauth/token'));
        $this->assertEquals('https://api.ouraring.com/v1/activity', $this->ouraring()->buildActionUrl('activity'));
    }
}

class User extends Model
{
    protected $table = 'users';
    protected $guarded = [];
}

class Person extends User
{
}