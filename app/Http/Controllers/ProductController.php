<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->addColumn('edit', function ($object) {
                return route('products.edit', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('products.destroy', $object);
            })
            ->make(true);
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

    public function edit($productId)
    {
        $categories = Category::query()->where('status', '=', StatusEnum::HOAT_DONG)
            ->where('type', '=', TypeEnum::SAN_PHAM)
            ->get(['id', 'name']);
        $product = Product::query()->findOrFail($productId);
        $reviews = $product->reviews()->with('customer')->get();

        return view(
            'admin.products.edit',
            [
                'product' => $product,
                'categories' => $categories,
                'reviews' => $reviews,
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

    public function review(Request $request, $id, $reviewId)
    {
        $product = Product::query()->findOrFail($id);
        $review = $product->reviews()->findOrFail($reviewId);
        $review->update([
            'reply' => $request->get('reply'),
            'admin_id' => Auth::guard('admin')->user()->id,
        ]);

        return redirect()->back()->with(['success' => 'Phản hồi thành công']);
    }

    public function update(UpdateRequest $request, $productId)
    {
        $product = Product::query()->findOrFail($productId);
        $arr = $request->validated();
        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = Storage::disk('public')->putFile('images', $request->file('image'));
            $arr['image'] = $path;
        }
        $product->fill($arr);

        if ($product->save()) {
            return redirect()->route('admin.products.index')->with(['success' => 'Cập nhật thành công']);
        }
        return redirect()->back()->withErrors('message', 'Cập nhật thất bại');
    }
}
