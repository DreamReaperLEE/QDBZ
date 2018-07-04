<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29 0029
 * Time: 19:52
 */


defined('In33hao') or exit('Access Invalid!');
class hotelModel extends Model{
    public function __construct() {
        parent::__construct('hotel');
    }


    public function addHotelDate($insert) {
        $result = $this->table('hotel')->insert($insert);

        return $result;
    }
    public function editHotelDate($condition, $update) {
        return $this->where($condition)->update($update);
    }

    public function getHotelList($condition, $order=''){
        return $this->table('hotel')->where($condition)->order($order)->select();
    }
    //获得宾馆列表
}