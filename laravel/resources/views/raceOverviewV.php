<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>定位賽馬</title>
    <link rel="stylesheet" href="assets/css/vendors/bootstrap.min.css"> <!--logout-->
    <link rel="stylesheet" href="assets/css/vendors/font-awesome.min.css"> <!--選單-->
    <link rel="stylesheet" href="assets/css/vendors/woo/woocommerce.css"> <!--文字-->
    <link rel="stylesheet" href="assets/css/common/style.css"> <!--版面-->
</head>
<body class="woocommerce woocommerce-page" onload="define()">
<div class="wrap-main wrap-main-01">
    <header class="header">
        <div class="topbar">
            <div class="container">
                <div class="topbar__right">
                    <div class="account">
                        <i class="fa fa-smile-o"></i>
                        <ul class="tp-ul-no-padding tp-li-list-style">
                            <li><font color="red">賽馬遊戲</font></li>
                            <li> / </li>
                            <li><a href="logout">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- container -->
        </div>
        <!-- topbar -->
        <div class="navbar">
            <div class="container">
                <div class="header-mobile">
                    <div class="open-menu-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <nav class="main-nav">
                    <ul class="main-menu">
                        <li class="menu-item-has-children tp-activated">
                            <a href="/">賽馬遊戲</a>
                            <ul class="sub-menu">
                                <li class="menu-item-has-children">
                                    <a href="poIntroduceV">定位賽馬</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="bsIntroduceV">單雙大小賽馬</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children tp-activated">
                            <a href="raceOverviewV">投注總覽</a>
                            <ul class="sub-menu">
                                <li class="menu-item-has-children">
                                    <a href="raceOverviewV">投注總覽</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="accountStoredValueV">金額儲值</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children tp-activated">
                            <a href="#">盈餘總覽</a>
                            <ul class="sub-menu">
                                <li class="menu-item-has-children">
                                    <a href="bsBettingOverviewV">大小單雙投注結果</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="poBettingOverviewV">定位賽馬投注結果</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children tp-activated">
                            <a href="">賽馬管理</a>
                            <ul class="sub-menu">
                                <li class="menu-item-has-children">
                                    <a href="horseInsertV">新增賽馬</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="horseManageV">編輯賽馬</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="raceOddsV">賠率設定</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="/?action=lottery">賽馬開獎</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children tp-activated">
                            <a href="">會員管理</a>
                            <ul class="sub-menu">
                                <li class="menu-item-has-children">
                                    <a href="memberInsertV">會員新增</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="memberManageV">會員編輯</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="site-content-contain">
        <div id="content" class="site-content">
            <div class="wrap">
                <div id="primary" class="content-area">
                    <div class="container">
                        <nav class="woocommerce-breadcrumb">
                            <a href="#">賽馬遊戲</a>
                            大小單雙(投注金額)
                        </nav>
                    </div>
                    <div class="wrap-main-page-cart tp-content-page tp-page-title-16">
                        <div class="tp-content-cart-items">
                            <div class="tp-table-cart">
                                <div class="container">
                                    <div class="tp-content-table-cart">
                                        <form action="/" method="get">
                                            <table class="shop_table cart" >
                                                <thead>
                                                <font color="red" size="5">帳戶金額：<?php echo $memberData[0]->money; ?></font>
                                                <tr>
                                                    <th class="product-name">場次/名稱</th>
                                                    <th class="product-name">玩法</th>
                                                    <th class="product-name">金額</th>
                                                    <th class="product-name">賠率</th>
                                                    <th class="product-name">名次</th>
                                                    <th class="product-name">勝負</th>
                                                    <th class="product-name">獲利</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if($bettingData != NULL) {
                                                    $num = count($bettingData);
                                                    for ($k=0; $k<=$num-1; $k++) {
                                                        $value = $bettingData[$k];
                                                        ?>
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                               第<?php echo $value['horseRaceNum']; ?>場 /
                                                                <?php echo $value['horse_name']; ?>
                                                            </td>
                                                            <td class="product-name">
                                                                <?php
                                                                if($value['control'] == 1) {
                                                                    echo '買單數';
                                                                }
                                                                if($value['control'] == 2) {
                                                                    echo '買雙數';
                                                                }
                                                                if($value['control'] == 3) {
                                                                    echo '買比小';
                                                                }
                                                                if($value['control'] == 4) {
                                                                    echo '買比大';
                                                                }
                                                                if($value['control'] == 5) {
                                                                    echo '買定位( '.$value['h_rank'].' )';
                                                                }
                                                                if($value['money'] == 0) {
                                                                    echo '-----';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="product-name">
                                                                $ <?php echo $value['money']; ?>
                                                            </td>
                                                            <td class="product-name">
                                                                <?php echo $value['odds']; ?>
                                                            </td>
                                                            <td class="product-name">
                                                                <?php
                                                                if($value['r_rank'] == 0) {
                                                                    echo '-----';
                                                                }else{
                                                                    echo $value['r_rank'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="product-name">
                                                                <?php
                                                                if($value['win']==1 and $value['count']==2 and $value['money']!=0) {
                                                                    echo 'O';
                                                                }
                                                                if($value['win']==0 and $value['count']==2 and $value['money']!=0) {
                                                                    echo 'X';
                                                                }
                                                                if($value['win']==1 and $value['count']==3 and $value['money']!=0) {
                                                                    echo 'O';
                                                                }
                                                                if($value['win']==0 and $value['count']==3 and $value['money']!=0) {
                                                                    echo 'X';
                                                                }
                                                                if($value['count'] == 0){
                                                                    echo '未出賽';
                                                                }
                                                                if($value['money'] == 0) {
                                                                    echo '-----';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="product-quantity" data-title="Qty">
                                                                <?php
                                                                if($value['win']==1 and $value['count']==2 and $value['money']!=0) {
                                                                    echo $value['profit'];
                                                                }
                                                                if($value['win']==0 and $value['count']==2 and $value['money']!=0) {
                                                                    echo 0 ;
                                                                }
                                                                if($value['win']==1 and $value['count']==3 and $value['money']!=0) {
                                                                    echo $value['profit'];
                                                                }
                                                                if($value['win']==0 and $value['count']==3 and $value['money']!=0) {
                                                                    echo 0 ;
                                                                }
                                                                if($value['count'] == 0){
                                                                    echo '-----';
                                                                }
                                                                if($value['money'] == 0) {
                                                                    echo '未下注';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }else{
                                                    echo "尚未投注！";
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/vendors/jquery.min.js"></script> <!--點觸淡出效果-->
<script src="assets/js/vendors/bootstrap.min.js"></script> <!--點觸淡出效果-->
<script src="assets/js/menu.js"></script> <!--RWD縮小選單列-->

</body>
</html>