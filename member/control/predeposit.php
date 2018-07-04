<?php
/**
 * 预存款管理
 * * @好商城 (c) 2015-2018 33HAO Inc. (http://www.33hao.com)
 * @license    http://www.33 hao.c om
 * @link       交流群号：138182377
 * @since      好商城提供技术支持 授权请购买shopnc授权
 */


defined('In33hao') or exit('Access Invalid!');

class predepositControl extends BaseMemberControl {
    public function __construct(){
        parent::__construct();
        Language::read('member_predeposit');
    }

    /**
     * 充值添加
     */
    public function recharge_addOp(){
        if (!chksubmit()){
            //信息输出
            self::profile_menu('recharge_add','recharge_add');
            Tpl::showpage('predeposit.pd_add');
            exit();
        }
        $pdr_amount = abs(floatval($_POST['pdr_amount']));
        if ($pdr_amount <= 0) {
            showMessage(Language::get('predeposit_recharge_add_pricemin_error'),'','html','error');
        }
        $model_pdr = Model('predeposit');
        $data = array();
        $data['pdr_sn'] = $pay_sn = $model_pdr->makeSn();
        $data['pdr_member_id'] = $_SESSION['member_id'];
        $data['pdr_member_name'] = $_SESSION['member_name'];
        $data['pdr_amount'] = $pdr_amount;
        $data['pdr_add_time'] = TIMESTAMP;
        $insert = $model_pdr->addPdRecharge($data);
        if ($insert) {
            //转向到商城支付页面
            redirect(SHOP_SITE_URL . '/index.php?act=buy&op=pd_pay&pay_sn='.$pay_sn);
        }
    }

    /**
     * 平台充值卡
     */
    public function rechargecard_addOp()
    {
        if (!chksubmit()) {
            self::profile_menu('rechargecard_add','rechargecard_add');
            Tpl::showpage('predeposit.rechargecard_add');
            return;
        }

        $sn = (string) $_POST['rc_sn'];
        if (!$sn || strlen($sn) > 50) {
            showMessage('平台充值卡卡号不能为空且长度不能大于50', '', 'html', 'error');
            exit;
        }

        try {
            model('predeposit')->addRechargeCard($sn, $_SESSION);
            showMessage('平台充值卡使用成功', urlMember('predeposit', 'rcb_log_list'));
        } catch (Exception $e) {
            showMessage($e->getMessage(), '', 'html', 'error');
            exit;
        }
    }

    /**
     * 充值列表
     */
    public function indexOp(){
        $condition = array();
        $condition['pdr_member_id'] = $_SESSION['member_id'];
        if (!empty($_GET['pdr_sn'])) {
            $condition['pdr_sn'] = $_GET['pdr_sn'];
        }

        $model_pd = Model('predeposit');
        $list = $model_pd->getPdRechargeList($condition,20,'*','pdr_id desc');

        self::profile_menu('log','recharge_list');
        Tpl::output('list',$list);
        Tpl::output('show_page',$model_pd->showpage());

        Tpl::showpage('predeposit.pd_list');
    }

    /**
     * 查看充值详细
     *
     */
    public function recharge_showOp(){
        $pdr_id = intval($_GET["id"]);
        if ($pdr_id <= 0){
            showDialog(Language::get('predeposit_parameter_error'),'','error');
        }

        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdr_member_id'] = $_SESSION['member_id'];
        $condition['pdr_id'] = $pdr_id;
        $condition['pdr_payment_state'] = 1;
        $info = $model_pd->getPdRechargeInfo($condition);
        if (!$info){
            showDialog(Language::get('predeposit_record_error'),'','error');
        }
        Tpl::output('info',$info);
        self::profile_menu('rechargeinfo','rechargeinfo');
        Tpl::showpage('predeposit.pd_info');
    }

