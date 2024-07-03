<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public string $ControllerName = 'Nhân viên';

    public function __construct()
    {
        $pageTitle = Route::currentRouteAction();
        $pageTitle = explode('@', $pageTitle)[1];
        view()->share('ControllerName', $this->ControllerName);
        view()->share('pageTitle', $pageTitle);
    }

    public function index()
    {
        return view('users.index');
    }

    public function api()
    {
        return DataTables::of(User::query()->where('id', '!=', auth()->id()))
            ->addColumn('role_name', function ($object) {
                return $object->role_name;
            })
            ->addColumn('edit', function ($object) {
                return route('users.edit', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('users.destroy', $object);
            })
            ->make(true);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $arr = $request->validated();
        $arr['password'] = Hash::make('12345678');

        if (User::query()->create($arr)) {
            return redirect()->route('users.index')->with(['success' => 'Thêm mới thành công']);
        }

        return redirect()->back()->withErrors('message', 'Thêm mới thất bại');
    }

    public function create()
    {
        $roles = UserRoleEnum::getArrayView();

        return view('users.create', [
            'roles' => $roles,
        ]);
    }

    public function edit($userId)
    {
        $user = User::query()->findOrFail($userId);
        $roles = UserRoleEnum::getArrayView();

        return view(
            'users.edit',
            [
                'user' => $user,
                'roles' => $roles,
            ]
        );
    }

    public function destroy($userId)
    {
        User::destroy($userId);

        return response()->json([
            'success' => 'Xóa thành công',
        ]);
    }

    public function update(UpdateRequest $request, $userId)
    {
        $user = User::query()->findOrFail($userId);
        $data = $request->validated();
        if (empty($data['password'])) {
            $data['password'] = $user->password;
        }
        if ($user->update($data)) {
            return redirect()->route('users.index')->with(['success' => 'Cập nhật thành công']);
        }
        return redirect()->back()->withErrors('message', 'Cập nhật thất bại');
    }
}
