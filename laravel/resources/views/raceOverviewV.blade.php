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
                            大小單雙(投注金額)
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
                                                <font color="red" size="5">帳戶金額：{!! $memberData[0]->money !!}</font>
                                                <tr>
                                                    <th class="product-name">場次/名稱</th>
                                                    <th class="product-name">玩法</th>
                                                    <th class="product-name">金額</th>
                                                    <th class="product-name">賠率</th>
                                                    <th class="product-name">名次</th>
                                                    <th class="product-name">勝負</th>
                                                    <th class="product-name">獲利</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($bettingData != NULL)
                                                    @for ($k=0; $k<count($bettingData); $k++)
                                                        <?php $value = $bettingData[$k]; ?>
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                               第{!! $value['horseRaceNum'] !!}場 /
                                                                {!! $value['horse_name'] !!}
                                                            </td>
                                                            <td class="product-name">
                                                                @if($value['control'] == 1)
                                                                    {!! '買單數' !!}
                                                                @endif
                                                                @if($value['control'] == 2)
                                                                    {!! '買雙數' !!}
                                                                @endif
                                                                @if($value['control'] == 3)
                                                                    {!! '買比小' !!}
                                                                @endif
                                                                @if($value['control'] == 4)
                                                                    {!! '買比大' !!}
                                                                @endif
                                                                @if($value['control'] == 5)
                                                                    {!! '買定位( '.$value['h_rank'].' )' !!}
                                                                @endif
                                                                @if($value['money'] == 0)
                                                                    {!! '-----' !!}
                                                                @endif
                                                            </td>
                                                            <td class="product-name">
                                                                $ {!! $value['money'] !!}
                                                            </td>
                                                            <td class="product-name">
                                                                {!! $value['odds'] !!}
                                                            </td>
                                                            <td class="product-name">
                                                                @if($value['r_rank'] == 0)
                                                                    {!! '-----' !!}
                                                                @else
                                                                    {!! $value['r_rank'] !!}
                                                                @endif
                                                            </td>
                                                            <td class="product-name">
                                                                @if($value['win']==1 and $value['count']==2 and $value['money']!=0)
                                                                    {!! 'O' !!}
                                                                @endif
                                                                @if($value['win']==0 and $value['count']==2 and $value['money']!=0)
                                                                    {!! 'X' !!}
                                                                @endif
                                                                @if($value['win']==1 and $value['count']==3 and $value['money']!=0)
                                                                    {!! 'O' !!}
                                                                @endif
                                                                @if($value['win']==0 and $value['count']==3 and $value['money']!=0)
                                                                    {!! 'X' !!}
                                                                @endif
                                                                @if($value['count'] == 0)
                                                                    {!! '未出賽' !!}
                                                                @endif
                                                                @if($value['money'] == 0)
                                                                    {!! '-----' !!}
                                                                @endif
                                                            </td>
                                                            <td class="product-quantity" data-title="Qty">
                                                                @if($value['win']==1 and $value['count']==2 and $value['money']!=0)
                                                                    {!! $value['profit'] !!}
                                                                @endif
                                                                @if($value['win']==0 and $value['count']==2 and $value['money']!=0)
                                                                    {!! 0 !!}
                                                                @endif
                                                                @if($value['win']==1 and $value['count']==3 and $value['money']!=0)
                                                                    {!! $value['profit'] !!}
                                                                @endif
                                                                @if($value['win']==0 and $value['count']==3 and $value['money']!=0)
                                                                    {!! 0 !!}
                                                                @endif
                                                                @if($value['count'] == 0)
                                                                    {!! '-----' !!}
                                                                @endif
                                                                @if($value['money'] == 0)
                                                                    {!! '未下注' !!}
                                                                @endif
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