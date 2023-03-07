<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {

		$table->bigInteger('id',20);
		$table->string('name',225);
		$table->integer('account_type',11);
		$table->tinyInteger('is_parent',1)->default('0');
		$table->bigInteger('parent_account_number',20)->nullable()->default('NULL');
		$table->bigInteger('account_number',20);
		$table->tinyInteger('start_balance_status',4);
		$table->decimal('start_balance',10,2);
		$table->decimal('current_balance',10,2)->default('0.00');
		$table->bigInteger('other_table_FK',20)->nullable()->default('NULL');
		$table->string('notes',225)->nullable()->default('NULL');
		$table->integer('added_by',11);
		$table->integer('updated_by',11)->nullable()->default('NULL');
		$table->datetime('created_at');
		$table->datetime('updated_at')->nullable()->default('NULL');
		$table->tinyInteger('active',1)->default('1');
		$table->integer('com_code',11);
		$table->date('date');

        });
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}