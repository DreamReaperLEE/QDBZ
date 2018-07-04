<?php defined('In33hao') or exit('Access Invalid!');?>
<style type="text/css">
    .flexigrid .bDiv tr:nth-last-child(2) span.btn ul { bottom: 0; top: auto}
</style>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form id="add_form" action="<?php echo urlShop('store_account_group', 'group_save');?>" method="post">
    <?php if(!empty($output['group_info'])) { ?>
    <input name="group_id" type="hidden" value="<?php echo $output['group_info']['group_id'];?>" />
    <?php } ?>
    <dl>
      <dt><i class="required">*</i>组名称<?php echo $lang['nc_colon'];?></dt>

      <dd>
        <input class="w120 text" name="seller_group_name" type="text" id="seller_group_name" value="<?php if(!empty($output['group_info'])) {echo $output['group_info']['group_name'];};?>" />
        <span></span>
        <p class="hint">设定权限组名称，方便区分权限类型。</p>
      </dd>
    </dl>
      <div class="page">
          <form method='post'>
              <input type="hidden" name="form_submit" value="ok" />
              <input type="hidden" name="submit_type" id="submit_type" value="" />
              <table class="flex-table">
                  <thead>
                  <tr>
                      <th width="24" align="center" class="sign"><i class="ico-check"></i></th>
                      <th width="150" class="sa" align="center"></th>
                      <th width="150" class="handle" align="center">分类</th>
                      <th width="150" align="center">额度</th>
                      <th width="300" align="left">是否设限</th>


                      <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php if(!empty($output['class_list']) && is_array($output['class_list'])){ ?>
                      <?php foreach($output['class_list'] as $k => $v){ ?>
                          <tr data-id="<?php echo $v['gc_id'];?>">
                              <td class="sign"><i class="ico-check"></i></td>
                              <td ><input  name="gc_id[]"  type=hidden readonly value="<?php echo $v['gc_id'];?>" ></td>
                              <td class="name"><span title="<?php echo $lang['nc_editable'];?>"  column_id="<?php echo $v['gc_id'];?>" fieldname="gc_name" nc_type="inline_edit" class="editable "><?php echo $v['gc_name'];?></span></td>
                              <?php if (is_array($output['spendlist']) && !empty($output['spendlist'])){
                              foreach ($output['spendlist'] as $key=>$value){              //为了显示出来。
                                  if ($value['gcid'] ==  $v['gc_id'] ){?>
                              <td ><span><input  name="spend[]"  type="number" value="<?php echo intval($value['spend']) ?>">   </span></td>
                              <td ><span><input id="<?php echo $v['gc_id'];?>"  type="checkbox" name="<?php echo $v['gc_id'];?>"  <?php if($value['lim'] ==1){?>checked="checked" <?php } ?> value="<?php echo $v['gc_id']?>"/> </span></td>
                              <td></td>
                                 <?php }
                              } }
                              else{?>
                                  <td ><span><input  name="spend[]"  type="number" value="">   </span></td>
                                  <td ><span><input type="checkbox" name="<?php echo $v['gc_id'];?>"  checked="checked" /> </span></td>
                             <?php }?>

                          </tr>
                      <?php } ?>
                  <?php }else { ?>
                      <tr>
                          <td class="no-data" colspan="100"><i class="fa fa-exclamation-circle"></i><?php echo $lang['nc_no_record'];?></td>
                      </tr>
                  <?php } ?>
                  </tbody>
              </table>
      </div>


