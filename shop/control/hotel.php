<?php
/**
 * 聊天记录查询
 *
 *
 *
 * * @好商城 (c) 2015-2018 33HAO Inc. (http://www.33hao.com)
 * @license    http://www.33 hao.c om
 * @link       交流群号：138182377
 * @since      好商城提供技术支持 授权请购买shopnc授权
 */



defined('In33hao') or exit('Access Invalid!');

class hotelControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct ();
        Language::read ('member_store_goods_index');
    }
//    public function my_json_decode($str) {
//
//        // if (preg_match('/\"\w\":/', $str)) {
//        //     $str = preg_replace('/\"(\w+)\":/is', '$1:', $str);    //给key加双引号
//        // }
//        $str = preg_replace('/"(\w+)"(\s*:\s*)/is', '$1$2', $str);   //去掉key的双引号
//        return $str;
//    }
    public function edit_hotelOp() {
        $common_id = $_GET['commonid'];
        $model_hotel = Model('hotel');
        $where=array();
        $where['goods_id'] = $common_id;
        $transport = $model_hotel->getHotelList($where);
        if (!empty($transport) && is_array($transport)) {
            $hoteldate=  json_encode($transport);

        }
        else{$hoteldate = null;
            //todo
        }
        Tpl::output('common_id',$common_id);
        Tpl::output('hotel',  preg_replace('/"(\w+)"(\s*:\s*)/is', '$1$2', $hoteldate));//去键名双引号
        Tpl::showpage('hotellist');
    }
    //发送酒店日期价格
    public function save_hotelOp(){
        $hoteldate = $_POST['data'];
      //  print_r($hoteldate);
        $common_id = $_POST['common_id'];
        print_r($common_id);
        $model_hotel = Model('hotel');
        $condition = array();

        foreach ($hoteldate as $v){
            $v['goods_id']=$common_id;
            print_r($v);
            $condition['date'] = $v['date'];
            $condition['goods_id']=$common_id;
            $list= $model_hotel->getHotelList($condition);
            print_r($list);
            if(empty($list)){
                $model_hotel->addHotelDate($v);
            }
            else{
                $model_hotel->editHotelDate($condition,$v);
            }
        }


    }
}
