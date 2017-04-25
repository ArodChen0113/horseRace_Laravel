<!doctype html>
<html class="no-js">
<head>
    <title>單雙大小賽馬</title>
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
                                @foreach($horseData as $value)
                                    <div class="col-md-3 col-xs-6">
                                        <div class="product type-product has-post-thumbnail">
                                            <div class="product-image">
                                                <img src="/userUpload/{!! $value->horse_picture !!}" alt="shop item">
                                            </div>
                                            <span class="onnew">HOT</span>
                                            <h3><a href="product-detail.html"><font color="red">{!! $value->horse_name !!}</font>
                                                    AGE：{!! $value->horse_age !!}
                                                </a></h3>
                                            <div class="product-info">
                                                <div class="price">
                                                    <span class="woocommerce-Price-amount amount">{!! $value->horse_introduce !!}</span>
                                                </div>
                                            </div>
                                            <a href="bsBettingV?action=insert&hId={!! $value->h_id !!}" class="button add_to_cart_button">選擇賽馬</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="explore-more"><a class="tp-button" href="raceOverviewV">下 注 總 覽</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('partials.bodyJs')

@if($action == 'delete')
    <script>
        function define() {
            alert("{!! $horseName !!} 已刪除！");
        }
    </script>
    @endif
</body>
</html>