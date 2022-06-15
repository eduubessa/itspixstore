<?php

namespace ItsPixStore\Database\Schema;

use ItsPixStore\Database\Database;

abstract class Model
{
    protected static $table;
    protected static $prefix = '';
    protected static $primaryKey = 'id';
    protected static $fillable = [];
    protected static $hidden = [];

    private static $database;

    private static function __init__() : void
    {

        $modelName = explode( '\\', get_called_class());
        $modelName = end($modelName);

        $tableName = strtolower($modelName);
        switch(substr($tableName, -1))
        {
            case 'y':
                $tableName .= 'ies';
                break;
            case 's':
                $tableName .= 'es';
                break;
            default:
                $tableName .= 's';
                break;
        }

        self::$table = self::$prefix . $tableName;
        self::$database = new Database();
        self::$database = self::$database->table(self::$table)->select();
    }

    public static function where() : self
    {
        if(!self::$database)
        {
            self::__init__();
        }

        echo "where";

        return self;
    }

    /**
     * Get the results from the database (using Database class).
     *
     * @return string
     */
    public static function get() : array
    {
        if(!static::$database) {
            self::__init__();
        }

        return self::$database->select()->get();
    }
}