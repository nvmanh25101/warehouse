<?php

namespace App\Http\Controllers;

use App\Http\Requests\Receipt\StoreRequest;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class ReceiptController extends Controller
{
    public string $ControllerName = 'Phiếu nhập';

    public function __construct()
    {
        $pageTitle = Route::currentRouteAction();
        $pageTitle = explode('@', $pageTitle)[1];
        view()->share('ControllerName', $this->ControllerName);
        view()->share('pageTitle', $pageTitle);
    }

    public function index()
    {
        return view('receipts.index');
    }

    public function api()
    {
        return DataTables::of(Receipt::query())
            ->addColumn('user_name', function ($object) {
                return $object->user_name;
            })
            ->addColumn('edit', function ($object) {
                return route('receipts.edit', $object);
            })
            ->make(true);
    }

    public function store(StoreRequest $request)
    {
        $request = $request->validated();
        $request['user_id'] = auth()->id();

        DB::beginTransaction();
        try {
            $receipt = Receipt::query()->create($request);
            $quantities = $request['quantities'];
            $product_ids = $request['product_ids'];
            $productsData = [];

            $stock = Product::query()->whereIn('id', $product_ids)->get()->pluck('quantity', 'id');
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
                Product::query()->where('id', $product['id'])->decrement('quantity', $product['quantity']);
            }

            $receipt->products()->attach($products);

            $this->handleInsertWarehouse($product_ids, $quantities);

            DB::commit();

            return redirect()->route('receipts.index')->with(['success' => 'Tạo mới thành công']);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors('message', 'Tạo mới thất bại');
        }
    }

    public function create()
    {
        $products = Product::query()->get();

        return view('receipts.create', [
            'products' => $products,
        ]);
    }

    public function handleInsertWarehouse($product_ids, $quantities): bool|int
    {
        $products = [];
        foreach ($product_ids as $index => $product_id) {
            $product_warehouse = Warehouse::query()->where('product_id', $product_id);
            if ($product_warehouse->exists()) {
                return $product_warehouse->increment('quantity', $quantities[$index]);
            }

            $products[] = [
                'product_id' => $product_id,
                'quantity' => $quantities[$index],
                'created_at' => now(),
            ];
        }

        return Warehouse::query()->insert($products);
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
