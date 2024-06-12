<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class ProfileController extends Controller
{
    public string $ControllerName = 'Tài khoản';

    public function __construct()
    {
        $pageTitle = Route::currentRouteAction();
        $pageTitle = explode('@', $pageTitle)[1];
        view()->share('ControllerName', $this->ControllerName);
        view()->share('pageTitle', $pageTitle);
    }

    public function edit($userId)
    {
        $user = User::query()->findOrFail($userId);

        return view(
            'profile',
            [
                'user' => $user,
            ]
        );
    }

    public function update(UpdateRequest $request, $userId)
    {
        $user = User::query()->findOrFail($userId);

        if ($user->update($request->validated())) {
            return redirect()->route('profiles.index')->with(['success' => 'Cập nhật thành công']);
        }
        return redirect()->back()->withErrors('message', 'Cập nhật thất bại');
    }
}
