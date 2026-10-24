<?php

namespace Tests\Feature;

use Tests\TestCase;

class FoundationSetupTest extends TestCase
{
    public function test_filament_login_is_available(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }
}
