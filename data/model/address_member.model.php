<?php
/**
 * 我的地址
 *
 *
 *
 * * @好商城 (c) 2015-2018 33HAO Inc. (http://www.33hao.com)
 * @license    http://www.33 hao.c om
 * @link       交流群号：138182377
 * @since      好商城提供技术支持 授权请购买shopnc授权
 */
defined('In33hao') or exit('Access Invalid!');
class address_memberModel extends Model {

    public function __construct() {
        parent::__construct('address_member');
    }


    /**
     * 删除地址
     *
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function delAddress_member($condition){
        return $this->where($condition)->delete();
    }

    /**
     * 新增地址
     *
     * @param array $param 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addAddress_member($param){
        return $this->insert($param);
    }

    //取数据
    public function getaddress_member_list($condition, $order = ''){
        $address_list = $this->where($condition)->order($order)->select();
        return $address_list;
    }

    /**
     * 取得买家默认收货地址
     *
     * @param array $condition
     */
    public function getDefaultAddressInfo($condition = array(), $order = 'is_default desc') {
        return $addr_info = $this->where($condition)->order($order)->find();
    }


}
