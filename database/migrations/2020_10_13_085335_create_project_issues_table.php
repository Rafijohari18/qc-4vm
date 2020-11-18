<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings(PHPMD.ShortMethodName)
 */
class CreateProjectIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_issues', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('created_by')
                ->comment('pelapor pertama');
            $table->string('code');
            $table->integer('code_index');
            $table->tinyInteger('priority')->nullable()
                ->comment('0 = Low/Improvement, 1 = Visual Error, 2 = Bug, '
                         .'3 = Error, 4 = Process-breaking Error');
            $table->string('url')->nullable();
            $table->text('reproduction_steps');
            $table->text('attachments')->nullable();
            $table->tinyInteger('status');

            $table->foreign('project_id')->references('id')->on('projects')
                    ->cascadeOnDelete();
            $table->foreign('module_id')->references('id')->on('project_modules')
                    ->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')
                    ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_issues');
    }
}
