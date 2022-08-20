<?php

use App\Models\ProdType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_type', function (Blueprint $table) {
            $table->id();
           
            $table->string('type');
            

        });

        $this->postCreate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prod_type');
    }



    private function postCreate()  {
        
        $data =  array(
            [
                'type' => 'Vegetables',
            ],
            [
                'type' => 'Fruit',
            ],
            [
                'type' => 'Cereals',
            ],
            [
                'type' => 'Tubers',
            ],
            [
                'type' => 'Legumes',
            ],
            [
                'type' => 'Diary',
            ],
            [
                'type' => 'Meat',
            ],
        );
        foreach ($data as $datum){
            $category = new ProdType(); //The Category is the model for your migration
            $category->type =$datum['type'];
            $category->save();
        }
    }
};
