<?php

$userMenu = [
    ['title' => 'Dashboard', 'icon' => 'home', 'url' => '/dashboard/home/index'],
   ['title'=> 'Banners', 'icon'=>'image', 'url'=>'/dashboard/banner/index'],
   ['title'=> 'Blogs', 'icon'=>'newspaper', 'url'=>'/dashboard/blog/index'],
   ['title'=> 'Menu Categories', 'icon'=>'list', 'url'=>'/dashboard/menu-category/index'],
   ['title'=> 'Food Menus', 'icon'=>'utensils', 'url'=>'/dashboard/food-menu/index'],
    ['title' => 'IAM & Admin', 'icon' => 'shield', 'submenus' => [
        ['title' => 'User Management', 'url' => 'profile/index'],
        ['title' => 'Manage Roles', 'url' => 'role/index'],
        ['title' => 'Manage Permissions', 'url' => 'permission/index'],
    ]],
   ['title' => 'Settings', 'icon' => 'cog fa-spin', 'submenus' => [
        ['title' => 'General Settings', 'url' => '/admin/settings/general-setting'],
        ['title' => 'Email Settings', 'url' => '/admin/settings/email-setting'],
      
    ]],
];
return array_merge($userMenu,);
