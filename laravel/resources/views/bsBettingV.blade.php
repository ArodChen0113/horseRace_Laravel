<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>單雙大小賽馬</title>
    @include('partials.head')
    <script>
        function bettingForm(){
            var rank = document.forms["betting"]["rank"].value;
            var money = document.forms["betting"]["money"].value;
            var control = document.forms["betting"]["control"].value;
            if (rank == null || rank == ''){
                alert("請選擇賽馬名次");
                return false;
            }
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
                                        <form id="betting" action="action_horseRace" method="post" onsubmit="return bettingForm()">
                                            <table class="shop_table cart" >
                                                <thead>
                                                <tr>
                                                    <th class="product-name">賽馬名次</th>
                                                    <th class="product-price">下注金額</th>
                                                    <th class="product-quantity">單雙小大</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                        <tr class="cart_item">
                                                            <td class="product-quantity" data-title="Qty">
                                                                <select name="rank">
                                                                    <option value="">請選擇下注名次</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="7">7</option>
                                                                    <option value="8">8</option>
                                                                    <option value="9">9</option>
                                                                    <option value="10">10</option>
                                                                </select>
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
                                                            <input type="hidden" name="token" value="{!! $token !!}">
                                                            <input type="hidden" name="action" value="bsBetting">
                                                        </tr>
                                                </tbody>
                                            </table>
                                            玩法介紹： 選擇賽馬名次，投注單雙小大，猜中即可獲得獎金(小:賽馬編號1~5，大:賽馬編號6~10) 。
                                            <font color="blue">目前賠率：{!! $odds[0]->odds !!}。 </font>
                                            <font color="red">帳戶金額：{!! $memberData[0]->money !!}</font>
                                            <input type="submit" value="確定下注">
                                            @if (count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
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