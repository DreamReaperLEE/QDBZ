<?php
/**
 * 卖家账号组管理
 *
 *
 *
 * * @好商城 (c) 2015-2018 33HAO Inc. (http://www.33hao.com)
 * @license    http://www.33 hao.c om
 * @link       交流群号：138182377
 * @since      好商城提供技术支持 授权请购买shopnc授权
 */



defined('In33hao') or exit('Access Invalid!');
class store_account_groupControl extends BaseCompanyControl {
    public function __construct() {
        parent::__construct();
        Language::read('member_store_index');
    }

    // 查看所有项目
    public function project_showOp(){

        Language::read('member_address');
        $lang   = Language::getLangContent();
        $address_member_class = Model('address_member');
        $address_class = Model('address');
        /**
         * 判断页面类型
         */
        $seller_class=Model('seller');
        $condition0=array();
        $condition0['member_id']=$_SESSION['member_id'];
        $isadmin=$seller_class->getisadmin($condition0);
        $isadmin1=array();
        foreach($isadmin as $every){
            $isadmin1=$every['is_admin'];
        }
        Tpl::output('isadmin',$isadmin1);
        if (($_GET['type'])=="edit"){
            /**
             * 新增/编辑地址页面
             */
            if (intval($_GET['id']) > 0){
                /**
                 * 得到地址信息
                 */
                $address_info = $address_class->getOneAddress(intval($_GET['id']));
                if ($address_info['member_id'] != $_SESSION['member_id']){
                    showMessage($lang['member_address_wrong_argument'],'index.php?act=member_address&op=address','html','error');
                }
                /**
                 * 输出地址信息
                 */
                Tpl::output('address_info',$address_info);
            }
            /**
             * 增加/修改页面输出
             */
            Tpl::output('type',$_GET['type']);
            Tpl::showpage('member_address.edit','null_layout');
            exit();
        }
        elseif (($_GET['type'])=="edit_member"){
            /**
             * 新增/编辑地址页面
             */
            if (intval($_GET['id']) > 0){
                //得到成员信息
                $model_seller = Model('seller');
                $condition = array(
                    'store_id' => $_SESSION['store_id'],
                    'seller_group_id' => array('gt', 0)
                );
                $seller_list = $model_seller->getSellerList($condition);
                /**
                 * 得到地址信息
                 */
                $address_info = $address_class->getOneAddress(intval($_GET['id']));
                if ($address_info['member_id'] != $_SESSION['member_id']){
                    showMessage($lang['member_address_wrong_argument'],'index.php?act=member_address&op=address','html','error');
                }

                $address_member_list = $address_member_class->getaddress_member_list(array('address_id'=>intval($_GET['id'])));
                /**
                 * 输出地址信息
                 */
                Tpl::output('address_member_list',$address_member_list);
                Tpl::output('address_info',$address_info);
                Tpl::output('seller_list',$seller_list);
            }
            /**
             * 增加/修改页面输出
             */
            Tpl::output('type',$_GET['type']);
            if($_GET['type']=="add"){
                Tpl::showpage('member_address.edit','null_layout');
            }
            else{
                Tpl::showpage('member_address_member.edit','null_layout');
            }
            exit();
        }
        elseif (($_GET['type'])=="add") {
            if (intval($_GET['id']) > 0){
                /**
                 * 得到地址信息
                 */
                $address_info = $address_class->getOneAddress(intval($_GET['id']));
                if ($address_info['member_id'] != $_SESSION['member_id']){
                    showMessage($lang['member_address_wrong_argument'],'index.php?act=member_address&op=address','html','error');
                }
                /**
                 * 输出地址信息
                 */
                Tpl::output('address_info',$address_info);
            }
            /**
             * 增加/修改页面输出
             */
            Tpl::output('type',$_GET['type']);
            Tpl::showpage('member_address.edit','null_layout');
            exit();
        }
        /**
         * 判断操作类型
         */
        if (chksubmit()){
            if ($_POST['city_id'] == '') {
                $_POST['city_id'] = $_POST['area_id'];
            }
            /**
             * 验证表单信息
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["true_name"],"require"=>"true","message"=>$lang['member_address_receiver_null']),
                array("input"=>$_POST["area_id"],"require"=>"true","validator"=>"Number","message"=>$lang['member_address_wrong_area']),
                array("input"=>$_POST["city_id"],"require"=>"true","validator"=>"Number","message"=>$lang['member_address_wrong_area']),
                array("input"=>$_POST["region"],"require"=>"true","message"=>$lang['member_address_area_null']),
                array("input"=>$_POST["address"],"require"=>"true","message"=>$lang['member_address_address_null']),
                array("input"=>$_POST['tel_phone'].$_POST['mob_phone'],'require'=>'true','message'=>$lang['member_address_phone_and_mobile'])
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showValidateError($error);
            }
            $data = array();
            $data['member_id'] = $_SESSION['member_id'];
            $data['true_name'] = $_POST['true_name'];
            $data['area_id'] = intval($_POST['area_id']);
            $data['city_id'] = intval($_POST['city_id']);
            $data['area_info'] = $_POST['region'];
            $data['address'] = $_POST['address'];
            $data['tel_phone'] = $_POST['tel_phone'];
            $data['mob_phone'] = $_POST['mob_phone'];





            ///sdfsdfdsf
            $ins = array();
            $ins['address_id'] = intval($_POST['id']);
            $address_member_class->delAddress_member(array('address_id'=>intval($_POST['id'])));
            foreach($_POST['address_member'] as $every){
                $ins['member_id'] = $every;
                $address_member_class->addAddress_member($ins);
            }





            $data['is_default'] = $_POST['is_default'] ? 1 : 0;
            if ($_POST['is_default']) {
                $address_class->editAddress(array('is_default'=>0),array('member_id'=>$_SESSION['member_id'],'is_default'=>1));
            }

            if (intval($_POST['id']) > 0){
                $rs = $address_class->editAddress($data, array('address_id' => intval($_POST['id']),'member_id'=>$_SESSION['member_id']));
                if (!$rs){
                    showDialog($lang['member_address_modify_fail'],'','error');
                }
            }else {
                $count = $address_class->getAddressCount(array('member_id'=>$_SESSION['member_id']));
                if ($count >= 20) {
                    showDialog('最多允许添加20个有效地址','','error');
                }
                $rs = $address_class->addAddress($data);
                if (!$rs){
                    showDialog($lang['member_address_add_fail'],'','error');
                }
            }
            showDialog($lang['nc_common_op_succ'],'reload','js');
        }
        $del_id = isset($_GET['id']) ? intval(trim($_GET['id'])) : 0 ;
        if ($del_id > 0){
            $rs = $address_class->delAddress(array('address_id'=>$del_id,'member_id'=>$_SESSION['member_id']));
            if ($rs){
                showDialog(Language::get('member_address_del_succ'),'index.php?act=member_address&op=address','js');
            }else {
                showDialog(Language::get('member_address_del_fail'),'','error');
            }
        }

        $model_seller = Model('seller');
        $condition = array(
            'member_id' => $_SESSION['member_id'],
        );
        $seller_list = $model_seller->getSellerList($condition);



        if($seller_list[0]['is_admin']){
            $address_list = $address_class->getAddressList(array('member_id'=>$_SESSION['member_id']));
        }else{

            $info=$address_member_class->getaddress_member_list(array('member_id'=>$_SESSION['member_id']));
            foreach($info as $every) {
                $seller_list1[] = (int)$every['address_id'];
                $condition = array();
                $condition['address_id'] = array('in', $seller_list1);
                $address_list = $address_class->getAddressList($condition);
            }

        }


        self::profile_menu('address','address');
        Tpl::output('address_list',$address_list);
        Tpl::showpage('member_address.index');
    }
    // 跳转到添加项目页面
    public function add_projectOp() {

        $model_member = Model('member');
        $mode_member_list = $model_member -> getMemberList();
        Tpl::output('mode_member_list', $mode_member_list);
        Tpl::showpage('store_project.add');

    }

    // 添加项目
    public function save_projectOp() {
//        $seller_info = array();
//        $seller_info['group_name'] = $_POST['seller_group_name'];
//        $seller_info['limits'] = implode(',', $_POST['limits']);
//        $seller_info['smt_limits'] = empty($_POST['smt_limits']) ? '' : implode(',', $_POST['smt_limits']);
//        $seller_info['gc_limits'] = $_POST['gc_select_all'] ? 1 : 0;
//        $seller_info['store_id'] = $_SESSION['store_id'];
//        $model_seller_group = Model('seller_group');
//        if (empty($_POST['group_id'])) {
//            $result = $model_seller_group->addSellerGroup($seller_info);
//            $this->_get_goods_class_save($result);
//            $this->recordSellerLog('添加组成功，组编号'.$result);
//            showDialog('添加成功', urlShop('store_account_group', 'group_list'),'succ');
//        } else {
//            $condition = array();
//            $condition['group_id'] = intval($_POST['group_id']);
//            $condition['store_id'] = $_SESSION['store_id'];
//            $model_seller_group->editSellerGroup($seller_info, $condition);
//            $this->_get_goods_class_save(intval($_POST['group_id']));
//            $this->recordSellerLog('编辑组成功，组编号'.$_POST['group_id']);
//            showDialog('编辑成功', urlShop('store_account_group', 'group_list'),'succ');
//        }
        $project_inf = array();
        $project_inf['project_name'] = $_POST['project_name'];
        $project_inf['project_account'] = $_POST['project_account'];
        $project_inf['project_start_time'] = $_POST['project_start_time'];
        $project_inf['project_member_id'] = $_POST['project_member_id'];
        $project_inf['project_company_id'] = $_SESSION['store_id'];
        $model_project = Model('project');

        $result = $model_project->addSellerGroup($project_inf);
        $this->recordSellerLog('添加组成功，组编号'.$result);
        showDialog('添加成功', urlShop('store_account_group', 'group_list'),'succ');

        $this->profile_menu('group_list');
        Tpl::showpage('store_account_group.list');
    }

    public function group_listOp() {
        $model_seller_group = Model('seller_group');
        $model_seller_spend = Model('seller_group_spend');
        $seller_group_list = $model_seller_group->getSellerGroupList(array('store_id' => $_SESSION['store_id']));
        $a = array();
        foreach ($seller_group_list as $k=>$v){
            $cond['group_id'] = $v['group_id'];
            $group_spendList[$k] = $model_seller_spend->getSellerGroupSpendList($cond);
            foreach ($group_spendList[$k] as $key=>&$value){
                $value['group_name'] = $v['group_name'];
                $value['store_id'] = $v['store_id'];
            }




        }



        Tpl::output('seller_group_list', $group_spendList);
        $this->profile_menu('group_list');



        $this->_get_goods_class_list();

        $this->profile_menu('group_add');

        $model_class = Model('goods_class');

        //商品分类
        $parent_id = 0;
        $gc_id = $_GET['gc_id']?intval($_GET['gc_id']):0;

        //列表
        $tmp_list = $model_class->getTreeClassList(3);
        if (is_array($tmp_list)){
            foreach ($tmp_list as $k => $v){
                if ($v['gc_parent_id'] == $gc_id){
                    //判断是否有子类
                    if ($tmp_list[$k+1]['deep'] > $v['deep']){
                        $v['have_child'] = 1;
                    }
                    $class_list[] = $v;
                }
                if ($v['gc_id'] == $gc_id) {
                    $parent_id = $v['gc_parent_id'];
                    $parent_name = $v['gc_name'];
                }
            }
        }
        if ($gc_id > 0){
            if ($parent_id == 0) {
                $title = '"' . $parent_name . '"的下级列表(二级)';
                $deep = 2;
            } else {
                foreach ($tmp_list as $v) {
                    if ($v['gc_id'] == $parent_id) {
                        $grandparents_name = $v['gc_name'];
                    }
                }
                $title = '"' . $grandparents_name . ' - ' . $parent_name . '"的下级列表(三级)';
                $deep = 3;
            }Tpl::output('class_list',$class_list);
            Tpl::showpage('store_account_group.list');}
        else {
            Tpl::output('class_list',$class_list);
            Tpl::showpage('store_account_group.list');

        }



        Tpl::showpage('store_account_group.list');
    }

    public function group_addOp() {
        // 店铺消息模板列表
        $smt_list = Model('store_msg_tpl')->getStoreMsgTplList(array(), 'smt_code,smt_name');
        Tpl::output('smt_list', $smt_list);

        //取得商品分类权限列表
        $this->_get_goods_class_list();

        $this->profile_menu('group_add');

        $model_class = Model('goods_class');

        //父ID
        $parent_id = 0;
        $gc_id = $_GET['gc_id']?intval($_GET['gc_id']):0;

        //列表
        $tmp_list = $model_class->getTreeClassList(3);
        if (is_array($tmp_list)){
            foreach ($tmp_list as $k => $v){
                if ($v['gc_parent_id'] == $gc_id){
                    //判断是否有子类
                    if ($tmp_list[$k+1]['deep'] > $v['deep']){
                        $v['have_child'] = 1;
                    }
                    $class_list[] = $v;
                }
                if ($v['gc_id'] == $gc_id) {
                    $parent_id = $v['gc_parent_id'];
                    $parent_name = $v['gc_name'];
                }
            }
        }
        if ($gc_id > 0){
            if ($parent_id == 0) {
                $title = '"' . $parent_name . '"的下级列表(二级)';
                $deep = 2;
            } else {
                foreach ($tmp_list as $v) {
                    if ($v['gc_id'] == $parent_id) {
                        $grandparents_name = $v['gc_name'];
                    }
                }
                $title = '"' . $grandparents_name . ' - ' . $parent_name . '"的下级列表(三级)';
                $deep = 3;
            }Tpl::output('class_list',$class_list);
            Tpl::showpage('store_account_group.add');}
        else {
            Tpl::output('class_list',$class_list);
            Tpl::showpage('store_account_group.add');

        }


        Tpl::showpage('store_account_group.add');
    }


    public function group_spend_editOp(){
        print_r( $_POST['56hotelspend']);
        $condit['store_id'] = $_SESSION['store_id'];

       $model_group = Model('seller_group');
       $groupList = $model_group->getSellerGroupList($condit);

        $model_spend = Model('seller_group_spend');
        foreach ($groupList as $k=>$v){
            $id = $v['group_id'] ;
            $condition['group_id'] =$id;
            $condition['gcid'] = 1;
             $group_info['spend'] = $_POST[$id.'hotelspend'];
             if($_POST[$id."hotellimit"] ==1){
                 $group_info['lim'] = 1;
                 }
             else{
                 $group_info['lim'] = 0;
             }
            $model_spend-> editSellerGroupSpend($group_info,$condition);

            $condition['gcid'] = 2;
            $group_info['spend'] = $_POST[$id.'meetingspend'];
            if($_POST[$id."meetinglimit"] ==1){
                $group_info['lim'] = 1;
            }
            else{
                $group_info['lim'] = 0;
            }
            $model_spend-> editSellerGroupSpend($group_info,$condition);

            $condition['gcid'] = 3;
            $group_info['spend'] = $_POST[$id.'eatingspend'];
            if($_POST[$id."eatinglimit"] ==1){
                $group_info['lim'] = 1;
            }
            else{
                $group_info['lim'] = 0;
            }
            $model_spend-> editSellerGroupSpend($group_info,$condition);

            $condition['gcid'] = 256;
            $group_info['spend'] = $_POST[$id.'carspend'];
            if($_POST[$id."carlimit"] ==1){
                $group_info['lim'] = 1;
            }
            else{
                $group_info['lim'] = 0;
            }
            $model_spend-> editSellerGroupSpend($group_info,$condition);

        }
        //Tpl::showpage('store_account_group.list');
        redirect('index.php?act=store_account_group&op=group_list');
    }



    public function group_editOp() {
        $group_id = intval($_GET['group_id']);
        if ($group_id <= 0) {
            showMessage('参数错误', '', '', 'error');
        }
        $model_seller_group = Model('seller_group');
        $seller_group_info = $model_seller_group->getSellerGroupInfo(array('group_id' => $group_id));
        if (empty($seller_group_info)) {
            showMessage('组不存在', '', '', 'error');
        }
        Tpl::output('group_info', $seller_group_info);
        Tpl::output('group_limits', explode(',', $seller_group_info['limits']));
        Tpl::output('smt_limits', explode(',', $seller_group_info['smt_limits']));

        // 店铺消息模板列表
        $smt_list = Model('store_msg_tpl')->getStoreMsgTplList(array(), 'smt_code,smt_name');
        Tpl::output('smt_list', $smt_list);

        // 商品分类列表
        $model_class = Model('goods_class');

        //父ID
        $parent_id = 0;
        $gc_id = $_GET['gc_id']?intval($_GET['gc_id']):0;

        //列表
        $tmp_list = $model_class->getTreeClassList(3);
        if (is_array($tmp_list)){
            foreach ($tmp_list as $k => $v){
                if ($v['gc_parent_id'] == $gc_id){
                    //判断是否有子类
                    if ($tmp_list[$k+1]['deep'] > $v['deep']){
                        $v['have_child'] = 1;
                    }
                    $class_list[] = $v;
                }
                if ($v['gc_id'] == $gc_id) {
                    $parent_id = $v['gc_parent_id'];
                    $parent_name = $v['gc_name'];
                }
            }
        }
        if ($gc_id > 0){
            if ($parent_id == 0) {
                $title = '"' . $parent_name . '"的下级列表(二级)';
                $deep = 2;
            } else {
                foreach ($tmp_list as $v) {
                    if ($v['gc_id'] == $parent_id) {
                        $grandparents_name = $v['gc_name'];
                    }
                }
                $title = '"' . $grandparents_name . ' - ' . $parent_name . '"的下级列表(三级)';
                $deep = 3;
            }Tpl::output('class_list',$class_list);}
//            Tpl::showpage('store_account_group.add');}
            else {
                Tpl::output('class_list',$class_list);
//                Tpl::showpage('store_account_group.add');
                }
            //取得商品分类权限列表
        $this->_get_goods_class_list($group_id);
        $this->profile_menu('group_edit');
        $condition2 = array();
        $condition2['group_id'] = intval($_GET['group_id']);
        $model_spend = Model('seller_group_spend');
        $spendlist = $model_spend->getSellerGroupSpendList($condition2);
        Tpl::output('spendlist',$spendlist);
        Tpl::showpage('store_account_group.add');
    }

    public function group_saveOp() {
        $seller_info = array();
        $seller_info['group_name'] = $_POST['seller_group_name'];
        $seller_info['limits'] = implode(',', $_POST['limits']);
        $seller_info['smt_limits'] = empty($_POST['smt_limits']) ? '' : implode(',', $_POST['smt_limits']);
        $seller_info['gc_limits'] = $_POST['gc_select_all'] ? 1 : 0;
        $seller_info['store_id'] = $_SESSION['store_id'];
        $model_seller_group = Model('seller_group');
       // $model_seller_spend = Model('seller_group_spend');
        if (empty($_POST['group_id'])) {
            $result = $model_seller_group->addSellerGroup($seller_info);
            $this->_get_goods_class_save($result);
            $gid = $model_seller_group->getSellerGroupInfo($seller_info);
            $spend_info = array();
            $spend_info['group_id'] = $gid['group_id'];
            $model_seller_spend = Model('seller_group_spend');
            foreach ($_POST['gc_id'] as $k=>$v){
                $spend_info['gcid'] = $v;
                $spend_info['spend'] = $_POST['spend'][$k];
                $li = $_POST[$v];
                if(!empty($li)){
                    $spend_info['lim'] = 1;
                }
                else{
                    $spend_info['lim'] = 0;
                }
                $judge = $model_seller_spend->getSellerGroupSpendInfo($spend_info);
                if(empty($judge)){
                $model_seller_spend->addSellerGroupSpend($spend_info);}

                }
                //$result = $model_seller_spend->addSellerGroupSpend($spend_info);
            $this->recordSellerLog('添加组成功，组编号'.$result);
            showDialog('添加成功！' , urlShop('store_account_group', 'group_list'),'succ');
        } else {
            $condition = array();
            $condition2 = array();
            $spend_info = array();
            $condition['group_id'] = intval($_POST['group_id']);
            $condition['store_id'] = $_SESSION['store_id'];
            $model_seller_group->editSellerGroup($seller_info, $condition);
            $this->_get_goods_class_save(intval($_POST['group_id']));
            $condition2['group_id'] =intval($_POST['group_id']);
            $model_seller_spend = Model('seller_group_spend');
            foreach ($_POST['gc_id'] as $k=>$v){
                $condition2['gcid'] = $v;
                $spend_info['spend'] = $_POST['spend'][$k];
                $li = $_POST[$v];
                if(!empty($li)){
                    $spend_info['lim'] = 1;
                }
                else{
                    $spend_info['lim'] = 0;
                }
                $model_seller_spend->editSellerGroupSpend($spend_info,$condition2);

            }

            $this->recordSellerLog('编辑组成功，组编号'.$_POST['group_id']);
            showDialog('编辑成功', urlShop('store_account_group', 'group_list'),'succ');
        }
    }

    public function group_delOp() {
        $group_id = intval($_POST['group_id']);
        if($group_id > 0) {
            $condition = array();
            $condition['group_id'] = $group_id;
            $condition['store_id'] = $_SESSION['store_id'];
            $model_seller_group = Model('seller_group');
            $result = $model_seller_group->delSellerGroup($condition);
            $condition = array();
            $condition['group_id'] = $group_id;
            $model_spend = Model('seller_group_spend');
            $model_spend->delSellerGroupSpend($condition);
            if($result) {
                $this->recordSellerLog('删除组成功，组编号'.$group_id);
                showDialog(Language::get('nc_common_op_succ'),'reload','succ');
            } else {
                $this->recordSellerLog('删除组失败，组编号'.$group_id);
                showDialog(Language::get('nc_common_save_fail'),'reload','error');
            }
        } else {
            showDialog(Language::get('wrong_argument'),'reload','error');
        }
    }

    /**
     * 取得商品分类列表
     */
    private function _get_goods_class_list($group_id = null) {
        $model_goods_class = Model('goods_class');
        if (checkPlatformStoreBindingAllGoodsClass()) {
            $class_list = $model_goods_class->get_all_category();
        } else {
            $class_list = array();
            $model_store_bind_class = Model('store_bind_class');
            $bind_class = $model_store_bind_class->getStoreBindClassList(array('store_id'=>$_SESSION['store_id']),'','','*',false);
            $goods_class = $model_goods_class->getGoodsClassIndexedListAll();
            for($i = 0, $j = count($bind_class); $i < $j; $i++) {
                $cur = $bind_class[$i];
                if (!isset($class_list[$cur['class_1']])) {
                    $class_list[$cur['class_1']] = array(
                        'gc_id' => $cur['class_1'],
                        'gc_name' => $goods_class[$cur['class_1']]['gc_name'],
                        'gc_parent_id' => $goods_class[$cur['class_1']]['gc_parent_id']
                    );
                }

                if (empty($cur['class_2'])) continue;
                if (!isset($class_list[$cur['class_1']]['class2'])) {
                    $class_list[$cur['class_1']]['class2'] = array();
                }
                $tmp_2 = & $class_list[$cur['class_1']]['class2'];
                if (!isset($tmp_2[$cur['class_2']])) {
                    $tmp_2[$cur['class_2']] = array(
                            'gc_id' => $cur['class_2'],
                            'gc_name' => $goods_class[$cur['class_2']]['gc_name'],
                            'gc_parent_id' => $goods_class[$cur['class_2']]['gc_parent_id']
                    );
                }

                if (empty($cur['class_3'])) continue;
                if (!isset($tmp_2[$cur['class_2']]['class3'])) {
                    $tmp_2[$cur['class_2']]['class3'] = array();
                }
                $tmp_3 = & $tmp_2[$cur['class_2']]['class3'];
                if (!isset($tmp_3[$cur['class_3']])) {
                    $tmp_3[$cur['class_3']] = array(
                            'gc_id' => $cur['class_3'],
                            'gc_name' => $goods_class[$cur['class_3']]['gc_name'],
                            'gc_parent_id' => $goods_class[$cur['class_3']]['gc_parent_id']
                    );
                }
            }
        }
        Tpl::output('bind_class_list', $class_list);
        //输出JSON形式，模板JS调用需要
        Tpl::output('bind_class_list_json',json_encode($class_list));

        if (!empty($group_id)) {
            $model_seller_group_bclass = Model('seller_group_bclass');
            //最低级ID列表
            $gc_list_useing = $model_seller_group_bclass->getSellerGroupBclasList(array('group_id'=>$group_id),'','','gc_id','gc_id');
            Tpl::output('gc_id_use_list',array_keys($gc_list_useing));
            //处理哪些二级分类需要选中
            $gc_list_useing = $model_seller_group_bclass->getSellerGroupBclasList(array('group_id'=>$group_id,'class_2'=>array(neq,0)),'','','count(bid) as ccount,class_2','class_2','class_2');
            Tpl::output('class_2_use_list',$gc_list_useing);
        } else {
            Tpl::output('gc_id_use_list',array());
        }
    }

    private function _get_goods_class_save($group_id = null) {
        if (!is_array($_POST['cate']) || isset($_POST['gc_select_all'])) $_POST['cate'] = array();
        $input = array();
        foreach($_POST['cate'] as $cate1_id => $cate1_array) {
            if (!is_array($cate1_array)) {
                $tmp = array();
                $tmp['class_1'] = $cate1_id;
                $tmp['class_2'] = $tmp['class_3'] = 0;
                $tmp['gc_id'] = $cate1_id;
                $tmp['group_id'] = $group_id;
                $input[] = $tmp;
            } else {
                foreach($cate1_array as $cate2_id => $cate2_array) {
                    if (!is_array($cate2_array)) {
                        $tmp = array();
                        $tmp['class_1'] = $cate1_id;
                        $tmp['class_2'] = $cate2_id;
                        $tmp['class_3'] = 0;
                        $tmp['gc_id'] = $cate2_id;
                        $tmp['group_id'] = $group_id;
                        $input[] = $tmp;
                    } else {
                        foreach($cate2_array as $cate3_id => $cate3_array) {
                            $tmp = array();
                            $tmp['class_1'] = $cate1_id;
                            $tmp['class_2'] = $cate2_id;
                            $tmp['class_3'] = $cate3_id;
                            $tmp['gc_id'] = $cate3_id;
                            $tmp['group_id'] = $group_id;
                            $input[] = $tmp;
                        }
                    }
                }
            }
        }
        $model_seller_group_bclass = Model('seller_group_bclass');
        $a = $model_seller_group_bclass->delSellerGroupBclass(array('group_id'=>$group_id));
        $model_seller_group_bclass->addSellerGroupBclass($input);
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @param array     $array      附加菜单
     * @return
     */
    private function profile_menu($menu_key='') {
        $menu_array = array();
        $menu_array[] = array(
            'menu_key'=>'group_list',
            'menu_name' => '组列表',
            'menu_url' => urlShop('store_account_group', 'group_list')
        );
        if($menu_key === 'group_add') {
            $menu_array[] = array(
                'menu_key'=>'group_add',
                'menu_name' => '添加组',
                'menu_url' => urlShop('store_account_group', 'group_add')
            );
        }
        if($menu_key === 'group_edit') {
            $menu_array[] = array(
                'menu_key'=>'group_edit',
                'menu_name' => '编辑组',
                'menu_url' => urlShop('store_account_group', 'group_edit')
            );
        }
        Tpl::output('member_menu', $menu_array);
        Tpl::output('menu_key', $menu_key);
    }

}
