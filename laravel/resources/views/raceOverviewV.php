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
    <link href="assets/css/jsStar/jstarbox.css" rel="stylesheet"></link><!--評價星星效果-->
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
                        </li>
                        <li class="menu-item-has-children tp-activated">
                            <a href="raceSurplusV">盈餘總覽</a>
                            <ul class="sub-menu">
                                <li class="menu-item-has-children">
                                    <a href="bsBettingOverviewV">大小賽馬投注結果</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="sdBettingOverviewV">單雙賽馬投注結果</a>
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
                                                <tr>
                                                    <th class="product-name">賽馬名稱</th>
                                                    <th class="product-name">名次</th>
                                                    <th class="product-name">玩法</th>
                                                    <th class="product-name">金額</th>
                                                    <th class="product-name">勝負</th>
                                                    <th class="product-name">賠率</th>
                                                    <th class="product-name">獲利</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if($bettingData!=NULL) {
                                                    $num = count($bettingData);
                                                    for ($k = 0; $k <= $num - 1; $k++) {
                                                        $value = $bettingData[$k];
                                                        ?>
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                                <?php echo $value->horse_name; ?>
                                                            </td>
                                                            <td class="product-name">
                                                                <?php echo $value->h_rank; ?>
                                                            </td>
                                                            <td class="product-name">
                                                                <?php
                                                                if($value->control==1) {
                                                                    echo '買單數';
                                                                }
                                                                if($value->control==2) {
                                                                    echo '買雙數';
                                                                }
                                                                if($value->control==3) {
                                                                    echo '買比大';
                                                                }
                                                                if($value->control==4) {
                                                                    echo '買比小';
                                                                }
                                                                if($value->control==5) {
                                                                    echo '買定位';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="product-name">
                                                                $ <?php echo $value->money; ?>
                                                            </td>
                                                            <td class="product-name">
                                                                <?php
                                                                if($value->win==1) {
                                                                    echo 'O';
                                                                }
                                                                if($value->win==0) {
                                                                    echo 'X';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="product-name">
                                                                <?php echo $value->odds; ?>
                                                            </td>
                                                            <td class="product-quantity" data-title="Qty">
                                                                <?php
                                                                if($value->win==1) {
                                                                    echo $value->profit;
                                                                }
                                                                if($value->win==0) {
                                                                    echo '- $ '.$value->profit;
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <font color="red">目前餘額：<?php echo $memberData[0]->money;?></font>
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
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script> <!--評價星星效果-->
<script src="assets/jstarbox.js"></script> <!--評價星星效果-->

</body>
</html>