    /**
     * 删除充值记录
     *
     */
    public function recharge_delOp(){
        $pdr_id = intval($_GET["id"]);
        if ($pdr_id <= 0){
            showDialog(Language::get('predeposit_parameter_error'),'','error');
        }

        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdr_member_id'] = $_SESSION['member_id'];
        $condition['pdr_id'] = $pdr_id;
        $condition['pdr_payment_state'] = 0;
        $result = $model_pd->delPdRecharge($condition);
        if ($result){
            showDialog(Language::get('nc_common_del_succ'),'reload','succ','CUR_DIALOG.close()');
        }else {
            showDialog(Language::get('nc_common_del_fail'),'','error');
        }
    }

    /**
     * 预存款变更日志
     */
    public function pd_log_listOp(){
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['lg_member_id'] = $_SESSION['member_id'];
        $list = $model_pd->getPdLogList($condition,20,'*','lg_id desc');

        //信息输出
        self::profile_menu('log', 'loglist');

        $condition2['member_id'] = $_SESSION['member_id'];
        $model_seller = Model('seller');

        Tpl::output('is_company', $model_seller->getSellerInfo($condition2));
        Tpl::output('show_page', $model_pd->showpage());
        Tpl::output('list', $list);
        Tpl::showpage('predeposit.pd_log_list');
    }

    /**
     * 充值卡余额变更日志
     */
    public function rcb_log_listOp()
    {
        $model = Model();
        $list = $model->table('rcb_log')->where(array(
            'member_id' => $_SESSION['member_id'],
        ))->page(20)->order('id desc')->select();

        //信息输出
        self::profile_menu('log', 'rcb_log_list');

        $condition2['member_id'] = $_SESSION['member_id'];
        $model_seller = Model('seller');

        Tpl::output('is_company', $model_seller->getSellerInfo($condition2));
        Tpl::output('show_page', $model->showpage());
        Tpl::output('list', $list);
        Tpl::showpage('predeposit.rcb_log_list');
    }

    /**
     * 申请提现
     */
    public function pd_cash_addOp(){
        if (chksubmit()){
            $obj_validate = new Validate();
            $pdc_amount = abs(floatval($_POST['pdc_amount']));
            $validate_arr[] = array("input"=>$pdc_amount, "require"=>"true",'validator'=>'Compare','operator'=>'>=',"to"=>'0.01',"message"=>Language::get('predeposit_cash_add_pricemin_error'));
            $validate_arr[] = array("input"=>$_POST["pdc_bank_name"], "require"=>"true","message"=>Language::get('predeposit_cash_add_shoukuanbanknull_error'));
            $validate_arr[] = array("input"=>$_POST["pdc_bank_no"], "require"=>"true","message"=>Language::get('predeposit_cash_add_shoukuanaccountnull_error'));
            $validate_arr[] = array("input"=>$_POST["pdc_bank_user"], "require"=>"true","message"=>Language::get('predeposit_cash_add_shoukuannamenull_error'));
            $validate_arr[] = array("input"=>$_POST["password"], "require"=>"true","message"=>'请输入支付密码');
            $obj_validate -> validateparam = $validate_arr;
            $error = $obj_validate->validate();
            if ($error != ''){
                showDialog($error,'','error');
            }

            $model_pd = Model('predeposit');
            $model_member = Model('member');
            $member_info = $model_member->table('member')->where(array('member_id'=> $_SESSION['member_id']))->master(true)->lock(true)->find();//锁定当前会员记录 v5.5
            //验证支付密码
            if (md5($_POST['password']) != $member_info['member_paypwd']) {
                showDialog('支付密码错误','','error');
            }
            //验证金额是否足够
            if (floatval($member_info['available_predeposit']) < $pdc_amount){
                showDialog(Language::get('predeposit_cash_shortprice_error'),'index.php?act=predeposit&op=pd_cash_list','error');
            }
            try {
                $model_pd->beginTransaction();
                $pdc_sn = $model_pd->makeSn();
                $data = array();
                $data['pdc_sn'] = $pdc_sn;
                $data['pdc_member_id'] = $_SESSION['member_id'];
                $data['pdc_member_name'] = $_SESSION['member_name'];
                $data['pdc_amount'] = $pdc_amount;
                $data['pdc_bank_name'] = $_POST['pdc_bank_name'];
                $data['pdc_bank_no'] = $_POST['pdc_bank_no'];
                $data['pdc_bank_user'] = $_POST['pdc_bank_user'];
                $data['pdc_add_time'] = TIMESTAMP;
                $data['pdc_payment_state'] = 0;
                $insert = $model_pd->addPdCash($data);
                if (!$insert) {
                    throw new Exception(Language::get('predeposit_cash_add_fail'));
                }
                //冻结可用预存款
                $data = array();
                $data['member_id'] = $member_info['member_id'];
                $data['member_name'] = $member_info['member_name'];
                $data['amount'] = $pdc_amount;
                $data['order_sn'] = $pdc_sn;
                $model_pd->changePd('cash_apply',$data);
                $model_pd->commit();
                showDialog(Language::get('predeposit_cash_add_success'),'index.php?act=predeposit&op=pd_cash_list','succ');
            } catch (Exception $e) {
                $model_pd->rollback();
                showDialog($e->getMessage(),'index.php?act=predeposit&op=pd_cash_list','error');
            }
        }
    }

