<?php

use App\Models\TypeCulto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('value');
            $table->integer('month');
            $table->integer('year');
            $table->foreignIdFor(TypeCulto::class)->references('id')->on('types_cultos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function(Blueprint $table){
            $table->dropForeignIdFor(TypeCulto::class);
        });
        Schema::dropIfExists('offers');
    }
};
