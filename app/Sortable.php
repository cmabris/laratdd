<?php

namespace App;

use Illuminate\Support\Arr;

class Sortable
{
    protected $currentColumn;
    protected $currentDirection;
    protected $currentUrl;

    public function __construct($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }

    public function setCurrentOrder($column, $direction = 'asc')
    {
        $this->currentColumn = $column;
        $this->currentDirection = $direction;
    }

    public function classes($column)
    {
        if ($this->currentColumn == $column && $this->currentDirection == 'asc') {
            return 'link-sortable link-sorted-up';
        }

        if ($this->currentColumn == $column && $this->currentDirection == 'desc') {
            return 'link-sortable link-sorted-down';
        }

        return 'link-sortable';
    }

    public function url($column, $direction = 'asc')
    {
        return $this->currentUrl . '?' .
            Arr::query(['order' => $column, 'direction' => $direction]);
    }
}