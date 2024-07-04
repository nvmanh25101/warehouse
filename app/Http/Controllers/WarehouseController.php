<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Enums\WarningEnum;
use App\Exports\WarehousesExport;
use App\Http\Requests\WarehouseRequest;
use App\Models\Customer;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class WarehouseController extends Controller
{
    public string $ControllerName = 'Tồn kho';

    public function __construct()
    {
        $pageTitle = Route::currentRouteAction();
        $pageTitle = explode('@', $pageTitle)[1];
        view()->share('ControllerName', $this->ControllerName);
        view()->share('pageTitle', $pageTitle);
    }

    public function index()
    {
        $warnings = WarningEnum::getArrayView();

        return view('warehouse.index', [
            'warnings' => $warnings,
        ]);
    }

    public function api()
    {
        return DataTables::of(Warehouse::query()->with(['product', 'exports']))
            ->addColumn('name', function ($object) {
                return $object->product()->withTrashed()->first()->name;
            })
            ->addColumn('warning', function ($object) {
                return $object->warning;
            })
            ->addColumn('edit', function ($object) {
                return route('warehouses.edit', $object);
            })
            ->filterColumn('warning', function ($query, $keyword) {
                if ($keyword === '0') {
                    $query->whereColumn('quantity', '<=', 'threshold');
                } elseif ($keyword === '1') {
                    $query->whereColumn('quantity', '>', 'threshold');
                }
            })
            ->make(true);
    }

    public function edit($warehouseId)
    {
        $suppliers = Customer::query()->where('type', '=', CustomerTypeEnum::NHA_CUNG_CAP)
            ->get(['id', 'name']);

        $warehouse = Warehouse::query()->with('product')->findOrFail($warehouseId);

        return view(
            'warehouse.edit',
            [
                'product' => $warehouse->product()->withTrashed()->first(),
                'warehouse' => $warehouse,
                'suppliers' => $suppliers,
            ]
        );
    }

    public function update(WarehouseRequest $request, $warehouseId)
    {
        $warehouse = Warehouse::query()->findOrFail($warehouseId);
        $warehouse->update($request->validated());

        return redirect()->route('warehouses.index')->with(['success' => 'Cập nhật thành công']);
    }

    public function export()
    {
        return Excel::download(new WarehousesExport(), 'warehouses.xlsx');
    }
}
