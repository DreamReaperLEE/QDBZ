<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/3 0003
 * Time: 20:50
 */
class testControl extends mobileMemberControl{
public function tryOp() {
    $param = array();
    $param['ifcart'] = 1;
//    $param['cart_id'] = explode(',', $_POST['cart_id']);
    $param['address_id'] = 2;
    $param['vat_hash'] = 3;
    $param['offpay_hash'] = 3;
    $param['offpay_hash_batch'] = 3;
    $param['pay_name'] = 3;
    $param['invoice_id'] = 3;
    $param['rpt'] = 3;
    $param['spec_r'] = $_GET['spec'];

    //处理代金券

    $logic_buy = logic('buy');

    //得到会员等级
    $model_member = Model('member');

    $result = $logic_buy->buyStep2($param,1,1,1,1,1);

}  }?>