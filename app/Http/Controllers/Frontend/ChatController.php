<?php
/**
 * Created by PhpStorm.
 * User: Cheney
 * Date: 2018/5/27
 * Time: 16:00
 */

namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends BasicController
{

    /**
     * 聊天室首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('frontend.chat-list', compact('user'));
    }
}