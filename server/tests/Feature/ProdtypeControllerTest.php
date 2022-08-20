<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;

class ProdtypeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_prodtypes_can_be_retrieved()
    {
        User::factory()->count(1)->create();

        $user = User::first();
        $this->actingAs($user);
        $response = $this->get('types');

        $response->assertJson(fn(AssertableJson $json) =>
            $json->hasAll(['status', 'types'])
        );

        $response->assertStatus(200)->assertJson([
            'status' => 1,
            'types' => Array()
        ]);

        $response->assertStatus(200);
    }
}
