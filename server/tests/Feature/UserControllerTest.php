<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_be_created()
    {
        $this->withoutExceptionHandling();

        
        $params =[
            'name'=>'prueba',
            'lastname'=>'prueba',
            'email'=>'prueba@prueba.com',
            'password'=>'12345678',
        ];
     
        $response = $this->post('register',$params);

        $this->assertDatabaseHas('users',[
            'name'=>$params['name'],
        ]);

        $response->assertStatus(200);
       
    }
     public function test_user_can_Login()
    {
        $this->withoutExceptionHandling();

        $params =[
            'email'=>'prueba@prueba.com',
            'password'=>'12345678',
        ];
        
        $url = "login?email={$params['email']}&password={$params['password']}";
     
        $response = $this->get($url);
        
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','token'])

        );
        
        $response->assertStatus(200);
        

    } 

     public function test_user_can_be_deleted()
    {
        $user=User::where('name','=','prueba');
        $user->delete();
        $this->assertTrue(True);
        $this->assertDatabaseMissing('users',[
            'email'=>'prueba@prueba.com'
        ]);
    }  
}
