<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Exam;

class CreateConclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Exam::class);
            $table->text('description');
            $table->integer('low');
            $table->integer('high');
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
        Schema::dropIfExists('conclusions');
    }
}
