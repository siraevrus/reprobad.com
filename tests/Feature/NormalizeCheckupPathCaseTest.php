<?php

namespace Tests\Feature;

use Tests\TestCase;

class NormalizeCheckupPathCaseTest extends TestCase
{
    public function test_checkup_with_wrong_case_redirects_to_lowercase(): void
    {
        $response = $this->get('/Checkup');

        $response->assertRedirect('/checkup');
        $response->assertStatus(301);
    }

    public function test_checkup_subpath_with_wrong_case_redirects_preserving_query(): void
    {
        $response = $this->get('/Checkup/reset?start=1');

        $response->assertRedirect('/checkup/reset?start=1');
        $response->assertStatus(301);
    }

    public function test_post_to_checkup_calculate_with_wrong_case_uses_308(): void
    {
        $response = $this->post('/Checkup/calculate');

        $response->assertRedirect('/checkup/calculate');
        $response->assertStatus(308);
    }
}
