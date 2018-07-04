<ul class="tab pngFix">
    <?php
    $condition2['member_id'] = $_SESSION['member_id'];
    $model_seller = Model('seller');
    $seller_info = $model_seller->getSellerInfo($condition2);
    $is_company = $seller_info['is_company'];

    if (is_array($output['member_menu']) and !empty($output['member_menu'])) {
        foreach ($output['member_menu'] as $key => $val) {
            if($is_company != 2 && $val[menu_name] == '余额提现')
            {
                continue;
            }
            if ($val['menu_key'] == $output['menu_key']) {
                echo '<li class="active"><a ' . (isset($val['target']) ? "target=" . $val['target'] : "") . ' href="' . $val['menu_url'] . '">' . $val['menu_name'] . '</a></li>';
            } else {
                echo '<li class="normal"><a ' . (isset($val['target']) ? "target=" . $val['target'] : "") . ' href="' . $val['menu_url'] . '">' . $val['menu_name'] . '</a></li>';
            }
        }
    }
    ?>
</ul>
