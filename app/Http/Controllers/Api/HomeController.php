<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chartPenjualanBulanan(Request $request)
    {
        if ($request->tahun) {
            $orders = Order::where('keterangan','Diterima')->whereYear('updated_at',$request->tahun)->get();
        } else {
            $orders = Order::where('keterangan','Diterima')->get();
        }

        $arr = array();
        for ($i=0; $i < $orders->count(); $i++) {
            if (array_key_exists(date_format($orders[$i]->updated_at, "F"),$arr)) {
                $arr[date_format($orders[$i]->updated_at, "F")] = $arr[date_format($orders[$i]->updated_at, "F")] + $orders[$i]->permintaan;
            } else {
                $arr[date_format($orders[$i]->updated_at, "F")] = $orders[$i]->permintaan;
            }
        }
        return response()->json([
            "type" => "bar",
            "data" => [
                "labels" => array_keys($arr),
                "datasets" => [[
                    "label" => "Total Penjualan",
                    "data" => array_values($arr),
                ]],
            ],
            "options" => []
        ]);
    }
}
