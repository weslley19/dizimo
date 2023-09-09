<?php

use App\Models\User;
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
        Schema::create('dizimo', function (Blueprint $table) {
            $table->id();
            $table->integer('value');
            $table->integer('month');
            $table->integer('year');
            $table->foreignIdFor(User::class)->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dizimo', function(Blueprint $table){
            $table->dropForeignIdFor(User::class);
        });
        Schema::dropIfExists('dizimo');
    }
};