    /**
     * 提现列表
     */
    public function pd_cash_listOp(){
        $condition = array();
        $condition['pdc_member_id'] =  $_SESSION['member_id'];
        if (preg_match('/^\d+$/',$_GET['sn_search'])) {
            $condition['pdc_sn'] = $_GET['sn_search'];
        }
        if (isset($_GET['paystate_search'])){
            $condition['pdc_payment_state'] = intval($_GET['paystate_search']);
        }
        $model_pd = Model('predeposit');
        $cash_list = $model_pd->getPdCashList($condition,30,'*','pdc_id desc');

        self::profile_menu('log','cashlist');
        Tpl::output('list',$cash_list);
        Tpl::output('show_page',$model_pd->showpage());
        Tpl::showpage('predeposit.pd_cash_list');
    }

    /**
     * 提现列表
     */
    public function pd_tr_listOp(){
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



        if (chksubmit()) {
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["member_id"], "require"=>"true", "message"=>Language::get('admin_points_member_error_again')),
                array("input"=>$_POST["pointsnum"], "require"=>"true",'validator'=>'Compare','operator'=>' >= ','to'=>1,"message"=>Language::get('admin_points_points_min_error'))
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error,'','','error');
            }

            $money = abs(floatval($_POST['pointsnum']));
            $memo=trim($_POST['pointsdesc']);
            if ($money <= 0) {
                showMessage('输入的金额必需大于0','','html','error');
            }

            if ($_SESSION['member_id'] == $_POST['member_id']){
                showMessage('自己不能给自己转账','index.php?act=predeposit&op=pd_tr_list','','error');
            }

            //查询会员信息
            $obj_member = Model('member');
            $member_id = intval($_POST['member_id']);
            $member_info = $obj_member->getMemberInfo(array('member_id'=>$member_id));
            $member_info2 = $obj_member->getMemberInfo(array('member_id'=>$_SESSION['member_id']));

            if (!is_array($member_info)||!is_array($member_info2) || count($member_info)<=0){
                showMessage(Language::get('admin_points_userrecord_error'),'index.php?act=predeposit&op=pd_tr_list','','error');
            }

            $available_predeposit=floatval($member_info['available_predeposit']);
            $freeze_predeposit=floatval($member_info['freeze_predeposit']);

            $available_predeposit2=floatval($member_info2['available_predeposit']);
            $freeze_predeposit2=floatval($member_info2['freeze_predeposit']);

            if ($_POST['operatetype'] == 1 && $money > $available_predeposit2){
                showMessage(('预存款不足，商家当前预存款').$available_predeposit2,'index.php?act=predeposit&op=pd_tr_list','','error');
            }
            if ($_POST['operatetype'] == 2 && $money > $available_predeposit){
                showMessage(('预存款不足，会员当前预存款').$available_predeposit,'index.php?act=predeposit&op=pd_tr_list','','error');
            }
            if ($_POST['operatetype'] == 3 && $money > $available_predeposit){
                showMessage(('可冻结预存款不足，会员当前预存款').$available_predeposit,'index.php?act=predeposit&op=pd_tr_list','','error');
            }
            if ($_POST['operatetype'] == 4 && $money > $freeze_predeposit){
                showMessage(('可恢复冻结预存款不足，会员当前冻结预存款').$freeze_predeposit,'index.php?act=predeposit&op=pd_tr_list','','error');
            }
            $model_pd = Model('predeposit');
            $order_sn = $model_pd->makeSn();
