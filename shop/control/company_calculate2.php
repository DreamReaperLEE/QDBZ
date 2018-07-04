<?php
/**
 * 买家 我的实物订单
 * * @好商城 (c) 2015-2018 33HAO Inc. (http://www.33hao.com)
 * @license    http://www.33 hao.c om
 * @link       交流群号：138182377
 * @since      好商城提供技术支持 授权请购买shopnc授权
 */



defined('In33hao') or exit('Access Invalid!');

class company_calculate2Control extends BaseCompanyControl {

    public function __construct() {
        parent::__construct();
        Language::read('member_store_index');
    }



    public function companySpend2Op(){
        $condtion1['buyer_id'] = $_SESSION['member_id'];
        $model_order = Model('order');
        $address_model = Model('address');
        $condtion['member_id'] = $_SESSION['member_id'];
        $orderlist = $model_order->getOrderList($condtion1);
        $addresslist = $address_model->getAddressList($condtion);
        $spend = array();
        foreach ($orderlist as $k=>$v){
            $condtion2['order_id'] = $v['order_id'];
            $order_info = $model_order -> getOrderInfo($condtion2, array('order_common'));
            $reciver_info = $order_info['extend_order_common']['reciver_info'];
            $spend_info['buyer_address'] = $reciver_info['street'];
            foreach ($addresslist as $key=>$value){
                $program  =$value['address'];

                if ($value['address'] == $spend_info['buyer_address']){
                    $spend[$program] += $v['goods_amount'];
                }
            }



        }
        Tpl::output('json',json_encode($spend));
        Tpl::showpage('programcalculate.list');

    }
}
