<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 用户更新时的权限验证
     * @param User $currentUser 当前登录用户实例
     * @param User $user        要进行授权的用户实例
     * @return bool
     */
    public function update(User $currentUser, User $user)
    {
        // 不需要检查 $currentUser 是不是 NULL，未登录用户，框架会自动为其所有权限返回 false
        // 调用时，默认情况下，我们不需要传递当前登录用户至该方法内，因为框架会自动加载当前登录用户
        
        return $currentUser->id === $user->id;
    }
}
