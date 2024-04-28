<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB; 
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDatabaseConnection()
    {
        $response = DB::select('SHOW TABLES');
        $this->assertNotNull($response);
    }
}
