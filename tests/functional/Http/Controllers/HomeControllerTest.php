<?php

namespace Tests\Functional\Http\Controllers;

use TestCase;

class HomeControllerTest extends TestCase
{
    /** @test */
    public function it_should_display_the_login_form()
    {
        $this->visit('/')
            ->see('Login')
            ->seePageIs('/auth/login');
    }
}
