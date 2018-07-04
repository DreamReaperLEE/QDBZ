<?php
/**
 * 卖家账号管理
 *
 *
 *
 * * @好商城 (c) 2015-2018 33HAO Inc. (http://www.33hao.com)
 * @license    http://www.33 hao.c om
 * @link       交流群号：138182377
 * @since      好商城提供技术支持 授权请购买shopnc授权
 */



defined('In33hao') or exit('Access Invalid!');
class store_accountControl extends BaseCompanyControl {
    public function __construct() {
        parent::__construct();
        Language::read('member_store_index');
    }

    public function add_projectOp() {

    }

    public function account_listOp() {
        $model_seller = Model('seller');
        $condition = array(
            'store_id' => $_SESSION['store_id'],
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
            Tpl::output('member_name_array', $member_name_array);

            $model_seller_group = Model('seller_group');
            $seller_group_list = $model_seller_group->getSellerGroupList(array('store_id' => $_SESSION['store_id']));
            $seller_group_array = array_under_reset($seller_group_list, 'group_id');
            Tpl::output('seller_group_array', $seller_group_array);
        }

        $this->profile_menu('account_list');
        Tpl::showpage('store_account.list');
    }

    public function account_addOp() {
        $model_seller_group = Model('seller_group');
        $seller_group_list = $model_seller_group->getSellerGroupList(array('store_id' => $_SESSION['store_id']));
        if (empty($seller_group_list)) {
            showMessage('请先建立账号组', urlShop('store_account_group', 'group_add'), '', 'error');
        }
        Tpl::output('seller_group_list', $seller_group_list);
        $this->profile_menu('account_add');
        Tpl::showpage('store_account.add');
    }

    public function account_editOp() {
        $seller_id = intval($_GET['seller_id']);
        if ($seller_id <= 0) {
            showMessage('参数错误', '', '', 'error');
        }
        $model_seller = Model('seller');
        $seller_info = $model_seller->getSellerInfo(array('seller_id' => $seller_id));
        if (empty($seller_info) || intval($seller_info['store_id']) !== intval($_SESSION['store_id'])) {
            showMessage('账号不存在', '', '', 'error');
        }
        Tpl::output('seller_info', $seller_info);

        $model_seller_group = Model('seller_group');
        $seller_group_list = $model_seller_group->getSellerGroupList(array('store_id' => $_SESSION['store_id']));
        if (empty($seller_group_list)) {
            showMessage('请先建立账号组', urlShop('store_account_group', 'group_add'), '', 'error');
        }
        Tpl::output('seller_group_list', $seller_group_list);

        $this->profile_menu('account_edit');
        Tpl::showpage('store_account.edit');
    }

    public function account_saveOp() {
        $member_name = $_POST['member_name'];
        $password = $_POST['password'];
        $member_info = $this->_check_seller_member($member_name, $password);
        if(!$member_info) {
            showDialog('用户验证失败', 'reload', 'error');
        }

        $seller_name = $_POST['seller_name'];
        if($this->_is_seller_name_exist($seller_name)) {
            showDialog('卖家账号已存在', 'reload', 'error');
        }

        $group_id = intval($_POST['group_id']);

        // 客户端登陆选项判断
        $is_client = 0;
        if(intval($_POST['is_client']) > 0) {
            $is_client = 1;
        }

        $seller_info = array(
            'seller_name' => $seller_name,
            'member_id' => $member_info['member_id'],
            'seller_group_id' => $group_id,
            'store_id' => $_SESSION['store_id'],
            'is_admin' => 0,
            'is_client' => $is_client,
        );
        $model_seller = Model('seller');
        $result = $model_seller->addSeller($seller_info);

        if($result) {
            $this->recordSellerLog('添加账号成功，账号编号'.$result);
            showDialog(Language::get('nc_common_op_succ'), urlShop('store_account', 'account_list'), 'succ');
        } else {
            $this->recordSellerLog('添加账号失败');
            showDialog(Language::get('nc_common_save_fail'), urlShop('store_account', 'account_list'), 'error');
        }
    }

    public function account_edit_saveOp() {
        // 客户端登陆选项判断
        $is_client = 0;
        if(intval($_POST['is_client']) > 0) {
            $is_client = 1;
        }

        $param = array(
            'seller_group_id' => intval($_POST['group_id']),
            'is_client' => $is_client,
        );

        $condition = array(
            'seller_id' => intval($_POST['seller_id']),
            'store_id' =>  $_SESSION['store_id']
        );
        $model_seller = Model('seller');
        $result = $model_seller->editSeller($param, $condition);
        if($result) {
            $this->recordSellerLog('编辑账号成功，账号编号：'.$_POST['seller_id']);
            showDialog(Language::get('nc_common_op_succ'), urlShop('store_account', 'account_list'), 'succ');
        } else {
            $this->recordSellerLog('编辑账号失败，账号编号：'.$_POST['seller_id'], 0);
            showDialog(Language::get('nc_common_save_fail'), urlShop('store_account', 'account_list'), 'error');
        }
    }

