<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class inventoryControllerTest extends TestCase
{

    public function test_inventoryId_can_be_deleted()
    {

        User::factory()->count(1)->create();
        $user = User::first();
        $inventory = Inventory::create([
            'user_id' => $user->id,
            'name' => 'inventarioDeleteExample',
            'description' => 'inventarioDeleteExample description',
        ]);
        $this->actingAs($user);


        $response = $this->delete("inventory/delete?id={$inventory->id}");

        $response->assertJson(fn(AssertableJson $json) =>
            $json->hasAll(['status', 'msg'])
        );

        $this->assertDatabaseMissing('inventory', [
            'id' => $inventory->id,
        ]);

    }
    public function test_inventories_can_get_retrieved()
    {
        $this->withoutExceptionHandling();

        User::factory()->count(1)->create();
        $user = User::first();
        $this->actingAs($user);

        Inventory::factory()->count(30)->create([
            'user_id' => $user->id,
            'name' => 'inventoryExample',
            'description' => 'inventoryExample description',
        ]);

        $response = $this->get('inventory');

        $response->assertJson(fn(AssertableJson $json) =>
            $json->hasAll(['status', 'inventories'])

        );
        $response->assertStatus(200);
        $inventoryExample = Inventory::where('name', '=', 'inventoryExample')->first();
        $inventoryExample->delete();

    }
    public function test_inventoryId_can_be_created()
    {

        User::factory()->count(1)->create();
        $user = User::first();
        $this->actingAs($user);
        $params = [
            'name' => 'inventoryExample',
            'description' => 'inventoryExample description',
        ];
        $response = $this->post('inventory/create', $params);

        $response->assertJson(fn(AssertableJson $json) =>
            $json->hasAll(['status', 'msg'])

        );
        $this->assertDatabaseHas('inventory', [
            'name' => 'inventoryExample',
            

        ]);
        $response->assertStatus(200);
        $inventoryExample = Inventory::where('name', '=', 'inventoryExample')->first();
        $inventoryExample->delete();

    }

}
