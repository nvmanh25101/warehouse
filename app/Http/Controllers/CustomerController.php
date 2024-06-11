<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public string $ControllerName = 'Khách hàng';

    public function __construct()
    {
        $pageTitle = Route::currentRouteAction();
        $pageTitle = explode('@', $pageTitle)[1];
        view()->share('ControllerName', $this->ControllerName);
        view()->share('pageTitle', $pageTitle);
    }

    public function index()
    {
        return view('customers.index');
    }

    public function api()
    {
        return DataTables::of(Customer::query()->where('type', '=', CustomerTypeEnum::KHACH_HANG))
            ->addColumn('edit', function ($object) {
                return route('customers.edit', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('customers.destroy', $object);
            })
            ->make(true);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $arr = $request->validated();
        $arr['type'] = CustomerTypeEnum::KHACH_HANG;

        if (Customer::query()->create($arr)) {
            return redirect()->route('customers.index')->with(['success' => 'Thêm mới thành công']);
        }

        return redirect()->back()->withErrors('message', 'Thêm mới thất bại');
    }

    public function create()
    {
        return view('customers.create');
    }

    public function edit($customerId)
    {
        $customer = Customer::query()->findOrFail($customerId);

        return view(
            'customers.edit',
            [
                'customer' => $customer,
            ]
        );
    }

    public function destroy($customerId)
    {
        Customer::destroy($customerId);

        return response()->json([
            'success' => 'Xóa thành công',
        ]);
    }

    public function update(UpdateRequest $request, $customerId)
    {
        $customer = Customer::query()->findOrFail($customerId);

        if ($customer->update($request->validated())) {
            return redirect()->route('customers.index')->with(['success' => 'Cập nhật thành công']);
        }
        return redirect()->back()->withErrors('message', 'Cập nhật thất bại');
    }
}
