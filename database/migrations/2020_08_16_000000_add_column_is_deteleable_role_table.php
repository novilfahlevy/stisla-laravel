<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsDeteleableRoleTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = config('permission.table_names')['roles'];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function(Blueprint $table) {
            $table->addColumn('boolean', 'is_deleteable', ['default' => 1])->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function(Blueprint $table) {
            $table->removeColumn('is_deleteable');
        });
    }
}
