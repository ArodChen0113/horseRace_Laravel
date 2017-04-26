<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>無瀏覽權限</title>
    @include('partials.head')
</head>
<body class="woocommerce woocommerce-page">
<div class="wrap-main">
    @include('partials.nav')
    <div class="site-content-contain">
        <div id="content" class="site-content">
            <div class="wrap">
                <div id="primary" class="content-area">
                    <div class="container">
                        <nav class="woocommerce-breadcrumb">
                            <a href="/">賽馬遊戲</a>
                            無瀏覽權限
                        </nav>
                    </div>
                    <div class="wrap-main-page-cart tp-content-page tp-page-title-16">
                        <div class="tp-content-cart-items">
                            <div class="tp-table-cart">
                                <div class="container">
                                    <div class="tp-content-table-cart">
                                        <table class="shop_table cart" >
                                            <thead>
                                            <font color="red" size="3">抱歉，您無此網頁瀏覽權限！</font>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- table cart -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@include('partials.bodyJs')
</body>
</html>