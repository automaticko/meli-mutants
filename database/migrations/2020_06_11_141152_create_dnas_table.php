<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDnasTable extends Migration
{
    protected $tableName = 'dnas';

    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->text('sequence');
            $table->unsignedSmallInteger('is_mutant');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
