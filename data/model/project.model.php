<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2018/4/1
 * Time: 13:52
 */
class projectModel extends Model {
    public function __construct(){
        parent::__construct('project');
    }

    public function addProject($insert) {
        return $this->insert($insert);
    }

    public function editProject($update, $condition) {
        return $this->where($condition)->update($update);
    }

    /**
     * 根据条件查询活动内容信息
     *
     * @param array $condition 查询条件数组
     * @param obj $page 分页对象
     * @return array 二维数组
     */
    public function getProjectList($page=''){
        $param  = array();
        $param['table'] = 'project';
//        $param['where'] = $this->getCondition($condition);
//        $param['order'] = $condition['order'];
        return Db::select($param, $page);
    }
}