    public function account_delOp() {
        $seller_id = intval($_POST['seller_id']);
        if($seller_id > 0) {
            $condition = array();
            $condition['seller_id'] = $seller_id;
            $condition['store_id'] = $_SESSION['store_id'];
            $model_seller = Model('seller');
            $result = $model_seller->delSeller($condition);
            if($result) {
                $this->recordSellerLog('删除账号成功，账号编号'.$seller_id);
                showDialog(Language::get('nc_common_op_succ'),'reload','succ');
            } else {
                $this->recordSellerLog('删除账号失败，账号编号'.$seller_id);
                showDialog(Language::get('nc_common_save_fail'),'reload','error');
            }
        } else {
            showDialog(Language::get('wrong_argument'),'reload','error');
        }
    }

    public function check_seller_name_existOp() {
        $seller_name = $_GET['seller_name'];
        $result = $this->_is_seller_name_exist($seller_name);
        if($result) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    private function _is_seller_name_exist($seller_name) {
        $condition = array();
        $condition['seller_name'] = $seller_name;
        $model_seller = Model('seller');
        return $model_seller->isSellerExist($condition) || Model('store_joinin')->isExist($condition);
    }

    public function check_seller_memberOp() {
        $member_name = $_GET['member_name'];
        $password = $_GET['password'];
        $result = $this->_check_seller_member($member_name, $password);
        if($result) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    private function _check_seller_member($member_name, $password) {
        $member_info = $this->_check_member_password($member_name, $password);
        if($member_info && !$this->_is_seller_member_exist($member_info['member_id'])) {
            return $member_info;
        } else {
            return false;
        }
    }

    private function _check_member_password($member_name, $password) {
        $condition = array();
        $condition['member_name']   = $member_name;
        $condition['member_passwd'] = md5($password);
        $model_member = Model('member');
        $member_info = $model_member->getMemberInfo($condition);
        return $member_info;
    }

    private function _is_seller_member_exist($member_id) {
        $condition = array();
        $condition['member_id'] = $member_id;
        $model_seller = Model('seller');
        return $model_seller->isSellerExist($condition);
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_key   当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_key = '') {
        $menu_array = array();
        $menu_array[] = array(
            'menu_key' => 'account_list',
            'menu_name' => '账号列表',
            'menu_url' => urlShop('store_account', 'account_list')
        );
        if($menu_key === 'account_add') {
            $menu_array[] = array(
                'menu_key'=>'account_add',
                'menu_name' => '添加账号',
                'menu_url' => urlShop('store_account', 'account_add')
            );
        }
        if($menu_key === 'account_edit') {
            $menu_array[] = array(
                'menu_key'=>'account_edit',
                'menu_name' => '编辑账号',
                'menu_url' => urlShop('store_account', 'account_edit')
            );
        }

        Tpl::output('member_menu', $menu_array);
        Tpl::output('menu_key', $menu_key);
    }

    public function show_menberOp() {
        $model_order = Model('order');

        //搜索
        $condition = array();
        $condition['buyer_id'] = $_GET['member_id'];
        if (preg_match('/^\d{10,20}$/',$_GET['keyword'])) {
            $condition['order_sn'] = $_GET['keyword'];
        } elseif ($_GET['keyword'] != '') {
            $condition['order_id'] = array('in',$this->_getOrderIdByKeyword($_GET['keyword']));
        }
        if (preg_match('/^\d{10,20}$/',$_GET['pay_sn'])) {
            $condition['pay_sn'] = $_GET['pay_sn'];
        }
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
        $end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }
        if ($_GET['state_type'] != '') {
            $condition['order_state'] = str_replace(
                array('state_new','state_pay','state_send','state_success','state_noeval','state_cancel'),
                array(ORDER_STATE_NEW,ORDER_STATE_PAY,ORDER_STATE_SEND,ORDER_STATE_SUCCESS,ORDER_STATE_SUCCESS,ORDER_STATE_CANCEL), $_GET['state_type']);
        }
        if ($_GET['state_type'] == 'state_new') {
            $condition['chain_code'] = 0;
        }
        if ($_GET['state_type'] == 'state_noeval') {
            $condition['evaluation_state'] = 0;
            $condition['order_state'] = ORDER_STATE_SUCCESS;
        }
        if ($_GET['state_type'] == 'state_notakes') {
            $condition['order_state'] = array('in',array(ORDER_STATE_NEW,ORDER_STATE_PAY));
            $condition['chain_code'] = array('gt',0);
        }

        //回收站
        if ($_GET['recycle']) {
            $condition['delete_state'] = 1;
        } else {
            $condition['delete_state'] = 0;
        }
        $order_list = $model_order->getOrderList($condition, 20, '*', 'order_id desc','', array('order_common','order_goods','store'));

        $model_refund_return = Model('refund_return');
        $order_list = $model_refund_return->getGoodsRefundList($order_list,1);//订单商品的退款退货显示

        //查询消费者保障服务
        if (C('contract_allow') == 1) {
            $contract_item = Model('contract')->getContractItemByCache();
        }

        //订单列表以支付单pay_sn分组显示
        $order_group_list = array();

        foreach ($order_list as $order_id => $order_info) {

            //显示取消订单
            $order_info['if_buyer_cancel'] = $model_order->getOrderOperateState('buyer_cancel',$order_info);

            //显示退款取消订单
            $order_info['if_refund_cancel'] = $model_order->getOrderOperateState('refund_cancel',$order_info);

            //显示投诉
            $order_info['if_complain'] = $model_order->getOrderOperateState('complain',$order_info);

            //显示收货
            $order_info['if_receive'] = $model_order->getOrderOperateState('receive',$order_info);

            //显示锁定中
            $order_info['if_lock'] = $model_order->getOrderOperateState('lock',$order_info);

            //显示物流跟踪
            $order_info['if_deliver'] = $model_order->getOrderOperateState('deliver',$order_info);

            //显示评价
            $order_info['if_evaluation'] = $model_order->getOrderOperateState('evaluation',$order_info);

            // 显示追加评价
            $order_info['if_evaluation_again'] = $model_order->getOrderOperateState('evaluation_again',$order_info);

            //显示删除订单(放入回收站)
            $order_info['if_delete'] = $model_order->getOrderOperateState('delete',$order_info);

            //显示永久删除
            $order_info['if_drop'] = $model_order->getOrderOperateState('drop',$order_info);

            //显示还原订单
            $order_info['if_restore'] = $model_order->getOrderOperateState('restore',$order_info);

            $refund_all = $order_info['refund_list'][0];
            if (!empty($refund_all) && $refund_all['seller_state'] < 3) {//订单全部退款商家审核状态:1为待审核,2为同意,3为不同意
                $order_info['refund_all'] = $refund_all;
            }
            if (is_array($order_info['extend_order_goods'])) {
                foreach ($order_info['extend_order_goods'] as $value) {
                    $value['image_60_url'] = cthumb($value['goods_image'], 60, $value['store_id']);
                    $value['image_240_url'] = cthumb($value['goods_image'], 240, $value['store_id']);
                    $value['goods_type_cn'] = orderGoodsType($value['goods_type']);
                    $value['goods_url'] = urlShop('goods','index',array('goods_id'=>$value['goods_id']));
                    //处理消费者保障服务
                    if (trim($value['goods_contractid']) && $contract_item) {
                        $goods_contractid_arr = explode(',',$value['goods_contractid']);
                        foreach ((array)$goods_contractid_arr as $gcti_v) {
                            $value['contractlist'][] = $contract_item[$gcti_v];
                        }
                    }
                    if ($value['goods_type'] == 5) {
                        $order_info['zengpin_list'][] = $value;
                    } else {
                        $order_info['goods_list'][] = $value;
                    }
                }
            }

            if (empty($order_info['zengpin_list'])) {
                $order_info['goods_count'] = count($order_info['goods_list']);
            } else {
                $order_info['goods_count'] = count($order_info['goods_list']) + 1;
            }

            //取得其它订单类型的信息
            $model_order->getOrderExtendInfo($order_info);

            //如果有在线支付且未付款的订单则显示合并付款链接
            $_flag = ($order_info['order_state'] == ORDER_STATE_NEW && $order_info['order_type'] == 1) ||
                ($order_info['order_state'] == ORDER_STATE_NEW && $order_info['order_type'] == 3 && $order_info['payment_code'] == 'online');
            if ($_flag) {
                $order_group_list[$order_info['pay_sn']]['pay_amount'] += $order_info['order_amount']-$order_info['pd_amount']-$order_info['rcb_amount'];
            }

            $order_group_list[$order_info['pay_sn']]['order_list'][] = $order_info;
        }
        Tpl::output('order_group_list',$order_group_list);
        Tpl::output('show_page',$model_order->showpage());

        self::profile_menu($_GET['recycle'] ? 'member_order_recycle' : 'member_order');
        Tpl::showpage('member_order.index');
    }

}
