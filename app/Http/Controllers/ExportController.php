<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Http\Requests\Export\StoreRequest;
use App\Models\Customer;
use App\Models\Export;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class ExportController extends Controller
{
    public string $ControllerName = 'Phiếu xuất';

    public function __construct()
    {
        $pageTitle = Route::currentRouteAction();
        $pageTitle = explode('@', $pageTitle)[1];
        view()->share('ControllerName', $this->ControllerName);
        view()->share('pageTitle', $pageTitle);
    }

    public function index()
    {
        return view('exports.index');
    }

    public function api()
    {
        return DataTables::of(Export::query())
            ->addColumn('user_name', function ($object) {
                return $object->user_name;
            })
            ->addColumn('customer_name', function ($object) {
                return $object->customer_name;
            })
            ->addColumn('edit', function ($object) {
                return route('exports.edit', $object);
            })
            ->make(true);
    }

    public function store(StoreRequest $request)
    {
        $request = $request->validated();
        $request['user_id'] = auth()->id();

        DB::beginTransaction();
        try {
            $export = Export::query()->create($request);
            $quantities = $request['quantities'];
            $product_ids = $request['product_ids'];
            $productsData = [];

            $stock = Warehouse::query()->whereIn('id', $product_ids)->get()->pluck('quantity', 'id');
            foreach ($product_ids as $index => $product_id) {
                if ($stock[$product_id] < $quantities[$index]) {
                    return redirect()->back()->withErrors('message', 'Số lượng sản phẩm không đủ');
                }
            }
            foreach ($product_ids as $index => $product_id) {
                $productsData[] = [
                    "id" => (int) $product_id,
                    "quantity" => (int) $quantities[$index]
                ];
            }

            $products = [];
            foreach ($productsData as $product) {
                $products[$product['id']] = ['quantity' => $product['quantity']];
                Warehouse::query()->where('id', $product['id'])->decrement('quantity', $product['quantity']);
            }

            $export->warehouses()->attach($products);

            DB::commit();

            return redirect()->route('exports.index')->with(['success' => 'Tạo mới thành công']);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors('message', 'Tạo mới thất bại');
        }
    }

    public function create()
    {
        $warehouses = Warehouse::with('product')->get();
        $customers = Customer::query()->where('type', CustomerTypeEnum::KHACH_HANG)->get();

        return view('exports.create', [
            'warehouses' => $warehouses,
            'customers' => $customers,
        ]);
    }

    public function edit($orderId)
    {
        deleteNoti($orderId, NotiType::DON_HANG);

        $employees = Admin::query()->where('role', '=', AdminType::VAN_CHUYEN)
            ->get(['id', 'name']);
        $order = Order::query()->with('voucher')->findOrFail($orderId);

        return view(
            'admin.orders.edit',
            [
                'order' => $order,
                'employees' => $employees,
            ]
        );
    }

    public function update(UpdateRequest $request, $orderId)
    {
        $order = Order::query()->findOrFail($orderId);
        $arr = $request->validated();
        if ($arr['status'] == OrderStatusEnum::DANG_GIAO) {
            $arr['delivered_at'] = now();
        }
        $order->fill($arr);
        if ($order->save()) {
            if ($arr['status'] == OrderStatusEnum::DA_HUY) {
                foreach ($order->products as $product) {
                    Product::query()->where('id', $product->id)->increment('quantity', $product->pivot->quantity);
                    Product::query()->where('id', $product->id)->decrement('sold', $product->pivot->quantity);
                }
            }

            return redirect()->back()->with(['success' => 'Cập nhật thành công']);
        }
        return redirect()->back()->withErrors('message', 'Cập nhật thất bại');
    }

}
