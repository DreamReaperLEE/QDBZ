<?php defined('In33hao') or exit('Access Invalid!');
$wapurl = WAP_SITE_URL;
	$agent = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($agent,"comFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS")){
		global $config;
        if(!empty($config['wap_site_url'])){
            $url = $config['wap_site_url'];
            switch ($_GET['act']){
			case 'goods':
			  $url .= '/tmpl/product_detail.html?goods_id=' . $_GET['goods_id'];
			  break;
			case 'store_list':
			  $url .= '/shop.html';
			  break;
			case 'show_store':
			  $url .= '/tmpl/store.html?store_id=' . $_GET['store_id'];
			  break;
			}
        } else {
            header('Location:'.$wapurl.$_SERVER['QUERY_STRING']);
        }
        header('Location:' . $url);
        exit();	
	}
?>
<!doctype html>
<html lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<meta name="keywords" content="<?php echo $output['seo_keywords']; ?>" />
<meta name="description" content="<?php echo $output['seo_description']; ?>" />
<meta name="author" content="33HAO">
<meta name="copyright" content="33HAO Inc. All Rights Reserved">
<meta name="renderer" content="webkit">
<meta name="renderer" content="ie-stand">
<?php echo html_entity_decode($output['setting_config']['qq_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['sina_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_qqzone_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_sinaweibo_appcode'],ENT_QUOTES); ?>
<style type="text/css">
body { _behavior: url(<?php echo SHOP_TEMPLATES_URL;
?>/css/csshover.htc);
}
</style>
<link rel="shortcut icon" href="<?php echo BASE_SITE_URL;?>/favicon.ico" />
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_header.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!--新首页-->
    <link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/new/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/new/css/style.css" type="text/css" rel="stylesheet">
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
<![endif]-->
<script>
var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var LOGIN_SITE_URL = '<?php echo LOGIN_SITE_URL;?>';var MEMBER_SITE_URL = '<?php echo MEMBER_SITE_URL;?>';var SITEURL = '<?php echo SHOP_SITE_URL;?>';var SHOP_SITE_URL = '<?php echo SHOP_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
</script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript">
var PRICE_FORMAT = '<?php echo $lang['currency'];?>%s';
$(function(){

	$(".quick-menu dl").hover(function() {
		$(this).addClass("hover");
	},
	function() {
		$(this).removeClass("hover");
	});

});
</script>
    <style>
        .public-top-layout .quick-menu a{font-size: 14px;color: #333 !important;}
    </style>
</head>
<body>
<!-- PublicTopLayout Begin -->
<!-- PublicHeadLayout Begin -->
<div class="header weui-bgf weui-bgf">
    <div class="container">
        <div class=" weui-pt15 weui-pb15 public-top-layout">
            <nav class="navbar navbar-default navbar-default1" role="navigation">
                <div class=" weui-fl logo"><a href="<?php echo SHOP_SITE_URL;?>"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.$output['setting_config']['site_logo']; ?>"/></a></div>
                <div class="weui-fr weui-pt15">
                    <?php if($_SESSION['is_login'] == '1'){?>
                        <span> <a href="<?php echo urlShop('member','home');?>"><?php echo $_SESSION['member_name'];?></a>
                            <?php if ($output['member_info']['level_name']){ ?>
                                <div class="nc-grade-mini" style="cursor:pointer;" onclick="javascript:go('<?php echo urlShop('pointgrade','index');?>');"><?php echo $output['member_info']['level_name'];?></div>
                            <?php } ?>
      </span><span class="wr"><a  class="btn btn-default" href="<?php echo urlLogin('login','logout');?>"><?php echo $lang['nc_logout'];?></a></span>
                    <?php }else{?>
                        <a href="<?php echo urlMember('login');?>" class="btn btn-default">登录</a>
                        <a href="<?php echo urlLogin('login','register');?>" class="btn btn-primary weui-ml10">立即注册</a>
                    <?php }?>
                    <div class="quick-menu">
                        <dl class="btn btn-default weui-ml10" style="width: 90px;height: 35px;">
                            <dt><a style="" href="<?php echo urlShop('show_joinin','index');?>" title="<?php echo $lang['hao_seller'];?>"><?php echo $lang['hao_seller'];?></a><i></i></dt>
                            <dd style="width: 88px">
                                <ul>
                                    <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=show_joinin&op=index" title="<?php echo $lang['hao_enter'];?>"><?php echo $lang['hao_enter'];?></a></li>
                                    <li><a href="<?php echo urlShop('seller_login','show_login');?>" target="_blank" title="<?php echo $lang['hao_seller_login'];?>"><?php echo $lang['hao_seller_login'];?></a></li>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="collapse navbar-collapse weui-fr weui-pt5" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav nav01 weui-f16">
                        <li class="active"><a href="<?php echo urlShop('index','index');?>">首页</a></li>
                        <?php if(!empty($output['class_top']) && is_array($output['class_top'])) { ?>
                            <?php foreach($output['class_top'] as $ke=>$val) { ?>
                                <?php if($ke<4) { ?>
                            <li><a href="<?php echo urlShop('search','index',array('cate_id'=> $val['gc_id']));?>"><?php echo $val['gc_name'];?></a></li>
                            <?php } } ?>
                        <?php } ?>
                        <li><a href="<?php echo urlMember('article', 'article',array('ac_id'=> 8));?>">通知公告 </a></li>
                    </ul>

                </div>
            </nav>
        </div>

    </div>
</div>