<!--      <dl>-->
<!--          <dt><i class="required">*</i>酒店额度设置--><?php //echo $lang['nc_colon'];?><!--</dt>-->
<!--          <dd>-->
<!--              <input class="w120 text" name="seller_group_hotelspend" type="number" id="seller_group_hotelspend" value="--><?php //if(!empty($output['group_info'])) {echo $output['group_info']['hotelspend'];};?><!--" />-->
<!--              <span></span>-->
<!--              <p class="hint">酒店额度设置</p>-->
<!--          </dd>-->
<!--          <dt><i class="required">*</i>餐饮额度设置--><?php //echo $lang['nc_colon'];?><!--</dt>-->
<!--          <dd>-->
<!--              <input class="w120 text" name="seller_group_restroundspend" type="number" id="seller_group_restroundspend" value="--><?php //if(!empty($output['group_info'])) {echo $output['group_info']['restroundspend'];};?><!--" />-->
<!--              <span></span>-->
<!--              <p class="hint">餐饮额度设置</p>-->
<!--          </dd>-->
<!--          <dt><i class="required">*</i>会议额度设置--><?php //echo $lang['nc_colon'];?><!--</dt>-->
<!--          <dd>-->
<!--              <input class="w120 text" name="seller_group_meetingspend" type="number" id="seller_group_meetingspend" value="--><?php //if(!empty($output['group_info'])) {echo $output['group_info']['meetingspend'];};?><!--" />-->
<!--              <span></span>-->
<!--              <p class="hint">会议额度设置</p>-->
<!--          </dd>-->
<!--          <dt><i class="required">*</i>约车额度设置--><?php //echo $lang['nc_colon'];?><!--</dt>-->
<!--          <dd>-->
<!--              <input class="w120 text" name="seller_group_carspend" type="number" id="seller_group_carspend" value="--><?php //if(!empty($output['group_info'])) {echo $output['group_info']['carspend'];};?><!--" />-->
<!--              <span></span>-->
<!--              <p class="hint">约车额度设置</p>-->
<!--          </dd>-->
<!--      </dl>-->
    <dl id="function_list" hidden>
      <dt><i class="required">*</i>基本权限<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-account-all">
          <input id="btn_select_all" name="btn_select_all" class="checkbox" type="checkbox" checked="checked" />
          <label for="btn_select_all">全选</label>
          <span></span>
        </div>
        <?php if(!empty($output['menu']) && is_array($output['menu'])) {?>
        <?php foreach($output['menu'] as $key => $value) {?>
        <div class="ncsc-account-container">
          <h4>
            <input id="<?php echo $key;?>" class="checkbox" nctype="btn_select_module" type="checkbox" />
            <label for="<?php echo $key;?>"><?php echo $value['name'];?></label>
          </h4>
          <?php $submenu = $value['child'];?>
          <?php if(!empty($submenu) && is_array($submenu)) {?>
          <ul class="ncsc-account-container-list">
            <?php foreach($submenu as $submenu_value) {?>
            <li>
              <input id="<?php echo $submenu_value['act'];?>" class="checkbox" checked="checked" name="limits[]" value="<?php echo $submenu_value['act'];?>"  type="checkbox" />
              <label for="<?php echo $submenu_value['act'];?>"><?php echo $submenu_value['name'];?></label>
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
        </div>
        <?php } ?>
        <?php } ?>
        <p class="hint"></p>
      </dd>
    </dl>
    <dl hidden>
      <dt><i class="required" ></i>消息接收权限<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-account-all">
          <input id="smt_select_all" class="checkbox" type="checkbox" />
          <label for="smt_select_all">全选</label>
        </div>
        <div class="ncsc-account-container">
          <?php if (!empty($output['smt_list'])) {?>
          <ul class="ncsc-account-container-list" style=" width: 99%; padding-left: 1%;">
            <?php foreach ($output['smt_list'] as $val) {?>
            <li style=" width: 25%;">
              <input id="<?php echo $val['smt_code'];?>" class="checkbox" name="smt_limits[]" value="<?php echo $val['smt_code'];?>" <?php if (!empty($output['smt_limits']) && in_array($val['smt_code'], $output['smt_limits'])) {?>checked<?php }?> type="checkbox" />
              <label for="<?php echo $val['smt_code'];?>"><?php echo $val['smt_name'];?></label>
            </li>
            <?php }?>
          </ul>
          <?php }?>
        </div>
        <p class="hint">如需设置消息接收权限，请设置该权限组允许查看“系统消息”。</p>
      </dd>
    </dl>
    <dl id="goods_class_panel" hidden>
      <dt><i class="required"></i>商品分类权限<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-account-all">
          <input id="gc_select_all" name="gc_select_all" value="1" class="checkbox" type="checkbox" />
          <label for="gc_select_all">全选</label>
        </div>
        <p class="hint">设置该分类后，当操作“商品发布”、“出售中的商品”、“仓库中的商品”、“商品规格”功能时，只会出现此处设置过的分类内容。</p>
        <?php include template('seller/store_account_group.goods_class');?>
        
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="button" id="group_submit" class="submit" value="<?php echo $lang['nc_submit'];?>设置">
      </label>
    </div>
  </form>
</div>
<script>
$(document).ready(function(){
    $('#btn_select_all').on('click', function() {
        if($(this).prop('checked')) {
            $(this).parents('dd').find('input:checkbox').prop('checked', true);
        } else {
            $(this).parents('dd').find('input:checkbox').prop('checked', false);
        }
    });
    $('[nctype="btn_select_module"]').on('click', function() {
        if($(this).prop('checked')) {
            $(this).parents('.ncsc-account-container').find('input:checkbox').prop('checked', true);
        } else {
            $(this).parents('.ncsc-account-container').find('input:checkbox').prop('checked', false);
        }
    });
    $('#smt_select_all').on('click', function() {
        if($(this).prop('checked')) {
            $(this).parents('dl').find('input:checkbox').prop('checked', true);
        } else {
            $(this).parents('dl').find('input:checkbox').prop('checked', false);
        }
    });
    $('#gc_select_all').on('change', function() {
        if($(this).prop('checked')) {
            $(this).parents('dl').find('input:checkbox').prop('checked', true);
            $(this).parents('dl').find('span[id^="count_"]').each(function(){
                $(this).html("("+$(this).attr('childcount')+")");
            });
        } else {
            $(this).parents('dl').find('input:checkbox').prop('checked', false);
            $(this).parents('dl').find('span[id^="count_"]').html('(0)');
        }
    });
    <?php if ($output['group_info']['gc_limits'] == 1) { ?>
    $('#gc_select_all').prop('checked',true).change();
    <?php } ?>
    jQuery.validator.addMethod("function_check", function(value, element) {       
        var count = $('#function_list').find('input:checkbox:checked').length;
        return count > 0;
    });
    $('#group_submit').on('click',function(){
        if ($('#add_form').valid()){
            if ($('#gc_select_all').prop('checked')){
                $('#goods_class_panel').find('.ncsc-account-container').remove();
            }
            $('#add_form').submit();            
        }
    });    
    $('#add_form').validate({
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
        ignore: ":hidden",
//         submitHandler:function(form){
//     		ajaxpost('add_form', '', '', 'onerror');
//     	},
        rules : {
            seller_group_name: {
                required: true,
                maxlength: 50 
            },
            btn_select_all: {
                function_check: true 
            }
        },
        messages: {
            seller_group_name: {
                required: '<i class="icon-exclamation-sign"></i>组名称不能为空',
                maxlength: '<i class="icon-exclamation-sign"></i>组名最多50个字' 
            },
            btn_select_all: {
                function_check: '请选择权限'
            }
        }
    });

    // 商品相关权限关联选择
    $('#store_goods_add,#store_goods_online,#store_goods_offline').on('click', function() {
        if($(this).prop('checked')) {
            store_goods_select(true);
        } else {
            store_goods_select(false);
        }
    });

    function store_goods_select(state) {
        $('#store_goods_add').prop('checked', state);
        $('#store_goods_online').prop('checked', state);
        $('#store_goods_offline').prop('checked', state);
    }
});
</script> 
