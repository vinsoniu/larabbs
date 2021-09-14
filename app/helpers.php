<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 通过判断『路由命名』和『路由参数』为导航栏添加 active 类
 * 使用类库：summerblue/laravel-active:6.*
 * @param $category_id
 * @return string
 */
function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}
