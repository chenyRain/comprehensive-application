<?php
/**
 * Created by PhpStorm.
 * User: Cheney
 * Date: 2018/5/23
 * Time: 22:44
 */

namespace App\Http\Controllers\Frontend;


use App\Models\Comments;
use App\Models\Like;
use App\Models\Like_user;
use App\Models\Modules;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class MainController extends BasicController
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // 获取应用信息
        $modules = Modules::where('is_show', 1)->orderBy('sort', 'desc')->get()->toArray();

        // 获取用户是否点赞
        $like = DB::table('like_user as lu')
            ->select('l.m_id', 'lu.uid')
            ->join('like as l', 'lu.lid', 'l.id')
            ->where('lu.uid', Auth::id())
            ->get();
        $m_id = array_column($like->toArray(), 'm_id');

        // 每个应用点赞数和当前账户是否点赞
        foreach ($modules as $key => $value) {
            // 获取点赞数
            $like_num = Like::select('like_num')->where('m_id', $value['id'])->first();
            $modules[$key]['like_num'] = $like_num['like_num'];

            // 评论数
            $modules[$key]['comments_num'] = Comments::where('m_id', $value['id'])->count();

            // 该用户是否点赞过
            $modules[$key]['is_like'] = '';
            if (in_array($value['id'], $m_id)) {
                $modules[$key]['is_like'] = 'already-like';
            }
        }

        return view('frontend.index', compact('user', 'modules'));
    }


    /**
     * 点赞
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request)
    {
        $m_id = intval($request->input('m_id'));
        try {
            if (empty($m_id)) {
                throw new \Exception('参数错误！');
            }

            // 设置频率
            $redis_like_key = config('frontend.index_like_key').$m_id.':'.Auth::id();
            if (! empty(Redis::get($redis_like_key))) {
                throw new \Exception('操作太频繁了！');
            }

            // 添加点赞数
            $info = Like::where('m_id', $m_id)->first();
            if (empty($info)) {
                // 添加点赞数
                $insert_id = Like::insertGetId(['m_id' => $m_id, 'like_num' => 1, 'ctime' => Carbon::now()]);
                // 添加点赞人
                $res = Like_user::insert(['lid' => $insert_id, 'uid' => Auth::id(), 'ctime' => Carbon::now()]);
            } else {
                // 自增
                $res = Like::where('m_id', $m_id)->increment('like_num');
                // 用户是否点赞
                $is_like = Like_user::where([['lid', $info->id], ['uid', Auth::id()]])->first();
                if (empty($is_like)) {
                    // 添加点赞人
                    $res = Like_user::insert(['lid' => $info->id, 'uid' => Auth::id(), 'ctime' => Carbon::now()]);
                }
            }

            if (empty($res)) {
                throw new \Exception('操作失败！');
            }

            // 设置访问频率
            Redis::setex($redis_like_key, config('frontend.index_like_time'), config('frontend.index_like_time'));

            $this->jsonRes['code'] = 1;
        } catch (\Exception $e) {
            $this->jsonRes['msg'] = $e->getMessage();
        }
        return response()->json($this->jsonRes);
    }
}