<?php

namespace App\Contracts;

interface TimeLogServiceInterface {

    public function getOrderBy($param,$orderBy);
    public function get($param);
    public function updateTimeLog($logId, array $data);
    public function deleteTimeLog($logId);
}
