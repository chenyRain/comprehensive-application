<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeckillGoods extends Model
{
    protected $table = 'seckill_goods'; // 设置表名

    public $timestamps = false; // 关闭自动维护 created_at 和 updated_at 字段


    /**
     * 设置秒杀商品信息
     * @param $objGoods
     * @param $data
     */
    public static function updateGoods($goods_id, $data)
    {
        $objGoods = SeckillGoods::find($goods_id);
        $objGoods->start_time = $data['datetime_picker_start'];
        $objGoods->start_time = $data['datetime_picker_start'];
        $objGoods->end_time = $data['datetime_picker_end'];
        $objGoods->repertory = $data['repertory'];
        $objGoods->redis_max_user = $data['redis_max_user'];
        $objGoods->status = $data['status'];

        $objGoods->save();
    }
}
