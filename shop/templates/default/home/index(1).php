
<div id="myCarousel" class="carousel slide">
    <!-- 轮播（Carousel）指标 -->
    <ol class="carousel-indicators">
        <?php if(!empty($output['web_img']) && is_array($output['web_img'])) { ?>
        <?php foreach($output['web_img'] as $k=>$val) { ?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $k; ?>" <?php if($k==0) { ?>class="active"<?php } ?>></li>
        <?php } ?>
        <?php } ?>
    </ol>
    <!-- 轮播（Carousel）项目 -->
    <div class="carousel-inner">
        <?php if(!empty($output['web_img']) && is_array($output['web_img'])) { ?>
        <?php foreach($output['web_img'] as $k=>$val) { ?>
        <div class="item  <?php if($k==0){ ?>active<?php } ?> ">
            <img src="<?php echo $val;?>" alt="First slide">
        </div>

        <?php } ?>
        <?php } ?>
    </div>

</div>

<div class="container weui-pt30 weui-pb30">
    <h3 class="weui-t_c weui-f24 weui-f_b"><span class="weui-blue"><?php echo substr($output['class_top'][0]['gc_name'],0,6)?></span><?php echo substr($output['class_top'][0]['gc_name'],6,6)?></h3>
    <p class="weui-t_c title_line"><span class="weui-dnb weui-p_r weui-c_9 weui-f18">Daily security</span></p>
    <div class="row weui-pb30">
        <?php if(!empty($output['class_bao']) && is_array($output['class_bao'])) { ?>
        <?php foreach($output['class_bao'] as $k=>$val) { ?>
            <div class="col-md-3 col-lg-3 col-sm-3 weui-pt30">
                <div class="weui-bgcolor weui-bod_r weui-p15">
                    <div class="media">
                        <div class="media-left"><span class="bz_box bz_ico1 bz_ico<?php echo $k+1?>"></span></div>
                        <div class="media-body">
                            <a href="<?php echo urlShop('search','index',array('cate_id'=> $val['gc_id']));?>">
                                <h4 class="media-heading weui-f18"><?php echo $val['gc_name']?></h4>
                                <span><?php echo $val['gc_title']?></span>
                                <p class="line"></p>
                                <div class="el2"><?php echo $val['gc_description']?></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php } ?>
    </div>

</div>

<div class="weui-bgcolor weui-pt30 weui-pb30">
    <div class="container">
        <h3 class="weui-t_c weui-f24 weui-f_b"><span class="weui-blue"><?php echo substr($output['class_top'][1]['gc_name'],0,6)?></span><?php echo substr($output['class_top'][1]['gc_name'],6,6)?></h3>
        <p class="weui-t_c title_line"><span class="weui-dnb weui-p_r weui-c_9 weui-f18">Technology and equipment</span></p>
        <div class="row weui-pt30 weui-pb30">
            <?php if(!empty($output['class_jisu']) && is_array($output['class_jisu'])) { ?>
            <?php foreach($output['class_jisu'] as $val) { ?>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="weui-bgf weui-bod pro">
                        <span><?php echo $val['gc_name']?>  </span>
                        <a href="<?php echo urlShop('search','index',array('cate_id'=> $val['gc_id']));?>"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_GOODS_CLASS.DS.$val['gc_image']?>" width="100%"></a>
                        <h4 class="weui-t_c weui-c_9 weui-f16"><?php echo $val['gc_title']; ?></h4>
                        <p class="line_t"></p>
                        <ul>
                            <?php if(!empty($val['goods']) && is_array($val['goods'])) { ?>
                            <?php foreach($val['goods'] as $v) { ?>
                                <li class="clearfix"><a href="<?php echo urlShop('goods','index',array('goods_id'=> $v['goods_id']));?>" class="weui-fl el1"> <?php echo substr_text($v['goods_name'], 0,14);?></a><span class="weui-fr"><?php echo date('m-d',$v['goods_addtime'])?></span></li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>



<div class="sjtjbg">
    <div class="container weui-white weui-pt30">
        <h3 class="weui-t_c weui-f24 weui-f_b">数据统计</h3>
        <p class="weui-t_c title_line"><span class="weui-dnb weui-p_r weui-f18">Data statistics</span></p>
        <div class="sjbg weui-t_c weui-f16">
            <a href="javascript:;" class="p1 ">
                <span class="Rotation"></span>
                <div class="weui-p_r">
                    <p class="weui-pt30"><img src="<?php echo SHOP_RESOURCE_SITE_URL;?>/new/images/bg_06.png" class="weui-pt15"></p>
                    <p>保障单位共计 <b class="weui-white weui-f18"><?php echo $output['numbers']['conpany']?></b><br>家</p>
                </div>
            </a>
            <a href="javascript:;" class="p2">
                <span class="Rotation"></span>
                <div class="weui-p_r">
                    <p class="weui-pt30"><img src="<?php echo SHOP_RESOURCE_SITE_URL;?>/new/images/bg_06.png" class="weui-pt15"></p>
                    <p>供应商共计 <b class="weui-white weui-f18"><?php echo $output['numbers']['store']?></b><br>家</p>
                </div>
            </a>
            <a href="javascript:;" class="p3">
                <span class="Rotation"></span>
                <div class="weui-p_r">
                    <p class="weui-pt30"><img src="<?php echo SHOP_RESOURCE_SITE_URL;?>/new/images/bg_06.png" class="weui-pt15"></p>
                    <p>服务数量共计 <b class="weui-white weui-f18"><?php echo $output['numbers']['goods']?></b><br>个</p>
                </div>
            </a>
            <a href="javascript:;" class="p4">
                <span class="Rotation"></span>
                <div class="weui-p_r">
                    <p class="weui-pt30"><img src="<?php echo SHOP_RESOURCE_SITE_URL;?>/new/images/bg_06.png" class="weui-pt15"></p>
                    <p>平台成交额共计 <b class="weui-white weui-f18"><?php echo $output['numbers']['orderamount']?></b><br>元</p>
                </div>
            </a>
            <a href="javascript:;" class="p5 ">
                <span class="Rotation"></span>
                <div class="weui-p_r">
                    <img src="<?php echo SHOP_RESOURCE_SITE_URL;?>/new/images/b_03.png" class="weui-pt15">
                </div>
            </a>
        </div>
    </div>
</div>


<div class="cgbg weui-pt30 weui-pb30">
    <div class="container">
        <h3 class="weui-t_c weui-f24 weui-f_b"><span class="weui-blue"><?php echo substr($output['class_top'][2]['gc_name'],0,6)?></span><?php echo substr($output['class_top'][2]['gc_name'],6,6)?></h3>
        <p class="weui-t_c title_line"><span class="weui-dnb weui-p_r weui-c_9 weui-f18">Material purchasing</span></p>
        <div class="row weui-pt30 weui-pb30">
            <?php if(!empty($output['class_gou']) && is_array($output['class_gou'])) { ?>
            <?php foreach($output['class_gou'] as $val) { ?>
            <div class="col-md-6 col-lg-6 col-sm-6">
                <div class="pro weui-bgf weui-bod">
                    <div class="weui-p_r"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_GOODS_CLASS.DS.$val['gc_image']?>" width="100%"><a href="#" class=" weui-f18 weui-f_b cg_a"><?php echo $val['gc_name']?></a></div>
                    <ul>
                        <?php if(!empty($val['goods']) && is_array($val['goods'])) { ?>
                        <?php foreach($val['goods'] as $v) { ?>
                        <li class="clearfix"><a href="<?php echo urlShop('goods','index',array('goods_id'=> $v['goods_id']));?>" class="weui-fl el1"> <?php echo $v['goods_name']?></a><span class="weui-fr"><?php echo date('m-d',$v['goods_addtime'])?></span></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php } ?>
            <?php } ?>
        </div>
    </div>

</div>

<div class="jypx">
    <div class="container weui-white weui-pt30 weui-pb30">
        <h3 class="weui-t_c weui-f24 weui-f_b"><?php echo $output['class_top'][3]['gc_name']?></h3>
        <p class="weui-t_c title_line"><span class="weui-dnb weui-p_r weui-f18">Education and training</span></p>
        <div id="myCarousel1" class="carousel slide">
            <!-- 轮播（Carousel）指标 -->
            <ol class="carousel-indicators carousel-indicators1">
                <?php if(!empty($output['class_teachs']) && is_array($output['class_teachs'])) { ?>
                    <?php foreach($output['class_teachs'] as $k=>$val) { ?>
                        <li data-target="#myCarousel1" data-slide-to="<?=$k?>"  <?php if($k==0) { ?>class="active"<?php } ?>></li>
                    <?php } ?>
                <?php } ?>
            </ol>
            <!-- 轮播（Carousel）项目 -->
            <div class="carousel-inner">
                <?php if(!empty($output['class_teachs']) && is_array($output['class_teachs'])) { ?>
                <?php foreach($output['class_teachs'] as $k=>$val) { ?>
                <div class="item  <?php if($k==0) { ?>active<?php } ?> weui-pb10">
                <div class="weui-bgf weui-pt30 weui-pb30 weui-pl30 weui-pr30 weui-box_s">
                <div class="row">
                    <?php if(!empty($val) && is_array($val)) { ?>
                    <?php foreach($val as $v) { ?>
                            <div class="col-md-4 col-lg-4 col-sm-4">
                                <div class="pro weui-bgf weui-bod lh24">
                                    <a href="<?php echo urlShop('goods','index',array('goods_id'=> $v['goods_id']));?>"><img src="<?php echo cthumb($v['goods_image'])?>" width="100%"></a>
                                    <div class="weui-pl5 weui-pr5">
                                        <a class="weui-db weui-pt10 weui-f16 weui-pb5 el1"><?php echo $v['goods_name']?></a>
                                        <p class="weui-c_6 el3"><?php echo $v['goods_jingle']?></p>
                                        <p class="clearfix"><span class="weui-fl weui-c_6"><?php echo date('Y-m-d',$v['goods_addtime'])?></span> <a href="<?php echo urlShop('goods','index',array('goods_id'=> $v['goods_id']));?>" class="weui-blue weui-fr">查看更多</a></p>
                                    </div>
                                </div>
                            </div>

                     <?php } ?>
                    <?php } ?>
                </div>
                </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="noticebg">
    <div class="container">
        <h3 class="weui-t_c weui-f24 weui-f_b"><span class="weui-blue">通知</span>公告</h3>
        <p class="weui-t_c title_line"><span class="weui-dnb weui-p_r weui-c_9 weui-f18">Announcements</span></p>
        <div class="row weui-pt30">
            <div class="col-md-6 col-lg-6 col-sm-6">
                <div class="media">
                    <div class="media-left">
                        <div class="data weui-t_c weui-white">
                            <span class=" weui-f36 weui-dnb weui-pt5 weui-pb5"><?php echo date('d',$output['notice'][0]['article_time'])?></span>
                            <p class=" weui-dnb weui-b_t weui-pt10"><?php echo date('Y-m',$output['notice'][0]['article_time'])?></p>
                        </div>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading news_bg"><a href="<?php echo urlMember('article', 'show',array('article_id'=> $output['notice'][0]['article_id']));?>" class=" weui-f18"><?php echo $output['notice'][0]['article_title']?></a></h4>
                        <span class="weui-c_9 lh24 weui-db el2"><?php echo substr_text(strip_tags($output['notice'][0]['article_content']),0,68)?></span>
                    </div>
                </div>
                <ul class="newslist">
                    <?php if(!empty($output['notice']) && is_array($output['notice'])) { ?>
                    <?php foreach($output['notice'] as $k=>$val) { ?>
                    <?php if($k>0) { ?>
                    <li class="weui-bgf clearfix"><a href="<?php echo urlMember('article', 'show',array('article_id'=> $val['article_id']));?>" class="weui-fl"><?php echo $val['article_title']?></a> <span class="weui-fr"><?php echo date('Y-m-d',$val['article_time'])?></span></li>
                    <?php }} ?>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-6 lh24">
                <div id="myCarousel2" class="carousel slide">

                    <!-- 轮播（Carousel）项目 -->
                    <div class="carousel-inner">
                        <?php if(!empty($output['notice']) && is_array($output['notice'])) { ?>
                        <?php foreach($output['notice'] as $k=>$val) { ?>
                        <?php if($k>0) { ?>
                        <div class="item <?php if($k==1) { ?>active<?php } ?> ">
                            <div>
                                <a href="<?php echo urlMember('article', 'show',array('article_id'=> $val['article_id']));?>"><img src="<?php echo $val['upload_path']?>" alt="First slide"></a>
                                <div class="weui-pt10"><a href="<?php echo urlMember('article', 'show',array('article_id'=> $val['article_id']));?>" class="weui-blue weui-f16"><?php echo $val['article_title']?></a></div>
                                <p class="weui-c_9"><?php echo substr_text(strip_tags($val['article_content']),0,68 );?></p>
                            </div>
                        </div>
                        <?php }} ?>
                        <?php } ?>
                    </div>
                    <!-- 轮播（Carousel）指标 -->
                    <ol class="carousel-indicators carousel-indicators2">
                        <?php if(!empty($output['notice']) && is_array($output['notice'])) { ?>
                        <?php foreach($output['notice'] as $k=>$val) { ?>
                        <?php if($k>0) { ?>
                        <li data-target="#myCarousel2" data-slide-to="<?=$k?>"  <?php if($k==1) { ?>class="active"<?php } ?>></li>
                         <?php }} ?>
                        <?php } ?>
                    </ol>
                </div>


            </div>
        </div>
        <div class="weui-t_c weui-pt30">
            <a href="<?php echo urlMember('article', 'article',array('ac_id'=> 8));?>" class="btn btn-more weui-f16">查看更多</a>
        </div>
    </div>
</div>
<?php
	function substr_text($str, $start=0, $length, $charset="utf-8", $suffix="")
	{
	if(function_exists("mb_substr")){
	return mb_substr($str, $start, $length, $charset).$suffix;
	}
	elseif(function_exists('iconv_substr')){
	return iconv_substr($str,$start,$length,$charset).$suffix;
	}
	$re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	preg_match_all($re[$charset], $str, $match);
	$slice = join("",array_slice($match[0], $start, $length));
	return $slice.$suffix;
	}
?>

<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/new/js/jquery.min.js"></script>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/new/js/bootstrap.min.js"></script>

<script>
    $('#myCarousel').carousel({
        interval: 2000
    })
    $('#myCarousel1').carousel({
        interval: 2000
    })
    $('#myCarousel2').carousel({
        interval: 2000
    })
</script>