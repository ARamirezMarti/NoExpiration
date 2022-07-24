<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;

use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Companies_are_retrieved()

    {

        $this->withoutDeprecationHandling();
        User::factory()->count(1)->create()->first();
        $user = User::first();
        $this->actingAs($user);

        Inventory::factory()->count(1)->create()->first();       
                
        $product = Product::factory()->count(50)->create()->first(); 
        
        
        Company::factory()->count(50)->create([
            'product_id' => $product->id,
            'user_id'=> $user->id,
            'name' => 'Example company'
        ]);

        $response = $this->get("product/companies/all?user=20r");
        
        
        $response->assertJson(fn (AssertableJson $json) =>
          $json->hasAll(['status','companies'])        
        );

        $response->assertStatus(200)->assertJson([
            'status' => 1,
            'companies'=> Array()
        ]);

        $response->assertStatus(200);

  

    }
}
