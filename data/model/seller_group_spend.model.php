<?php
/**
 * 卖家账号组模型
 *
 *
 *
 * * @好商城 (c) 2015-2018 33HAO Inc. (http://www.33hao.com)
 * @license    http://www.33 hao.c om
 * @link       交流群号：138182377
 * @since      好商城提供技术支持 授权请购买shopnc授权
 */
defined('In33hao') or exit('Access Invalid!');
class seller_group_spendModel extends Model{

    public function __construct(){
        parent::__construct('seller_group_spend');
    }

    /**
     * 读取列表
     * @param array $condition
     *
     */
    public function getSellerGroupSpendList($condition, $page='', $order='', $field='*') {
        $result = $this->field($field)->where($condition)->page($page)->order($order)->select();
        return $result;
    }

    /**
     * 读取单条记录
     * @param array $condition
     *
     */
    public function getSellerGroupSpendInfo($condition) {
        $result = $this->where($condition)->find();
        return $result;
    }

    /*
     * 增加
     * @param array $param
     * @return bool
     */
    public function addSellerGroupSpend($insert){
        $result = $this->table('seller_group_spend')->insert($insert);
//        $result= $insert;
        return $result;
    }

    /*
     * 更新
     * @param array $update
     * @param array $condition
     * @return bool
     */
    public function editSellerGroupSpend($update, $condition){
        return $this->where($condition)->update($update);
    }

    /*
     * 删除
     * @param array $condition
     * @return bool
     */
    public function delSellerGroupSpend($condition){
        return $this->where($condition)->delete();
    }

    //判断企业子账号的消费是否合格
    public function getSellerGroupLim($member_id,$gc_id,$spend){
        $model_seller = Model('seller');
        $seller_info = $model_seller->getSellerInfo($member_id);
        if($seller_info['seller_group_id']){
            $condition = array();
            $condition2 = array();
            $condition['group_id'] = $seller_info['seller_group_id'];
            $condition['gcid'] = $gc_id;
            $spend_lim = $this->getSellerGroupSpendInfo($condition);
            if($spend_lim['lim'] == 1){
                if ($spend <= $spend_lim['spend']){
                    return true;
                }
                else {return false;}
            }
            else {return true;}

        }
        else{
            return true;
        }
    }

}
?>