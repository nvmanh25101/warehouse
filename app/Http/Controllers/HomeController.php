<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    public function index()
    {
        return view('layouts.home');
    }

    public function statistic()
    {
        return view('statistic');
    }

    public function api()
    {
        return DataTables::of(Warehouse::query())
            ->addColumn('name', function ($object) {
                return $object->product()->withTrashed()->first()->name;
            })
            ->addColumn('warning', function ($object) {
                return $object->warning;
            })
            ->addColumn('export_quantity', function ($object) {
                return $object->exports->sum('pivot.quantity');
            })
            ->make(true);
    }
}
