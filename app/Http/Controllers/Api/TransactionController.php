<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotsearch;
use App\Models\Transaction;

/**
 * Class TransactionController
 *
 * @package App\Http\Controllers\Api
 */
class TransactionController extends ApiController
{
    public function index()
    {
        $builder = Transaction::where('date', '>', date('Y-m-d', strtotime('-30 days')))->orderBy('date')->take(60);
        $days           = $builder->pluck('date')->toArray();
        $total_house    = $builder->pluck('total_house')->toArray();
        $total_area     = $builder->pluck('total_area')->toArray();
        $latest = Transaction::orderBy('date', 'desc')->first();

        return $this->success([
            'days' => $days,
            'total_house' => $total_house,
            'total_area' => $total_area,
            'latest' => $latest
        ]);
    }
}
