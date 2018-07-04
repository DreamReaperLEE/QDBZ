<?php defined('In33hao') or exit('Access Invalid!');?>
<?php if($output['is_goods']){
    include template('layout/goods_layout');
}else if($output['is_index']){
    include template('layout/index_layout');
}else{
    include template('layout/common_layout');
}
?>
<?php if(!$output['is_search']){
    include template('layout/cur_local');
}
?>
<?php require_once($tpl_file);?>

<?php if($output['is_index']){
    require_once template('footer_index');
}else{
    require_once template('footer');
}
?>
</body>
</html>
