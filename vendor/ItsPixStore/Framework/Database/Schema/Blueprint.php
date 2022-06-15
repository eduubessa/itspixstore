<?php

namespace ItsPixStore\Database\Schema;

class Blueprint {

    /**
     * The table the blueprint describes.
     *
     * @var string
     */
    protected $table;

    /**
     * The prefix of the table.
     *
     * @var string
     */
    protected $prefix;

    /**
     * The columns that should be added to the table.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Create a new schema blueprint.
     *
     * @param string $table
     * @param \Closure|null $callback
     * @param string $prefix
     */
    public function __construct($table, Closure $callback = null, $prefix = '')
    {
        $this->table = $table;
        $this->prefix = $prefix;

        if(!is_null($callback)) {
            $callback($this);
        }
    }

    public function increments($column)
    {
        $this->columns[] = new Column($column, 'increments');
    }

    public function string($name, $length = 255)
    {
        return $this->addColumn('string', $name, $length);
    }

    public function integer($name)
    {
        return $this->addColumn('integer', $name);
    }

    public function decimal($name, $precision = 10, $scale = 2)
    {
        return $this->addColumn('decimal', $name, $precision, $scale);
    }

    public function boolean($name)
    {
        return $this->addColumn('boolean', $name);
    }

    public function timestamps()
    {
        return $this->addColumn('timestamps');
    }

    private function addColumn($type, $name, $length = null, $precision = null, $scale = null)
    {
        $this->columns[] = compact('type', 'name', 'length', 'precision', 'scale');

        var_dump($this->columns);
    }
}