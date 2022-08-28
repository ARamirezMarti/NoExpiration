<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_can_be_create()
    {
        $this->withoutDeprecationHandling();
        User::factory()->count(1)->create();
        $user = User::first();
        $this->actingAs($user);

        $inventory = Inventory::factory()->count(1)->create()->first();
        $payload = [
            'inventory_id' => $inventory->id,
            'name' => 'Product example',
            'buying_date' => '2022-05-24',
            'prod_type_id' => 1,
            'expiration_date' => '2022-07-24',
            'image' => 'lorem impsun',
        ];

        $response = $this->post('product/create', $payload);

        $product = Product::where('name', $payload['name'])->first();
        $this->assertDatabaseHas('product', [
            'id' => $product->id,
        ]);
       
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 1,
            ]);
        $user->delete();
    }

    public function test_product_can_be_deleted()
    {

        User::factory()->count(1)->create();
        $user = User::first();
        $this->actingAs($user);

        Inventory::factory()->count(1)->create();

        $product = Product::factory()->count(1)->create()->first();

        $payload = [
            'id' => $product->id,
        ];
        $response = $this->delete('product/delete', $payload);

        $this->assertDatabaseMissing('product', [
            'id' => $product->id,
        ]);

        $response->assertJson([
            'status' => 1,
        ]);
        $response->assertStatus(200);
        $product->delete();
        $user->delete();

    }

    public function test_product_can_be_update()
    {

        User::factory()->count(1)->create();
        $user = User::first();
        $this->actingAs($user);

        Inventory::factory()->count(1)->create()->first();

        $product = Product::factory()->count(1)->create()->first();

        $payload = [
            'product_id' => $product->id,
            'inventory_id' => $product->inventory_id,
            'prod_type_id' => 1,
            'name' => 'Name changed in update',
            'buying_date' => '2022-05-30',
            'expiration_date' => '2022-07-31',
            'image' => 'lorem impsun changed',
        ];

        $response = $this->post('product/update', $payload);

        $productAfterChange = Product::where('id', '=', $product->id)->first();

        $this->assertNotEquals($productAfterChange->name, $product->name);
        $this->assertNotEquals($productAfterChange->buying_date, $product->buying_date);
        $this->assertNotEquals($productAfterChange->expiration_date, $product->expiration_date);
        $this->assertNotEquals($productAfterChange->image, $product->image);

        $response->assertStatus(200)->assertJson([
            'status' => 1,
        ]);
        $productAfterChange->delete();
    }

    public function test_one_product_can_be_retrived()
    {

        User::factory()->count(1)->create();
        $user = User::first();
        $this->actingAs($user);

        $inventory = Inventory::factory()->count(1)->create()->first();

        $product = Product::factory()->count(1)->create()->first();

        $payload = [
            'product_id' => $product->id,
        ];

        $response = $this->get('product/one', $payload);

        $response->assertJson(fn(AssertableJson $json) =>
            $json->hasAll(['status', 'product'])
        );

        $response->assertStatus(200)->assertJson([
            'status' => 1,
        ]);
        $inventory->delete();

    }
    public function test_all_product_can_be_retrived()
    {

        User::factory()->count(1)->create();
        $user = User::first();
        $this->actingAs($user);

        $inventory = Inventory::factory()->count(1)->create()->first();

        Product::factory()->count(50)->create([
            'inventory_id' => $inventory->id,
            'name' => 'Name Example',
            'buying_date' => '2022-05-30',
            'expiration_date' => '2022-07-31',
            'image' => 'lorem impsun',
        ]);

        $response = $this->get("product/all?inventory_id={$inventory->id}");

        $response->assertJson(fn(AssertableJson $json) =>
            $json->hasAll(['status', 'products'])
        );

        $response->assertStatus(200)->assertJson([
            'status' => 1,
            'products' => array(),
        ]);

        Product::whereNotNull('id')->delete();

    }

}
