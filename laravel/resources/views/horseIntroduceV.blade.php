<!doctype html>
<html class="no-js">
<head>
    <title>賽馬介紹</title>
    @include('partials.head')
</head>
<body class="woocommerce woocommerce-page" onload="define()">
<div class="wrap-main wrap-main-01">
    @include('partials.nav')
<div class="site-content-contain">
    <div id="content" class="site-content">
        <div class="wrap">
            <div id="primary" class="content-area">
                <div class="container">
                    <nav class="woocommerce-breadcrumb">
                        <a href="/">賽馬遊戲</a>
                        賽馬介紹
                    </nav>
                </div>
                <br>
                <br>
                <h3 class="title-homepage-center">賽馬介紹</h3>
                <div class="container tab-product-01">
                    <div class="tab-content shortcode-product-slider-01">
                        <!--全部-->
                        <div role="tabpanel" class="tab-pane active" id="all">
                            <div class="row">
                                @foreach($horseData as $value)
                                    <div class="col-md-3 col-xs-6">
                                        <div class="product type-product has-post-thumbnail">
                                            <div class="product-image">
                                                <img src="/userUpload/{!! $value->horse_picture !!}" alt="shop item">
                                            </div>
                                            <span class="onnew">HOT</span>
                                            <h3><a href="product-detail.html">編號：{!! $value->h_id !!} <font color="red">{!! $value->horse_name !!}</font>
                                                    AGE：{!! $value->horse_age !!}
                                                </a></h3>
                                            <div class="product-info">
                                                <div class="price">
                                                    <span class="woocommerce-Price-amount amount">{!! $value->horse_introduce !!}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="explore-more"><a class="tp-button" href="bsBettingV">我 要 下 注</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('partials.bodyJs')
@if($action == 'bsBetting' && $alert['control'] == 1)
    <script>
        function define() {
            alert("第{!! $alert['h_rank'] !!}名 下注單 已投注！");
        }
    </script>
@endif
@if($action == 'bsBetting' && $alert['control'] == 2)
    <script>
        function define() {
            alert("第{!! $alert['h_rank'] !!}名 下注雙 已投注！");
        }
    </script>
@endif
@if($action == 'bsBetting' && $alert['control'] == 3)
    <script>
        function define() {
            alert("第{!! $alert['h_rank'] !!}名 下注小 已投注！");
        }
    </script>
@endif
@if($action == 'bsBetting' && $alert['control'] == 4)
    <script>
        function define() {
            alert("第{!! $alert['h_rank'] !!}名 下注大 已投注！");
        }
    </script>
@endif
@if($action =='poBetting')
    <script>
        function define() {
            alert("{!! $alert !!} 已投注！");
        }
    </script>
@endif
@if($action == 'lottery')
    <script>
        function define() {
            alert("賽馬已開獎！");
        }
    </script>
@endif
</body>
</html>