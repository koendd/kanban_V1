<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTaskTypesTableAddKanbanBoard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_types', function (Blueprint $table) {
            $table->unsignedBigInteger('kanban_board_id')->default(1);
            $table->foreign('kanban_board_id')->references('id')->on('kanban_boards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_types', function (Blueprint $table) {
            $table->dropForeign('task_types_kanban_board_id_foreign');
            $table->dropColumn('kanban_board_id');
        });
    }
}
