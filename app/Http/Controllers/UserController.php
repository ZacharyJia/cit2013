<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function user($id = null) {
        if ($id != null) {
            $user = User::find($id);
            if ($user != null) {
                return redirect('/mobile/user.html?id=' . $user->id . '&name=' . $user->name);
            }
        }
        return redirect('/mobile/user.html');
    }
}
