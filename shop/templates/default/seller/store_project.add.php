<?php defined('In33hao') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form method="post" action="<?php echo empty($output['chain_info']) ? urlShop('store_chain', 'chain_add') : urlShop('store_chain', 'chain_edit', array('chain_id' => $output['chain_info']['chain_id']));?>" id="chain_form" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <h3>项目管理</h3>
    <dl>
      <dt><i class="required">*</i>项目名称<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text w200" name="project_name" id="project_name" value="<?php echo $output['chain_info']['chain_user'];?>" />
        <p class="hint">登录名请使用中文、字母、数字、下划线（最低三个字符），注册成功后不可以修改。</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>项目金额<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="textarea w200" name="project_account" id="project_account" value="<?php echo $output['chain_info']['chain_phone'];?>" />
        <p class="hint">请填写项目最大消费金额</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>项目日期<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <textarea class="textarea w400" maxlength="50" rows="2" name="project_start_time" id="project_start_time"><?php echo $output['chain_info']['chain_opening_hours'];?></textarea>
        <p class="hint">请如实填写项目日期</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required"></i>项目所属人<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <select class="w400" maxlength="50" rows="2" name="project_owner_id" id="project_owner_id">
            <?php
                foreach( $output['mode_member_list'] as $every){
                    echo "<option value=\"".$every['member_id']."\" text=\"".$every['member_name']."\"></option>";
                }
            ?>
          </select>
          <p class="hint">请选择项目负责人</p>
      </dd>
    </dl>

    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>"/>
      </label>
    </div>
  </form>
</div>
<script>
$(function(){
    $("#region").nc_region();
    $('#chain_form').validate({
        submitHandler:function(form){
            ajaxpost('chain_form', '', '', 'onerror');
        },
        rules : {
            //chain_user : {
            //    required : true,
            //    minlength: 3,
            //    remote   : 'index.php?act=store_chain&op=check_user<?php //if (!empty($output['chain_info'])) {?>//&no_id=<?php //echo $output['chain_info']['chain_id'];}?>//'
            //},
            project_name : {
                required : true
            },
            project_account : {
            	checklast: true
            },
            project_start_time : {
                required : true
            },
            project_owner_id : {
                required : true
            },
            project_company_id : {
                required : true
            },
        },
        messages : {
            project_name : {
                // required : '<i class="icon-exclamation-sign"></i>请填写门店登录名',
                // minlength: '<i class="icon-exclamation-sign"></i>请填写正确的门店名称',
                // remote   : '<i class="icon-exclamation-sign"></i>登录名已经存在'
                checklast : '<i class="icon-exclamation-sign"></i>请填写项目名称'
            },
            project_account : {
                checklast : '<i class="icon-exclamation-sign"></i>请填写项目金额'
            },
            project_start_time : {
                checklast : '<i class="icon-exclamation-sign"></i>请填写项目日期'
            },
            project_owner_id : {
                checklast : '<i class="icon-exclamation-sign"></i>请填写所属人ID'
            },
            project_company_id : {
                checklast : '<i class="icon-exclamation-sign"></i>请填写所属企业ID'
            }
        }
    });
});
</script> 
