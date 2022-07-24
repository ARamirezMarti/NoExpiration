<?php

namespace Tests\Feature;

use App\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

use App\Models\User;

class inventoryControllerTest extends TestCase
{
    
    public function test_inventoryId_can_be_deleted()
    {

        User::factory()->count(1)->create();
        $user = User::first();
        $inventory = Inventory::create([
            'user_id'=>$user->id,
            'name'=>'inventarioDeleteExample'
        ]);
        $this->actingAs($user);

        $params=[
            'id'=>$inventory->id
        ];
        
        $response = $this->post('inventory/delete',$params);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','msg'])
        );

        $this->assertDatabaseMissing('inventory',[            
            'id'=>$inventory->id
        ]);     
        
    } 
    public function test_inventoryId_can_get_retrieved()
    {
        $this->withoutExceptionHandling();

        User::factory()->count(1)->create();
        $user = User::first();
        $this->actingAs($user);
     
        Inventory::create([
            'user_id'=>$user->id,
            'name'=>'inventoryExample'
        ]);

        $response = $this->get('inventory');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','inventario'])

        );
        $response->assertStatus(200);
        $inventoryExample = Inventory::where('name','=','inventoryExample')->first();
        $inventoryExample->delete();       
       
    } 
    public function test_inventoryId_can_be_created()
    {

        User::factory()->count(1)->create();
        $user = User::first();
        $this->actingAs($user);
        $params=[
            'name'=>'inventoryExample'
        ];
        $response = $this->post('inventory/create',$params);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','msg'])

        );
        $this->assertDatabaseHas('inventory',[
            'name'=>'inventoryExample'

        ]);
        $response->assertStatus(200);
        $inventoryExample = Inventory::where('name','=','inventoryExample')->first();
        $inventoryExample->delete();
        
    } 
    
}
