<?php defined('In33hao') or exit('Access Invalid!');?>

<div class="page">
    <div class="tabmenu">
        <?php include template('layout/submenu');?>
        <?php if ($output['is_company'] ==2){ ?><a class="ncbtn ncbtn-bittersweet" title="在线充值" href="index.php?act=predeposit&op=recharge_add" style="right: 207px;"><i class="icon-shield"></i>在线充值</a><a class="ncbtn ncbtn-mint" href="index.php?act=member_security&op=auth&type=pd_cash" style="right: 107px;"><i class="icon-money"></i>申请提现</a><?php }else {?><a class="ncbtn ncbtn-bittersweet" title="在线充值" href="index.php?act=predeposit&op=recharge_add" style="right: 107px;"><i class="icon-shield"></i>在线充值</a> <?php }?>
        <a class="ncbtn ncbtn-bluejeansjeans" href="index.php?act=predeposit&op=rechargecard_add"><i class="icon-shield"></i>充值卡充值</a> </div>
    <div class="alert"><span class="mr30"><?php echo $lang['predeposit_pricetype_available'] . $lang['nc_colon']; ?>
            <strong class="mr5 red"
                    style="font-size: 18px;"><?php echo $output['member_info']['available_predeposit']; ?></strong><?php echo $lang['currency_zh']; ?></span><span><?php echo $lang['predeposit_pricetype_freeze'] . $lang['nc_colon']; ?>
            <strong class="mr5 blue"
                    style="font-size: 18px;"><?php echo $output['member_info']['freeze_predeposit']; ?></strong><?php echo $lang['currency_zh']; ?></span>
    </div>
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3><?php echo $lang['member_index_manage'] ?></h3>
                <h5><?php echo $lang['member_system_manage_subhead'] ?></h5>
            </div> <?php echo $output['top_link']; ?>
        </div>
    </div>
    <form id="points_form" method="post" name="form1">
        <input type="hidden" name="form_submit" value="ok"/>
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>会员名称</label>
                </dt>
                <dd class="opt">
                    <select name="member_name" id="member_name" onchange="javascript:checkmember();">
                        <option value=""></option>
                        <?php if (!empty($output['seller_list']) && is_array($output['seller_list'])) {
                            foreach ($output['seller_list'] as $key => $value) {
                                print '<option value="' . $output['member_name_array'][$value['member_id']]['member_name'] . '"';
                                print '>' . $output['member_name_array'][$value['member_id']]['member_name'] . '</option>';
                                print "\n";
                            }
                        }
                        ?>
                        <?php //echo $output['seller_group_array'][$value['seller_group_id']]['group_name']; ?>
                    </select>
                    <input type="hidden" name="member_id" id="member_id" value='0'/>
                    <span class="err"></span>
                    <p class="notic"><?php echo $lang['member_index_name'] ?></p>
                </dd>
            </dl>
            <dl class="row" id="tr_memberinfo">
                <dt class="tit">符合条件的会员</dt>
                <dd class="opt" id="td_memberinfo"></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>增减类型</label>
                </dt>
                <dd class="opt">
                    <select id="operatetype" name="operatetype">
                        <option value="1">增加</option>
                        <option value="2">减少</option>
<!--                        <option value="3">冻结</option>-->
<!--                        <option value="4">解冻</option>-->
                    </select>
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>金额</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="pointsnum" name="pointsnum" class="input-txt">
                    <span class="err"></span>
                    <p class="notic">对应金额填写</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>描述</label>
                </dt>
                <dd class="opt">
                    <textarea name="pointsdesc" rows="6" class="tarea"></textarea>
                    <span class="err"></span>
                    <p class="notic">描述信息将显示在预存款明细相关页，会员和管理员都可见</p>
                </dd>
            </dl>
            <button type="button" onclick="document.form1.submit()"><?php echo $lang['nc_submit']; ?></button>
        </div>
    </form>
</div>
<script type="text/javascript">
    function checkmember() {
        var membername = $.trim($("#member_name").val());
        if (membername == '') {
            $("#member_id").val('0');
            alert(<?php echo $lang['admin_points_addmembername_error']; ?>);
            return false;
        }
        $.getJSON("index.php?act=predeposit&op=checkmemberbalance", {'name': membername}, function (data) {
            if (data) {
                $("#tr_memberinfo").show();
                var msg = "会员" + data.name + "当前预存款为" + data.available_predeposit + "，当前冻结预存款为" + data.freeze_predeposit;
                $("#member_name").val(data.name);
                $("#member_id").val(data.id);
                $("#td_memberinfo").text(msg);
            }
            else {
                $("#member_name").val('');
                $("#member_id").val('0');
                alert("会员信息错误");
            }
        });
    }

    $(function () {
        $("#tr_memberinfo").hide();

        $('#points_form').validate({
            errorPlacement: function (error, element) {
                var error_td = element.parent('dd').children('span.err');
                error_td.append(error);
            },
            rules: {
                member_name: {
                    required: true
                },
                member_id: {
                    required: true
                },
                pointsnum: {
                    required: true,
                    min: 1
                }
            },
            messages: {
                member_name: {
                    required: '<i class="fa fa-exclamation-circle"></i>请输入会员名'
                },
                member_id: {
                    required: '<i class="fa fa-exclamation-circle"></i>会员信息错误，请重新填写会员名'
                },
                pointsnum: {
                    required: '<i class="fa fa-exclamation-circle"></i>请添加预存款',
                    min: '<i class="fa fa-exclamation-circle"></i>预存款必须大于0'
                }
            }
        });
    });

</script>