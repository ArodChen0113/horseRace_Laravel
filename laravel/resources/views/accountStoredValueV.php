<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>賽馬金額儲值</title>
    <link rel="stylesheet" href="assets/css/vendors/bootstrap.min.css"> <!--logout-->
    <link rel="stylesheet" href="assets/css/vendors/font-awesome.min.css"> <!--選單-->
    <link rel="stylesheet" href="assets/css/vendors/woo/woocommerce.css"> <!--文字-->
    <link rel="stylesheet" href="assets/css/common/style.css"> <!--版面-->
</head>
<body class="woocommerce woocommerce-page" onload="define()">
<div class="wrap-main">
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
                            賽馬金額儲值
                        </nav>
                    </div>
                    <div class="tp-content-page tp-page-title-16">
                        <div class="tp-content-checkout-items">
                            <div class="container">
                                <div class="row">
                                    <div class="tp-checkout-form tp-form-site">
                                        <form action="accountStoredValueV" method="get" class="checkout woocommerce-checkout" enctype="multipart/form-data">
                                            <div class="col2-set">
                                                <div class="col-1 col-md-6 col-sm-6 col-xs-12">

                                                    <div class="woocommerce-billing-fields">
                                                        <h3>賽馬金額儲值 <font color="red">帳戶金額 : <?php echo $money;?></font></h3>
                                                        <div class="form-row">
                                                            <label >儲值金額 <abbr class="required" title="required">*</abbr></label>
                                                            <input type="text" name="money" placeholder="請輸入欲儲值金額">
                                                        </div>
                                                        <div class="form-row">
                                                            <label>付款方式 <abbr class="required" title="required">*</abbr></label>
                                                            <input type="radio" name="payWay" value="1"> Visa<br>
                                                            <input type="radio" name="payWay" value="2"> Master<br>
                                                            <input type="radio" name="payWay" value="3"> 線上點數<br>
                                                        </div>
                                                        <input type="hidden" name="action" value="pay">
                                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                        <div class="form-row place-order">
                                                            <input type="submit"  class="button" value="確認儲值 ">
                                                        </div>
                                                    </div>
                                                </div><!-- end col 1 -->
                                            </div>
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
<script src="assets/js/menu.js"></script> <!--RWD縮小選單列-->
<?php if($action == 'pay'){?>
<script>
    function define() {
        alert("金額 <?php echo $memberName;?> 已儲值！");
    }
</script>
<?php
}
?>
</body>
</html>