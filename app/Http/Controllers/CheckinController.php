<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Cache;


class CheckinController extends Controller
{
    const CACHE_KEY = 'checkin_list';

    // 签到
    function checkin($id) {
        $user = User::find($id);
        if ($user != null) {
            $user['checkin'] = true;
            $user->save();
            Cache::forget(CheckinController::CACHE_KEY);
            return ['status' => 'success'];
        } else {
            return ['status' => 'failed'];
        }
    }

    // 查询当前签到情况
    function queryCheckin() {
        if (Cache::has(CheckinController::CACHE_KEY)) {
            $list = Cache::get(CheckinController::CACHE_KEY, null);
            if ($list != null) {
                return $list;
            }
        }

        $users = DB::table('users')
            ->where('checkin', 1)
            ->select('id')
            ->get()
            ->pluck('id');
        Cache::add(CheckinController::CACHE_KEY, $users, 5);
        return $users;
    }



    // 全部签到，慎用！
    function all() {
        DB::table('users')
            ->update(['checkin' => 1]);
        Cache::forget(CheckinController::CACHE_KEY);
        return ['status' => 'success'];
    }


    // 全部重置为未签到！慎用
    function reset() {
        DB::table('users')
            ->update(['checkin' => 0]);
        Cache::forget(CheckinController::CACHE_KEY);
        return ['status' => 'success'];
    }
}
