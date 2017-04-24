<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>單雙大小賽馬</title>
    @include('partials.head')
    <script>
        function bettingForm(){
            var money = document.forms["betting"]["money"].value;
            var control = document.forms["betting"]["control"].value;
            if (money < 100){
                alert("下注金額最少為100");
                return false;
            }
            if (money > {!! $memberData[0]->money !!}){
                alert("帳戶金額不足！");
                return false;
            }
            if (control == null || control == ''){
                alert("請選擇投注項目(大小單雙)");
                return false;
            }
        }
    </script>
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
                                        <form id="betting" action="/" method="get" onsubmit="return bettingForm()">
                                            <table class="shop_table cart" >
                                                <thead>
                                                <tr>
                                                    <th class="product-name">賽馬圖片</th>
                                                    <th class="product-name">賽馬名稱</th>
                                                    <th class="product-price">下注金額</th>
                                                    <th class="product-quantity">單雙小大</th>
                                                    <th class="product-remove">刪除</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($bettingData != NULL)

                                                    @for ($k = 0; $k<count($bettingData); $k++)
                                                        <?php
                                                        $value = $bettingData[$k];
                                                        ?>
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                                <img
                                                                    src="/userUpload/{!! $value->horse_picture !!}"
                                                                    width="150" height="150"></td>
                                                            </td>
                                                            <td class="product-name">
                                                                {!! $value->horse_name !!}
                                                            </td>
                                                            <td class="product-price" data-title="Price">
                                                                $ NT. <input type="text" class="product-name" name="money" id="money" min="100">
                                                            </td>
                                                            <td class="product-quantity" data-title="Qty">
                                                                <input type="radio" class="product-name" name="control" id="control"
                                                                       value="1">單
                                                                <input type="radio" class="product-name" name="control" id="control"
                                                                       value="2">雙</br>
                                                                <input type="radio" class="product-name" name="control" id="control"
                                                                       value="3">小
                                                                <input type="radio" class="product-name" name="control" id="control"
                                                                       value="4">大
                                                            </td>
                                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                            <input type="hidden" name="num" value="{!! $value->num !!}">
                                                            <input type="hidden" name="horseName" value="{!! $value->horse_name !!}">
                                                            <input type="hidden" name="action" value="bsBetting">
                                                            <td class="product-remove" data-title="Remove"><a
                                                                    href="bsIntroduceV?action=delete&hId={!! $value->h_id !!}&num={!! $value->num !!}"
                                                                    class="remove">×</a></td>
                                                        </tr>
                                                        @endfor
                                                @endif

                                                </tbody>
                                            </table>
                                            玩法介紹： 選擇賽馬，投注單雙小大，猜中即可獲得獎金(小:1~5名，大:6~10名) 。
                                            <font color="blue">目前賠率：{!! $odds[0]->odds !!}。 </font>
                                            <font color="red">帳戶金額：{!! $memberData[0]->money !!}</font>
                                            <input type="submit" value="確定下注">
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
 @if($action == 'insert')
    <script>
        function define() {
            alert("{!! $alert !!} 已選擇！");
        }
    </script>
 @endif
</body>
</html>