<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
            $table->boolean('can_manage_kanban_boards')->default(false);                    // -> can create, edit, delete kanban boards
            $table->boolean('can_manage_kanban_content')->default(false);                   // -> can create , edit, delete kanban content like statuses, priorities, (sub-) systems, ...
            $table->boolean('can_use_multiple_kanban_boards')->default(false);              // -> can use multiple kanban boards (in case not, the default kanban board of the user is loaded)
            $table->boolean('can_manage_tasks')->default(false);                       // -> can create, edit, delete tasks in a kanban board, change status of tasks
            $table->boolean('can_manage_task_logs')->default(false);                        // -> can create, edit task logs
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
        Schema::dropIfExists('roles');
    }
}
