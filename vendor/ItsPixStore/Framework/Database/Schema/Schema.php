<?php

namespace ItsPixStore\Database\Schema;

/**
 * @method
 */

class Schema {

    public static function create(string $table, \Closure $callback) {
        var_dump($table);
    }
}