<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>賽馬資料編輯</title>
    @include('partials.head')
</head>
<body class="woocommerce woocommerce-page" onload="define()">
<div class="wrap-main">
    @include('partials.nav')
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
                                                    @for($k=0 ; $k<count($horseData) ; $k++)
                                                    <?php $value = $horseData[$k]; ?>
                                                        <tr>
                                                            <td align="center"><img src="/userUpload/{!! $value->horse_picture !!}" width="150" height="150"></td>
                                                            <td align="center">{!! $value->horse_name !!}</td>
                                                            <td align="center">{!! $value->horse_age !!}</td>
                                                            <td align="center">{!! $value->horse_introduce !!}</td>
                                                            <td align="center"><a href="horseUpdateV?hId={!! $value->h_id !!}&horseName={!! $value->horse_name !!}">
                                                                    <img src="icon/pencil.jpeg" width="30" height="30"></a></td>
                                                            <td align="center"><a href="horseManageV?action=delete&horseName={!! $value->horse_name !!}&hId={!! $value->h_id !!}">
                                                                    <img src="icon/x.jpeg" width="30" height="30"></a></td>
                                                        </tr>
                                                     @endfor
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

    @if($action == 'update')
        <script>
            function define() {
                alert("{!! $horseName !!} 資料已修改！");
            }
        </script>
    @endif
     @if($action == 'delete'){?>
        <script>
            function define() {
                alert("{!! $horseName !!} 資料已刪除！");
            }
        </script>
        @endif
    </body>
</html>