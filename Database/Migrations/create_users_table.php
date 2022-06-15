<?php

namespace Database\Migrations;

use ItsPixStore\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    public function up()
    {
        echo "Create users table";
    }

    public function down()
    {
        echo "Drop users table";
    }

}

$createUsersTable = new CreateUsersTable();
$createUsersTable->up();