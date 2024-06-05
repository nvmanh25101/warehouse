<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    public string $ControllerName = 'Nhà cung cấp';

    public function __construct()
    {
        $pageTitle = Route::currentRouteAction();
        $pageTitle = explode('@', $pageTitle)[1];
        view()->share('ControllerName', $this->ControllerName);
        view()->share('pageTitle', $pageTitle);
    }

    public function index()
    {
        return view('suppliers.index');
    }

    public function api()
    {
        return DataTables::of(Customer::query()->where('type', '=', CustomerTypeEnum::NHA_CUNG_CAP))
            ->addColumn('edit', function ($object) {
                return route('suppliers.edit', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('suppliers.destroy', $object);
            })
            ->make(true);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $arr = $request->validated();
        $arr['type'] = CustomerTypeEnum::NHA_CUNG_CAP;

        if (Customer::query()->create($arr)) {
            return redirect()->route('suppliers.index')->with(['success' => 'Thêm mới thành công']);
        }

        return redirect()->back()->withErrors('message', 'Thêm mới thất bại');
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function edit($supplierId)
    {
        $supplier = Customer::query()->findOrFail($supplierId);

        return view(
            'suppliers.edit',
            [
                'supplier' => $supplier,
            ]
        );
    }

    public function destroy($supplierId)
    {
        Customer::destroy($supplierId);

        return response()->json([
            'success' => 'Xóa thành công',
        ]);
    }

    public function update(UpdateRequest $request, $supplierId)
    {
        $supplier = Customer::query()->findOrFail($supplierId);

        if ($supplier->update($request->validated())) {
            return redirect()->route('suppliers.index')->with(['success' => 'Cập nhật thành công']);
        }
        return redirect()->back()->withErrors('message', 'Cập nhật thất bại');
    }
}
