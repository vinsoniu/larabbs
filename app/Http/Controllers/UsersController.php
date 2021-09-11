<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        // 使用Auth中间件来过滤未登录用户的edit、update操作
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {
        // 检验用户是否授权 - authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据
        // 默认情况下，我们不需要传递第一个参数，也就是当前登录用户至该方法内，因为框架会自动加载当前登录用户。
        $this->authorize('update', $user); // 这里 update 是指授权类里的 update 授权方法

        return view('users.edit',compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user); // 授权验证
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success','个人资料更新成功');
    }
}
