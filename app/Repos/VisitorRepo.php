<?php

namespace App\Repos;

use App\Models\Visitor;
use Illuminate\Database\QueryException;

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
            return report_error($e);
        }
    }
}
