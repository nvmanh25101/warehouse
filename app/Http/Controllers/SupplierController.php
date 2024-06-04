<?php

namespace App\Http\Controllers;

use App\Enums\CustomerTypeEnum;
use App\Http\Requests\Customer\StoreRequest;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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
