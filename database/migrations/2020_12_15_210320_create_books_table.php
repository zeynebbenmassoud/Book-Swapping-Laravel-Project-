<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->mediumText('synopsis');
            $table->float('prix');
            $table->string('type');// donate or sell
            $table->boolean('availability')->default(true);
            $table->integer('likes')->default(0);
            $table->string('categories');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('restrict')
                  ->onUpdate('restrict');
                  
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function(Blueprint $table) {
			$table->dropForeign('books_user_id_foreign');
        });
        
        Schema::dropIfExists('books');
    }
}
