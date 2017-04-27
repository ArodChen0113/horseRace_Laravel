<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>賽馬資料新增</title>
    @include('partials.head')
    <script>
        function horseForm(){
            var horseName = document.forms["horse"]["horseName"].value;
            var horseAge = document.forms["horse"]["horseAge"].value;
            var horseIntroduce = document.forms["horse"]["horseIntroduce"].value;
            if (horseName == null || horseName == ''){
                alert("請填寫賽馬名稱");
                return false;
            }
            if (horseAge == null || horseAge == ''){
                alert("請填寫賽馬年齡");
                return false;
            }
            if (horseAge > 20){
                alert("賽馬年齡過大(無法參加比賽)");
                return false;
            }
            if (horseIntroduce == null || horseIntroduce == ''){
                alert("請填寫賽馬介紹");
                return false;
            }
        }
    </script>
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
                            新增賽馬資料
                        </nav>
                    </div>
                    <div class="tp-content-page tp-page-title-16">
                        <div class="tp-content-checkout-items">
                            <div class="container">
                                <div class="row">
                                    <div class="tp-checkout-form tp-form-site">
                                        <form id="horse" action="action_horse" method="post" class="checkout woocommerce-checkout" enctype="multipart/form-data" onsubmit="return horseForm()">
                                            <div class="col2-set">
                                                <div class="col-1 col-md-6 col-sm-6 col-xs-12">
                                                    <div class="woocommerce-billing-fields">
                                                        <h3>賽馬新增</h3>
                                                        <div class="form-row">
                                                            <label >賽馬名稱 <abbr class="required" title="required">*</abbr></label>
                                                            <input type="text" name="horseName" placeholder="請輸入賽馬名稱">
                                                        </div>
                                                        <div class="form-row">
                                                            <label>賽馬年齡 <abbr class="required" title="required">*</abbr></label>
                                                            <input type="text" name="horseAge" placeholder="請輸入賽馬年齡">
                                                        </div>
                                                        <div class="form-row">
                                                            <label>賽馬介紹 <abbr class="required" title="required">*</abbr></label>
                                                            <input type="text" width="10" height="10" name="horseIntroduce" placeholder="請輸入賽馬介紹">
                                                        </div>
                                                        <input type="hidden" name="action" value="insert">
                                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                        <input type="hidden" name="token" value="{!! $token !!}">
                                                        <div class="form-row place-order">
                                                            <input type="submit"  class="button" value="確認新增 ">
                                                        </div>
                                                        @if (count($errors) > 0)
                                                            <div class="alert alert-danger">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
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
</body>
</html>