//            $admininfo = $this->getAdminInfo();
            $log_msg = "操作会员[".$member_info['member_name']."]预存款，金额为".$money.",编号为".$order_sn;
            $admin_act="sys_nop";
            $admin_act2="sys_nop";
            switch ($_POST['operatetype'])
            {
                case 1:
                    $admin_act="sys_add_money";
                    $admin_act2="sys_del_money";
                    $log_msg = "操作会员[".$member_info['member_name']."]预存款[增加]，金额为".$money.",编号为".$order_sn;
                    break;
                case 2:
                    $admin_act="sys_del_money";
                    $admin_act2="sys_add_money";
                    $log_msg = "操作会员[".$member_info['member_name']."]预存款[减少]，金额为".$money.",编号为".$order_sn;
                    break;
                case 3:
                    $admin_act="sys_freeze_money";
                    $log_msg = "操作会员[".$member_info['member_name']."]预存款[冻结]，金额为".$money.",编号为".$order_sn;
                    break;
                case 4:
                    $admin_act="sys_unfreeze_money";
                    $log_msg = "操作会员[".$member_info['member_name']."]预存款[解冻]，金额为".$money.",编号为".$order_sn;
                    break;
                default:
                    showMessage('操作失败','index.php?act=predeposit&op=pd_tr_list');
                    break;
            }
            try {
                $model_pd->beginTransaction();
                //扣除冻结的预存款
                $data = array();
                $data['member_id'] = $member_info['member_id'];
                $data['member_name'] = $member_info['member_name'];
                $data['administrator'] = $_SESSION['member_name'];
                $data['amount'] = $money;
                $data['order_sn'] = $order_sn;
//                $data['admin_name'] = $admininfo['name'];
                $data['pdr_sn'] = $order_sn;
                $data['lg_desc'] = $memo;


                $data2 = array();
                $data2['member_id'] = $_SESSION['member_id'];
                $data2['member_name'] = $_SESSION['member_name'];
                $data2['administrator'] = $_SESSION['member_name'];
                $data2['amount'] = $money;
                $data2['order_sn'] = $order_sn;
                $data2['pdr_sn'] = $order_sn;
                $data2['lg_desc'] = $memo;

                $model_pd->changePd($admin_act,$data);
                $model_pd->changePd($admin_act2,$data2);

                $model_pd->commit();
                showMessage('操作成功','index.php?act=predeposit&op=pd_tr_list');
            } catch (Exception $e) {
                $model_pd->rollback();
//                $this->log($log_msg,0);
                showMessage($e->getMessage(),'index.php?act=predeposit&op=pd_tr_list','html','error');
            }
        } else {
            self::profile_menu('log', 'transfercash');
            $condition2['member_id'] = $_SESSION['member_id'];
            $model_seller = Model('seller');

            Tpl::output('is_company', $model_seller->getSellerInfo($condition2));
            Tpl::showpage('member.predeposit.add');
        }
    }

    /**
     * 提现记录详细
     */
    public function pd_cash_infoOp(){
        $pdc_id = intval($_GET["id"]);
        if ($pdc_id <= 0){
            showMessage(Language::get('predeposit_parameter_error'),'index.php?act=predeposit&op=pd_cash_list','html','error');
        }
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdc_member_id'] = $_SESSION['member_id'];
        $condition['pdc_id'] = $pdc_id;
        $info = $model_pd->getPdCashInfo($condition);
        if (empty($info)){
            showMessage(Language::get('predeposit_record_error'),'index.php?act=predeposit&op=pd_cash_list','html','error');
        }

        self::profile_menu('cashinfo','cashinfo');
        Tpl::output('info',$info);
        Tpl::showpage('predeposit.pd_cash_info');
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_type,$menu_key=''){
        $model_shopncSeller = Model('seller');
        $condition = array();
        $condition['member_id'] = $_SESSION['member_id'];
        $info = $model_shopncSeller->getisadmin($condition);

        if (!empty($info) && $info[0]['is_admin']) {
            $menu_array = array(
                array('menu_key' => 'loglist', 'menu_name' => '账户余额', 'menu_url' => 'index.php?act=predeposit&op=pd_log_list'),
                array('menu_key' => 'recharge_list', 'menu_name' => '充值明细', 'menu_url' => 'index.php?act=predeposit&op=index'),
                array('menu_key' => 'cashlist', 'menu_name' => '余额提现', 'menu_url' => 'index.php?act=predeposit&op=pd_cash_list'),
                array('menu_key' => 'rcb_log_list', 'menu_name' => '充值卡余额', 'menu_url' => 'index.php?act=predeposit&op=rcb_log_list',),
                array('menu_key' => 'transfercash', 'menu_name' => '用户转账', 'menu_url' => 'index.php?act=predeposit&op=pd_tr_list',),
            );
        } else {
            $menu_array = array(
                array('menu_key' => 'loglist', 'menu_name' => '账户余额', 'menu_url' => 'index.php?act=predeposit&op=pd_log_list'),
                array('menu_key' => 'recharge_list', 'menu_name' => '充值明细', 'menu_url' => 'index.php?act=predeposit&op=index'),
                array('menu_key' => 'cashlist', 'menu_name' => '余额提现', 'menu_url' => 'index.php?act=predeposit&op=pd_cash_list'),
                array('menu_key' => 'rcb_log_list', 'menu_name' => '充值卡余额', 'menu_url' => 'index.php?act=predeposit&op=rcb_log_list',),
            );
        }

        switch ($menu_type) {
            case 'rechargeinfo':
                $menu_array[] = array('menu_key'=>'rechargeinfo','menu_name'=>'充值详细',  'menu_url'=>'');
                break;
            case 'recharge_add':
                $menu_array[] = array('menu_key'=>'recharge_add','menu_name'=>'在线充值',   'menu_url'=>'');
                break;
            case 'rechargecard_add':
                $menu_array[] = array('menu_key'=>'rechargecard_add','menu_name'=>'充值卡充值','menu_url'=>'javascript:;');
                break;
            case 'cashadd':
                $menu_array[] = array('menu_key'=>'cashadd','menu_name'=>'提现申请',    'menu_url'=>'index.php?act=predeposit&op=pd_cash_add');
                break;
            case 'cashinfo':
                $menu_array[] = array('menu_key'=>'cashinfo','menu_name'=>'提现详细',  'menu_url'=>'');
                break;
            case 'log':
            default:
                break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }

    //取得会员信息
    public function checkmemberbalanceOp(){
        $name = trim($_GET['name']);
        if (!$name){
            echo ''; die;
        }
        /**
         * 转码
         */
        if(strtoupper(CHARSET) == 'GBK'){
            $name = Language::getGBK($name);
        }
        $obj_member = Model('member');
        $member_info = $obj_member->getMemberInfo(array('member_name'=>$name));
        if (is_array($member_info) && count($member_info)>0){
            if(strtoupper(CHARSET) == 'GBK'){
                $member_info['member_name'] = Language::getUTF8($member_info['member_name']);
            }
            echo json_encode(array('id'=>$member_info['member_id'],'name'=>$member_info['member_name'],'available_predeposit'=>$member_info['available_predeposit'],'freeze_predeposit'=>$member_info['freeze_predeposit']));
        }else {
            echo ''; die;
        }
    }

}
