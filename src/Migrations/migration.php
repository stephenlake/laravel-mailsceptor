<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $model = config('mailsceptor.database.model', \Mailsceptor\Models\Email::class);
        $model = new $model();

        $modelTable = $model->getTable();
        $modelKeyType = $model->getTableKeyType();

        Schema::create($modelTable, function (Blueprint $table) use ($modelKeyType) {
            $table->$modelKeyType('id');
            $table->string('subject');
            $table->longText('body');
            $table->text('to');
            $table->text('cc')->nullable();
            $table->text('bcc')->nullable();
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
        $model = config('mailsceptor.database.model', \Mailsceptor\Models\Email::class);
        $model = new $model();

        $modelTable = $model->getTable();

        Schema::dropIfExists($modelTable);
    }
}
