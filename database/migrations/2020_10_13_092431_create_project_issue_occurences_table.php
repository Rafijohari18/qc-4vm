<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings(PHPMD.ShortMethodName)
 */
class CreateProjectIssueOccurencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_issue_occurences', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('issue_id');
            $table->unsignedBigInteger('submitted_by')->nullable();
            $table->integer('occurence')->default(0);
            $table->text('extra_note')->nullable();
            $table->text('extra_attachment');
            $table->unsignedBigInteger('handled_by')->nullable();
            $table->text('handler_note')->nullable();
            $table->boolean('solved')->default(false);
            $table->timestamp('closed_at')->nullable();

            $table->foreign('project_id')->references('id')->on('projects')
                    ->cascadeOnDelete();
            $table->foreign('module_id')->references('id')->on('project_modules')
                    ->cascadeOnDelete();
            $table->foreign('issue_id')->references('id')->on('project_issues')
                    ->cascadeOnDelete();
            $table->foreign('submitted_by')->references('id')->on('users')
                    ->cascadeOnDelete();
            $table->foreign('handled_by')->references('id')->on('users')
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
        Schema::dropIfExists('project_issue_occurences');
    }
}
