<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/3 0003
 * Time: 20:50
 */
header("Content-type: text/html; charset=utf-8");
class testControl {
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
    $param['goods_spec'] = $_GET['spec'];

    //处理代金券

    $logic_buy = logic('buy');

    //得到会员等级
    $model_member = Model('member');

    $result = $logic_buy->buyStep2($param, $this->member_info['member_id'], $this->member_info['member_name'], $this->member_info['member_email'],1,1);

}
public function totalOp($id = 1,$begindate = '2018-03-30',$enddate = '2018-03-31'){
    $condition = array();
    $condition['goods_id'] = $id;
    $model_hotel = Model('hotel');
    $total= $model_hotel->totalprice($condition,$begindate,$enddate);
    echo $total;


}
public function ttOp(){
    $begindate = '2018-03-30';
    $enddate = '2018-03-31';
    $condition['goods_id'] =15;
    $tmp_amount = 0;
    $model_goods = Model('goods');
    $model_hotel = Model('hotel');
    $goods_info = $model_goods->getGoodsList($condition);

     foreach ($goods_info as $v){
    if($v['gc_id_2'] == '4'){
        $id= $v['goods_commonid'];

        $store_cart['goods_total']=ncPriceFormat( $model_hotel->totalprice($id,$begindate,$enddate));
        $tmp_amount += $store_cart['goods_total'];}
}
    echo $tmp_amount;
}
public function xxOp(){
    echo 123;
  $buy_logic = Logic('buy_1');
  $arrat = array();
  $arrat[0]["goods_num"] = 1;$arrat[0]["goods_id"] = 15;$arrat[0]["goods_commonid"] = 1;$arrat[0]["gc_id"]=1057;$arrat[0]["store_id"]=1;$arrat[0]["goods_name"]='酒店';$arrat[0]["goods_price"]=233;$arrat[0]["store_name"]="官方店铺";$arrat[0]["goods_image"]="1_05737904959336150.png";$arrat[0]["transport_id"]=0;$arrat[0]["goods_freight"]="0.00";$arrat[0]["goods_trans_v"]="0.00";$arrat[0]["goods_vat"]="1";$arrat[0]["goods_storage"]="9";$arrat[0]["goods_storage_alarm"]="0";$arrat[0]["is_fcode"]="0";
                                                                                                                                                                                                                                                                                                                                                                                                                       $arrat[0]["have_gift"]="0"; $arrat[0]["state"]=true; $arrat[0]["storage_state"]=true;  $arrat[0]["groupbuy_info"]=null;  $arrat[0]["xianshi_info"]=null;$arrat[0]["is_chain"]=0;   $arrat[0]["is_book"]=0; $arrat[0]["book_down_payment"]="0.00";$arrat[0]["book_final_payment"]="0.00";$arrat[0]["book_down_time"]="0";$arrat[0]["cart_id"]=15;$arrat[0]["bl_id"]=0;$arrat[0]["goods_spec"]="abc";$arrat[0]["contractlist"]=[];$arrat[0]["goods_total"]="391.00";$arrat[0]["goods_image_url"]="http:\/\/172.16.0.162\/data\/upload\/shop\/store\/goods\/1\/1_05737904959336150_240.png";
//    $arrat = json_decode( '{"1":[{"goods_num":1,"goods_id":15,"goods_commonid":"1","gc_id":"1057","store_id":"1","goods_name":"酒店 ","goods_price":"391.00","store_name":"官方店铺","goods_image":"1_05737904959336150.png","transport_id":"0","goods_freight":"0.00","goods_trans_v":"0.00","goods_vat":"1","goods_storage":"9","goods_storage_alarm":"0","is_fcode":"0","have_gift":"0","state":true,"storage_state":true,                                     "groupbuy_info":null,"xianshi_info":null,"is_chain":"0","                               is_book":"0","book_down_payment":"0.00","book_final_payment":"0.00","book_down_time":"0","cart_id":15,"bl_id":0,"goods_spec":"a:2:{i:9;s:9:"2018-3-20";i:5;s:10:"2018-03-31";}","contractlist":[],"goods_total":"391.00","goods_image_url":"http:\/\/172.16.0.162\/data\/upload\/shop\/store\/goods\/1\/1_05737904959336150_240.png"}]}')
    $result = $buy_logic->calcCartList($arrat,'2018-03-30','2018-03-31');
    print_r($result) ;

}
    public function priceOp(){
        $condition['goods_id'] =json_decode($_COOKIE['getHotelPrice'])->goods_id;
//      $tmp_amount = 0;

        $model_goods = Model('goods');
        $goods_info = $model_goods->getGoodinfo_new($condition);
        $tmp_amount = $model_goods->getGoodsNewPrice($goods_info,1);

        //$result['success'] = true;
        //$result['data']['price'] = ncPriceFormat($goods_info["goods_price"]);
//  $goods_info = $model_goods->getGoodinfo_new($condition);




//      $model_hotel = Model('hotel');
//      $condition2['goods_id'] = $goods_info['goods_commonid'];
//      $hotellist = $model_hotel->getHotelList($condition2);
//      foreach ($hotellist as $v){
//            if($v['date']>=$begindate && $v['date']<=$enddate){
//                $tmp_amount += $v['hotel_baseprice']+$v['hotel_plusprice'];
//            }
//
//        }
        if($tmp_amount){
            $result['success'] = true;
            $result['data']['price'] = ncPriceFormat($tmp_amount);
        }
        else{
            $result['success'] = false;
        }


        echo json_encode($result);
      }
    public function timeOp(){
        $model_member1 = Model('member');
        //$model_member1->editMember(array('member_id'=> $_SESSION['member_id'] ),array('weixin_info'=>json_decode($_COOKIE['getHotelPrice'])->end));
        //
        $json = $model_member1->getMembercookie(5);
        $data = json_decode(stripslashes(html_entity_decode($json)) , true);
        var_dump($data['startDate']) ;
//        $begindate = $data['startDate'];
//        $enddate = $data['endDate'];
//        $Stype = $data['stype'];
//        $begindate1 =json_decode($_COOKIE['getHotelPrice1'])->start;
//        if ($begindate1 ==null) {
//            $begindate1 =date("Y-m-d");
//            $enddate  =date("Y-m-d",strtotime("+1 day"));
//        }
//        var_dump( $begindate1 );
//        var_dump( $enddate );

    }
    public function changepriceOp(){
    echo $_GET['a'];
//        $begindate = $_POST["beginDate"];
//
//        $enddate = $_POST["endDate"];
//        $conditon['goods_id'] =$_POST["good_id"];
//        echo  $_POST["beginDate"];
//        echo $_POST["endDate"];
//        echo $_POST["good_id"];

//        echo $begindate;
//        $begindate = '2018-04-09';
//        $enddate = '2018-04-11';
//        $conditon['goods_id'] =15;
//
//
//
//        $model_goods = Model('goods');
//        $goodinfo = $model_goods -> getGoodinfo_new($conditon);
//        $model_hotel = Model('hotel');
//        $condition2['goods_id']= $goodinfo['goods_commonid'];
//        $hotellist = $model_hotel->getHotelList($condition2);
//        //$condition['id'] = array(between,array('1','8'));
//        /*               $date =  date("Y-m-d");*/
//
//        if($goodinfo['gc_id_2'] == '4'){
//            $total = 0;
//            foreach ($hotellist as $v) {
//                if ($v['date'] >= $begindate && $v['date'] < $enddate) {
//                    $total += $v['hotel_baseprice'] + $v['hotel_plusprice'];
//                }
//            }
//
//
//
//        }
//        else{
//            $total =$goodinfo['goods_price'];
//
//        }
//
//
//
//
//
//        $hotelprice['goods_price']=$total;
//        echo $total;
//        //output_data($hotelprice);



    }

    public function getGoods_gc_id_1Op(){
   $model_good = Model('goods');
   $field = 'gc_id_1';
   print_r($model_good->getGoodsgcid1List(array(),$field));


    }
   public function saveOp(){
    $model_sellergroup = Model('seller_group_spend');
    $insert = array();
    $insert['id'] = 100;
    $model_sellergroup->getSellerGroupSpendInfo($insert);
   print_r( $model_sellergroup->getSellerGroupSpendInfo($insert));

   }
    public function group_saveOp() {
        $spend_info = array();
        //$spend_info['id'] = 7;
        $spend_info['group_id']=233 ;
        $spend_info['gcid']=1;
        $spend_info['lim']=0;
        //$spend_info['limit']=0;
        //$model_seller_group = Model('seller_group');
        $model_seller_spend = Model('seller_group_spend');
        $condition['id'] = 1;
        $result = $model_seller_spend->addSellerGroupSpend($spend_info);
//        print_r($result);

        //print_r($model_seller_spend->getSellerGroupSpendInfo($condition));
        echo 1231;
        }
    public function groupspOp(){
    $condition = array();
    $info = array();
    $condition['group_id'] = 39;
    $condition['gcid'] = 1;
    $info['spend'] = 233;

    $model = Model('seller_group_spend');
    $model->editSellerGroupSpend($info,$condition);
    echo 111;
    }
    public function delOp(){
    $condition = array();
    $condition['group_id'] = 56;
    $condition['gcid'] = 2;
    $model_spend = Model('seller_group_spend');
        $spend_lim = $model_spend->getSellerGroupSpendInfo($condition);
    var_dump( $spend_lim);
    }

    public function shortOp(){
    $address_model = Model('address');
    $condition['member_id'] = 14;
       $result = $address_model->getAddressList($condition);
       foreach ($result as $k=>$v){
           print_r($v['address']);
       }

    }
    public function addressOp(){
    $order_model = Model('order');
    $condtion['order_id'] = 127;
    $order_info = $order_model -> getOrderInfo($condtion, array('order_common'));

        $daddress_id = $order_info['extend_order_common']['daddress_id'];
        $daddress_info = array();
        $reciver_info = $order_info['extend_order_common']['reciver_info'];

        $print_info['buyer_address'] = $reciver_info['street'];
        print_r($print_info);

    }
    public function companySpendOp(){
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
        print_r($spend);

    }
    public function group_listOp() {
        $model_seller_group = Model('seller_group');
        $model_seller_spend = Model('seller_group_spend');
        $seller_group_list = $model_seller_group->getSellerGroupList(array('store_id' => $_SESSION['store_id']));
        $a = array();
        foreach ($seller_group_list as $k=>$v){
            $cond['group_id'] = $v['group_id'];
            $group_spendList[$k] = $model_seller_spend->getSellerGroupSpendList($cond);
            foreach ($group_spendList as $key=>&$value){
                $value['group_name'] = $v['group_name'];
                $value['store_id'] = $v['store_id'];
            }




        }
        print_r($group_spendList);

}

    public function disOP(){
        $from =  file_get_contents('http://apis.map.qq.com/ws/geocoder/v1/?address=哈尔滨工程大学&key=VZKBZ-F52CP-KRJDH-VZNLY-PRRG5-EFF5U');
        //print_r($from);
        $start = json_decode($from,true);
        $alng  = $start['result']['location']['lng'];
        $alat = $start['result']['location']['lat'];
        $toa = file_get_contents('http://apis.map.qq.com/ws/geocoder/v1/?address=哈尔滨工业大学&key=VZKBZ-F52CP-KRJDH-VZNLY-PRRG5-EFF5U');
        $end = json_decode($toa,true);
        $blng  = $end['result']['location']['lng'];
        $blat = $end['result']['location']['lat'];
        //print_r($blat);
        $distance = file_get_contents('http://apis.map.qq.com/ws/distance/v1/?mode=driving&from='.$alng.','.$alat.'&to='.$blng.','.$blat.'&key=VZKBZ-F52CP-KRJDH-VZNLY-PRRG5-EFF5U');
        print_r($distance);


    }

    public function sellerOP(){
        $model_seller = Model('seller');
        $condition = array(
            'store_id' => 4,
            'seller_group_id' => array('gt', 0)
        );
        $seller_list = $model_seller->getSellerList($condition);
        Tpl::output('seller_list', $seller_list);

        if (!empty($seller_list)) {
            $memberid_array = array();
            foreach ($seller_list as $val) {
                $memberid_array[] = $val['member_id'];
            }
            $member_name_array = Model('member')->getMemberList(array('member_id' => array('in', $memberid_array)), 'member_id,member_name');
            $member_name_array = array_under_reset($member_name_array, 'member_id');


            $model_seller_group = Model('seller_group');
            $seller_group_list = $model_seller_group->getSellerGroupList(array('store_id' => $_SESSION['store_id']));
            $seller_group_array = array_under_reset($seller_group_list, 'group_id');

        }
        var_dump($seller_group_list);
    }

}?>