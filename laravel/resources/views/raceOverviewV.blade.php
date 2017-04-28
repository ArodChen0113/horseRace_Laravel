<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>定位賽馬</title>
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
                            <a href="#">賽馬遊戲</a>
                            賽馬結果
                        </nav>
                    </div>
                    <div class="wrap-main-page-cart tp-content-page tp-page-title-16">
                        <div class="tp-content-cart-items">
                            <div class="tp-table-cart">
                                <div class="container">
                                    <div class="tp-content-table-cart">
                                        <form action="/" method="get">
                                            <table class="shop_table cart" >
                                                @if($horseGameData != NULL)
                                                <thead>
                                                <tr>
                                                    <th class="product-name">賽馬編號</th>
                                                    @for($i=1 ; $i<=10 ; $i++)
                                                    <th class="product-name">No.{!! $i !!}</th>
                                                    @endfor
                                                </thead>
                                                <tbody>
                                                <tr><td class="product-name">
                                                    </td>
                                                    @foreach($horseGameData as $value)
                                                        <td class="product-name">
                                                            {!! $value->horse_name !!}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                </tbody>
                                                <thead>
                                                <tr>
                                                    <th class="product-name">賽馬場次</th>
                                                    @for($i=1 ; $i<=10 ; $i++)
                                                        <th class="product-name">第 {!! $i !!} 名</th>
                                                @endfor
                                                </thead>
                                                <tbody>
                                                    @foreach($horseRaceData as $value)
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                              第 {!! $value->num !!} 場
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->first !!}
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->second !!}
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->third !!}
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->fourth !!}
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->fifth !!}
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->sixth !!}
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->seventh !!}
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->eighth !!}
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->ninth !!}
                                                            </td>
                                                            <td class="product-name">
                                                                No. {!! $value->tenth !!}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                </tbody>
                                                @else
                                                    {!! "尚未開賽！" !!}
                                                @endif
                                            </table>
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