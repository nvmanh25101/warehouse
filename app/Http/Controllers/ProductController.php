<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public string $ControllerName = 'Sản phẩm';

    public function __construct()
    {
        $pageTitle = Route::currentRouteAction();
        $pageTitle = explode('@', $pageTitle)[1];
        view()->share('ControllerName', $this->ControllerName);
        view()->share('pageTitle', $pageTitle);
    }

    public function index()
    {
        return view('products.index');
    }

    public function api()
    {
        return DataTables::of(Product::query())
            ->editColumn('name', function ($object) {
                $link = route('products.edit', $object);
                return "<a href='$link'>$object->name</a>";
            })
            ->addColumn('edit', function ($object) {
                return route('products.edit', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('products.destroy', $object);
            })
            ->rawColumns(['name'])
            ->make();
    }

    public function edit($productId)
    {
        $suppliers = Customer::query()->where('type', '=', CustomerTypeEnum::NHA_CUNG_CAP)
            ->get(['id', 'name']);

        $product = Product::query()->findOrFail($productId);

        return view(
            'products.edit',
            [
                'product' => $product,
                'suppliers' => $suppliers,
            ]
        );
    }

    public function destroy($productId)
    {
        Product::destroy($productId);

        return response()->json([
            'success' => 'Xóa thành công',
        ]);
    }

    public function update(UpdateRequest $request, $productId)
    {
        $product = Product::query()->findOrFail($productId);
        $arr = $request->validated();
        if ($request->hasFile('image')) {
            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $path = $request->file('image')->store('images');
            $arr['image'] = $path;
        }
        $product->fill($arr);

        if ($product->save()) {
            return redirect()->route('products.index')->with(['success' => 'Cập nhật thành công']);
        }
        return redirect()->back()->withErrors('message', 'Cập nhật thất bại');
    }

    public function store(StoreRequest $request)
    {
        $path = $request->file('image')->store('images');
        $arr = $request->validated();
        $arr['image'] = $path;
        $product = Product::query()->create($arr);
        if ($product) {
            return redirect()->route('products.index')->with(['success' => 'Thêm mới thành công']);
        }
        return redirect()->back()->withErrors('message', 'Thêm mới thất bại');
    }

    public function create()
    {
        $suppliers = Customer::query()->where('type', '=', CustomerTypeEnum::NHA_CUNG_CAP)
            ->get(['id', 'name']);

        return view('products.create', ['suppliers' => $suppliers]);
    }
}
