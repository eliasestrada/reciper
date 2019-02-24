<?php

namespace App\Repos;

use Illuminate\Database\QueryException;
use App\Models\Visitor;

class VisitorRepo
{
    /**
     * Return id of the visitor by given ip address, if no ip provided
     * then take ip from request
     * 
     * @param string|null $ip
     * @return int|null
     */
    public function getVisitorId(?string $ip = null): ?int
    {
        try {
            return Visitor::whereIp($ip ?? request()->ip())->value('id');
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }
}