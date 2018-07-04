<?php defined('In33hao') or exit('Access Invalid!');?>

<div class="eject_con">
  <div class="adds">
    <div id="warning"></div>
    <form method="post" action="<?php echo MEMBER_SITE_URL;?>/index.php?act=member_address&op=address" id="address_form" target="_parent">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="id" value="<?php echo $output['address_info']['address_id'];?>" />
      <input type="hidden" value="<?php echo $output['address_info']['city_id'];?>" name="city_id" id="_area_2">
      <input type="hidden" value="<?php echo $output['address_info']['area_id'];?>" name="area_id" id="_area">
      <dl>
        <dt><i class="required">*</i><?php echo $lang['member_address_manage_name'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text w100" name="true_name" value="<?php echo $output['address_info']['true_name'];?>"/>
          <p class="hint"><?php echo $lang['member_address_input_name'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i><?php echo $lang['member_address_location'].$lang['nc_colon'];?></dt>
        <dd><input type="hidden" name="region" id="region" value="<?php echo $output['address_info']['area_info'];?>">
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i><?php echo $lang['member_address_manage_address'].$lang['nc_colon'];?></dt>
        <dd>
          <input class="text w300" type="text" name="address" value="<?php echo $output['address_info']['address'];?>"/>
        </dd>
      </dl>

        <dl>
            <dt><i class="required">*</i><?php echo $lang['member_address_manage_member'].$lang['nc_colon'];?></dt>
            <dd>
                <ul class="ncsc-account-container-list">
                    <?php $member_list=$output['seller_list'];?>
                    <?php
                        $address_member_list=$output['address_member_list'];
                        foreach($member_list as $every){
                            $is_check=0;
                            foreach($address_member_list as $each){
                                if($each['member_id']==$every['member_id'])
                                    $is_check=1;
                            }
                            if($is_check==1){
                                echo "<li>
                                    <input id=\"member_".$every['member_id']."\" class=\"checkbox\" name=\"address_member[]\" value=\"".$every['member_id']."\" type=\"checkbox\" checked=\"checked\" /> 
                                    <label for=\"member_".$every['member_id']."\">".$every['seller_name']."</label>
                                   </li>";
                            }
                            else{
                                echo "<li>
                                    <input id=\"member_".$every['member_id']."\" class=\"checkbox\" name=\"address_member[]\" value=\"".$every['member_id']."\" type=\"checkbox\">
                                    <label for=\"member_".$every['member_id']."\">".$every['seller_name']."</label>
                                   </li>";
                            }
                        }
                    ?>
                </ul>
            </dd>
        </dl>

      <dl>
        <dt><i class="required">*</i><?php echo 项目时间段.$lang['nc_colon'];?></dt>
        <dd>
            <input type="text" class="text w200" name="tel_phone" value=" "/>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i><?php echo 项目详情.$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text w200" name="mob_phone" value=" "/>
        </dd>
      </dl>
      <?php if (!intval($output['address_info']['dlyp_id'])) { ?>
      <dl>
        <dt><em class="pngFix"></em>设为默认项目<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="checkbox" class="checkbox vm mr5" <?php if ($output['address_info']['is_default']) echo 'checked';?> name="is_default" id="is_default" value="1" />
          <label for="is_default">设置为默认项目</label>
        </dd>
      </dl>
      <?php } ?>
      <div class="bottom">
        <label class="submit-border">
          <input type="submit" class="submit" value="<?php if($output['type'] == 'add'){?><?php echo $lang['member_address_new_address'];?><?php }else{?><?php echo $lang['member_address_edit_member'];?><?php }?>" />
        </label>
        <a class="ncbtn ml5" href="javascript:DialogManager.close('my_address_member_edit');">取消</a> </div>
    </form>
  </div>
</div>
<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(document).ready(function(){
	$("#region").nc_region();
	$('#address_form').validate({
    	submitHandler:function(form){
    		ajaxpost('address_form', '', '', 'onerror');
    	},
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        rules : {
            true_name : {
                required : true
            },
            address : {
                required : true
            },
            region : {
            	checklast: true
            },

        },
        messages : {
            true_name : {
                required : '<?php echo $lang['member_address_input_receiver'];?>'
            },
            address : {
                required : '<?php echo $lang['member_address_input_address'];?>'
            },

        },

    });
    $('#zt').on('click',function(){
    	DialogManager.close('my_address_edit');
    	ajax_form('daisou','使用代收货（自提）', '<?php echo MEMBER_SITE_URL;?>/index.php?act=member_address&op=delivery_add', '900',0);
    });
});

</script>