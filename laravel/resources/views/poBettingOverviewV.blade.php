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
                            盈餘總覽(定位賽馬)
                        </nav>
                    </div>
                    <div class="wrap-main-page-cart tp-content-page tp-page-title-16">
                        <div class="tp-content-cart-items">
                            <div class="tp-table-cart">
                                <div class="container">
                                    <div class="tp-content-table-cart">
                                        <form action="/" method="get">
                                            <table class="shop_table cart" >
                                                <thead>
                                                <font color="red" size="5">總獲利：{!! $sumProfit !!}</font>
                                                <tr>
                                                    <th class="product-name">場次</th>
                                                    <th class="product-name">下注筆數</th>
                                                    <th class="product-name">下注總額</th>
                                                    <th class="product-name">獲利</th>
                                                    <th class="product-name">虧損</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($poHorseRaceResultData != NULL)

                                                    @for ($k=0; $k<count($poHorseRaceResultData); $k++)
                                                        <?php
                                                        $value = $poHorseRaceResultData[$k];
                                                        ?>
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                                第{!! $value['num'] !!}場
                                                            </td>
                                                            <td class="product-name">
                                                                {!! $value['raceCount'] !!}
                                                            </td>
                                                            <td class="product-name">
                                                                $ {!! $value['sumBettingMoney'] !!}
                                                            </td>
                                                            <td class="product-name">
                                                                <font color="red"> $ {!! $value['winMoney'] !!} </font>
                                                            </td>
                                                            <td class="product-name">
                                                                $ {!! $value['loseMoney'] !!}
                                                            </td>
                                                        </tr>
                                                        @endfor
                                                @else
                                                    {!! "尚未投注！" !!}
                                                @endif
                                                </tbody>
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