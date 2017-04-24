<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>賽馬金額儲值</title>
@include('partials.head')
</head>
<body class="woocommerce woocommerce-page" onload="define()">
<div class="wrap-main">
    @include('partials.nav')
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
                                                        <h3>賽馬金額儲值 <font color="red">帳戶金額 : {!! $money !!}</font></h3>
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
                                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
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
@include('partials.bodyJs')
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