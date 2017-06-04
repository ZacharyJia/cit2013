<?php

namespace App\Http\Controllers;

use App\User;

class SelectController extends Controller
{
    function user_list() {
        $boy = User::where('gender', '=', '男')
            ->select(['id', 'name'])
            ->get();
        $girl = User::where('gender', '=', '女')
            ->select(['id', 'name'])
            ->get();
        return [
            'boy' => $boy,
            'girl' => $girl,
        ];
    }
}
