<!doctype html>
<html class="no-js">
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
                            <a href="/">賽馬遊戲</a>
                            大小單雙
                        </nav>
                    </div>
                    <br>
                    <br>
                    <h3 class="title-homepage-center">請先選擇<font color="red">賽馬</font>，即可下注</h3>
                    <div class="container tab-product-01">
                        <div class="tab-content shortcode-product-slider-01">
                            <!--全部-->
                            <div role="tabpanel" class="tab-pane active" id="all">
                                <div class="row">
                                    <?php
                                    $num = count($horseData);
                                    for($i=0 ; $i<$num ; $i++){
                                        $value = $horseData[$i];
                                        ?>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="product type-product has-post-thumbnail">
                                                <div class="product-image">
                                                    <img src="/userUpload/<?php echo $value->horse_picture; ?>" alt="shop item">
                                                </div>
                                                <span class="onnew">HOT</span>
                                                <h3><a href="product-detail.html"><font color="red"><?php echo $value->horse_name;?></font>
                                                        AGE：<?php echo $value->horse_age;?>
                                                    </a></h3>
                                                <div class="product-info">
                                                    <div class="price">
                                                        <span class="woocommerce-Price-amount amount"><?php echo $value->horse_introduce;?></span>
                                                    </div>
                                                </div>
                                                <a href="poBettingV?action=insert&hId=<?php echo $value->h_id;?>" class="button add_to_cart_button">選擇賽馬</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="explore-more"><a class="tp-button" href="raceOverviewV">下 注 總 覽</a></div>
                            </div>
                        </div>
                        <div class="product-quickview">
                            <div class="container">
                                <div class="btn-close">
                                    <i class="fa fa-times"></i>
                                </div>
                                <div class="content-product-quickview">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="image-product-detail images">
                                                <img src="/userUpload/{{ Input::get('pic') }}" alt="product detail">
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
    </div>
</div>
<script src="assets/js/vendors/jquery.min.js"></script> <!--點觸淡出效果-->
<script src="assets/js/vendors/bootstrap.min.js"></script> <!--點觸淡出效果-->
<script src="assets/js/vendors/swiper.min.js"></script> <!--訂購圖片放大-->
<script src="assets/js/global.js"></script> <!--訂購圖片放大-->
<script src="assets/js/menu.js"></script> <!--RWD縮小選單列-->
<?php
if($action == 'delete'){?>
    <script>
        function define() {
            alert("<?php echo $horseName;?> 已刪除！");
        }
    </script>
    <?php
}
?>
</body>
</html>