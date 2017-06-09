<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
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

        $result = [];
        $users = DB::table('users')
            ->select('id', 'checkin')
            ->get();
        foreach ($users as $user) {
            $result[$user->id] = $user->checkin;
        }
        Cache::add(CheckinController::CACHE_KEY, $result, 5);
        return $result;
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

    function user($id = null) {
        $time = new Carbon("2017-6-10 18:30:00", "Asia/Shanghai");
        if (Carbon::now("Asia/Shanghai") < $time) {
            print Carbon::now("Asia/Shanghai");
            return redirect('/soon/index.html');
        }

        if ($id != null) {
            $user = User::find($id);
            if ($user != null) {
                $this->checkin($user->id);
                return redirect('/mobile/user.html?id=' . $user->id . '&name=' . $user->name);
            }
        }
        return redirect('/mobile/user.html');
    }

    function ticket($id = null) {
        if ($id != null) {
            $user = User::find($id);
            if ($user != null) {
                return view('ticket', ['id' => $user->id, 'name' => $user->name]);
            }
        }
    }

}
