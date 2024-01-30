<?php

namespace App\Manager;


use App\Service\TableService;

class TableManager extends AbstractManager
{
    protected TableService $tableService;

    public function __construct(
        TableService $tableService
    ) {
        $this->tableService = $tableService;
    }

    public function get(){

    }
}