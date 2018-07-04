<?php defined('In33hao') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
  <a href="javascript:void(0)" class="ncbtn ncbtn-mint" onclick="go('index.php?act=store_account_group&op=group_add');" title="添加账号"><i class="icon-group"></i>添加组</a> </div>
<form id="add_form" action="<?php echo urlShop('store_account_group', 'group_spend_edit');?>" method="post">
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w30"></th>
        <th class="tl" style="margin:5px 0 5px 0;">组名</th>
        <th class="tl" style="margin:5px 0 5px 0;"><div class="text" style=" text-align:center;">酒店</div></th>
        <th class="tl" style="margin:5px 0 5px 0;"><div class="text" style=" text-align:center;">餐饮</div></th>
        <th class="tl" style="margin:5px 0 5px 0;"><div class="text" style=" text-align:center;">会议</div></th>
        <th class="tl" style="margin:5px 0 5px 0;"><div class="text" style=" text-align:center;">约车</div></th>
<!--        --><?php //print_r($output['class_list'])?>
<!--       --><?php //print_r($output['seller_group_list'])?>
<!--        --><?php //if(!empty($output['class_list']) && is_array($output['class_list'])){ ?>
<!--        --><?php //foreach($output['class_list'] as $k => $v){ ?>
<!--        <td class="sign"><i class="ico-check"></i></td>-->
<!--        <th><input  name="gc_id[]" style="margin:5px 0 5px 0;"   readonly value="--><?php //echo $v['gc_id'];?><!--" ></th>-->
<!--        <th class="name" style="margin:5px 0 5px 0;"><span title="--><?php //echo $lang['nc_editable'];?><!--"  column_id="--><?php //echo $v['gc_id'];?><!--" fieldname="gc_name" nc_type="inline_edit" class="editable ">--><?php //echo $v['gc_name'];?><!--</span></th>-->
<!---->
<!---->
<!---->
<!--    --><?php //} ?>
<!--    --><?php //}else { ?>
<!--        <tr>-->
<!--            <td class="no-data" colspan="100"><i class="fa fa-exclamation-circle"></i>--><?php //echo $lang['nc_no_record'];?><!--</td>-->
<!--        </tr>-->
<!--    --><?php //} ?>
      <th class="w100"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>

  <tbody>
    <?php if(!empty($output['seller_group_list']) && is_array($output['seller_group_list'])){?>
    <?php foreach($output['seller_group_list'] as $key => $value){?>

    <tr class="bd-line">
      <td></td>
      <td class="tl" style="padding-left: 1px;width: 60px;margin:5px 0 5px 0;"><?php echo $value[$key]['group_name'];?></td>
<!--      <td class="nscs-table-handle"><span><a href="--><?php //echo urlShop('store_account_group', 'group_edit', array('group_id' => $value['group_id']));?><!--" class="btn-bluejeans"><i class="icon-edit"></i>-->
<!--        <p>--><?php //echo $lang['nc_edit'];?><!--</p>-->
<!--        </a></span><span><a nctype="btn_del_group" data-group-id="--><?php //echo $value['group_id'];?><!--" href="javascript:;" class="btn-grapefruit"><i class="icon-trash"></i>-->
<!--        <p>--><?php //echo $lang['nc_del'];?><!--</p>-->
<!--        </a></span></td>-->
        <?php foreach ($value as $k=>$v){  ?>
<!--            <td ><span><input  name="spend[]"  type="number" value="--><?php //echo intval($v['spend']) ?><!--">   </span></td>-->
            <?php if ($v['gcid']==1){$hotelspend = $v['spend'];$hotellimit = $v['lim'];}
                if ($v['gcid']==2){$meetingspend = $v['spend'];$meetinglimit = $v['lim'];}
                    if ($v['gcid']==3){$eatspend = $v['spend'];$eatinglimit = $v['lim'];}
                        if ($v['gcid']==256){$carspend = $v['spend'];$carlimit = $v['lim'];}
            ?>

        <?php }?>
        <td  style="padding-left: 1px;width: 80px;margin:5px 0 5px 0;"><span><input  name="<?php echo $value[$key]['group_id']."hotelspend";?>"   style="width: 45px; padding-left: 5px;" type="number" value="<?php echo intval($hotelspend) ?>"> <input id="<?php echo $value[$key]['group_id']."hotellimit";?>" style="padding-left:0px;" type="checkbox" name="<?php echo $value[$key]['group_id']."hotellimit";?>"  <?php if($hotellimit ==1){?>checked="checked" <?php } ?> value="1"/>   </span></td>
<!--        <td ><span><input id="--><?php //echo $value[$key]['group_id']."hotellimit";?><!--" style="padding-left:0px;" type="checkbox" name="--><?php //echo $value[$key]['group_id']."hotellimit";?><!--"  --><?php //if($hotellimit ==1){?><!--checked="checked" --><?php //} ?><!-- value="1"/> </span></td>-->
        <td style="padding-left: 1px;width: 80px;"><span><input  name="<?php echo $value[$key]['group_id']."meetingspend";?>" style="width: 45px;" type="number" value="<?php echo intval($meetingspend) ?>">  <input id="<?php echo $v['gc_id'];?>"  type="checkbox" name="<?php echo $value[$key]['group_id']."meetinglimit";?>"  <?php if($meetinglimit ==1){?>checked="checked" <?php } ?> value="1"/> </span></td>
<!--        <td ><span><input id="--><?php //echo $v['gc_id'];?><!--"  type="checkbox" name="--><?php //echo $value[$key]['group_id']."meetinglimit";?><!--"  --><?php //if($meetinglimit ==1){?><!--checked="checked" --><?php //} ?><!-- value="1"/> </span></td>-->
        <td style="padding-left: 1px;width: 80px;"><span><input  name="<?php echo $value[$key]['group_id']."eatingspend";?>" style="width: 45px;" type="number" value="<?php echo intval($eatspend) ?>"> <input id="<?php echo $v['gc_id'];?>"  type="checkbox" name="<?php echo $value[$key]['group_id']."eatinglimit";?>"  <?php if($eatinglimit ==1){?>checked="checked" <?php } ?> value="1"/> </span></td>
<!--        <td ><span><input id="--><?php //echo $v['gc_id'];?><!--"  type="checkbox" name="--><?php //echo $value[$key]['group_id']."eatinglimit";?><!--"  --><?php //if($eatinglimit ==1){?><!--checked="checked" --><?php //} ?><!-- value="1"/> </span></td>-->
        <td style="padding-left: 1px;width: 80px;"><span><input  name="<?php echo $value[$key]['group_id']."carspend";?>" style="width: 45px;" type="number" value="<?php echo intval($carspend) ?>"> <input id="<?php echo $v['gc_id'];?>"  type="checkbox" name="<?php echo $value[$key]['group_id']."carlimit";?>"  <?php if($carlimit ==1){?>checked="checked" <?php } ?> value="1"/>  </span></td>
<!--        <td ><span><input id="--><?php //echo $v['gc_id'];?><!--"  type="checkbox" name="--><?php //echo $value[$key]['group_id']."carlimit";?><!--"  --><?php //if($carlimit ==1){?><!--checked="checked" --><?php //} ?><!-- value="1"/> </span></td>-->
        <td class="nscs-table-handle">
            <span><a nctype="btn_del_group" data-group-id="<?php echo $value[$key]['group_id'];?>" href="javascript:;" class="btn-grapefruit"><i class="icon-trash"></i>
        <p><?php echo $lang['nc_del'];?></p>
        </a></span></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php }?>

  </tbody>
  <tfoot>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>

  </tfoot>

</table>
    <div class="bottom"  align="center">
        <label class="submit-border">
            <input type="submit" id="group_submit" class="submit" value="保存">
        </label>
    </div>
</form>

<form id="del_form" method="post" action="<?php echo urlShop('store_account_group', 'group_del');?>">
  <input id="del_group_id" name="group_id" type="hidden" />
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_del_group"]').on('click', function() {
            var group_id = $(this).attr('data-group-id');
            if(confirm('确认删除？')) {
                $('#del_group_id').val(group_id);
                ajaxpost('del_form', '', '', 'onerror');
            }
        });
    });
</script> 
