<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>賽馬資料編輯</title>
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
    <body>
    <div class="site-content-contain">
        <div id="content" class="site-content">
            <div class="wrap">
                <div id="primary" class="content-area">
                    <div class="container">
                        <nav class="woocommerce-breadcrumb">
                            <a href="/">賽馬遊戲</a>
                            賽馬資料編輯&刪除
                        </nav>
                    </div>
                    <div class="wrap-main-page-cart tp-content-page tp-page-title-16">
                        <div class="tp-content-cart-items">
                            <div class="tp-table-cart">
                                <div class="container">
                                    <div class="actions">
                                        <div class="">
                                            <form action="orderPay_update.php" method="post" enctype="multipart/form-data">
                                                <table border="1">
                                                    <tr>
                                                        <td colspan="6" align="center" bgcolor="#FFABAB">賽馬資料</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" width="300px" bgcolor="#FFE1AB">圖片</td>
                                                        <td align="center" width="300px" bgcolor="#ABFFAB">名稱</td>
                                                        <td align="center" width="300px" bgcolor="#00FFFF">年齡</td>
                                                        <td align="center" width="300px" bgcolor="#00FFFF">介紹</td>
                                                        <td align="center" width="300px" bgcolor="#DBABFF">修改</td>
                                                        <td align="center" width="300px" bgcolor="#FFABAB">刪除</td>
                                                    </tr>

                                                    <?php
                                                    $num = count($horseData);
                                                    for($k=0 ; $k<$num ; $k++) {
                                                        $value = $horseData[$k];
                                                        ?>
                                                        <tr>
                                                            <td align="center"><img src="/userUpload/<?php echo $value->horse_picture; ?>" width="150" height="150"></td>
                                                            <td align="center"><?php echo $value->horse_name; ?></td>
                                                            <td align="center"><?php echo $value->horse_age; ?></td>
                                                            <td align="center"><?php echo $value->horse_introduce; ?></td>
                                                            <td align="center"><a href="horseUpdateV?hId=<?php echo $value->h_id; ?>&horseName=<?php echo $value->horse_name; ?>"><img src="icon/pencil.jpeg" width="30" height="30"></a></td>
                                                            <td align="center"><a href="horseManageV?action=delete&horseName=<?php echo $value->horse_name; ?>&hId=<?php echo $value->h_id; ?>"><img src="icon/x.jpeg" width="30" height="30"></a></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </table>
                                                <br>
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

    <?php if($action == 'update'){?>
        <script>
            function define() {
                alert("<?php echo $horseName;?> 資料已修改！");
            }
        </script>
        <?php
    } if($action == 'delete'){?>
        <script>
            function define() {
                alert("<?php echo $horseName;?> 資料已刪除！");
            }
        </script>
        <?php
    }
    ?>
    </body>
</html>