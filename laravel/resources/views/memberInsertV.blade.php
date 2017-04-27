<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>會員資料新增</title>
    @include('partials.head')
    <script>
        function memberForm(){
            var name = document.forms["member"]["name"].value;
            var email = document.forms["member"]["email"].value;
            var password = document.forms["member"]["password"].value;
            var i;
            if (name == null || name == ''){
                alert("請填寫會員名稱");
                return false;
            }
            if (email == null || email == ''){
                alert("請填寫會員信箱");
                return false;
            }
            var atpos = email.indexOf("@");
            var dotpos = email.lastIndexOf(".");
            if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
                alert("不是一個有效的 e-mail 地址");
                return false;
            }
            if (password == null || password == ''){
                alert("請填寫會員密碼");
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
                            新增會員資料
                        </nav>
                    </div>
                    <div class="tp-content-page tp-page-title-16">
                        <div class="tp-content-checkout-items">
                            <div class="container">
                                <div class="row">
                                    <div class="tp-checkout-form tp-form-site">
                                        <form id="member" action="action_member" method="post" class="checkout woocommerce-checkout" enctype="multipart/form-data" onsubmit="return memberForm()">
                                            <div class="col2-set">
                                                <div class="col-1 col-md-6 col-sm-6 col-xs-12">

                                                    <div class="woocommerce-billing-fields">
                                                        <h3>賽馬新增</h3>
                                                        <div class="form-row">
                                                            <label >會員名稱 <abbr class="required" title="required">*</abbr></label>
                                                            <input type="text" name="name" placeholder="請輸入會員名稱">
                                                        </div>
                                                        <div class="form-row">
                                                            <label>會員信箱 <abbr class="required" title="required">*</abbr></label>
                                                            <input type="text" name="email" placeholder="請輸入會員信箱">
                                                        </div>
                                                        <div class="form-row">
                                                            <label>會員密碼 <abbr class="required" title="required">*</abbr></label>
                                                            <input type="password" name="password" placeholder="請輸入會員密碼">
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