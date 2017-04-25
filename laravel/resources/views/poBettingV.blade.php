<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>定位賽馬</title>
    @include('partials.head')
    <script>
        function bettingForm(){
            var money = document.forms["betting"]["money"].value;
            var rank = document.forms["betting"]["rank"].value;
            if (money < 100){
                alert("下注金額最少為100");
                return false;
            }
            if (money > {!! $memberData[0]->money !!}){
                alert("帳戶金額不足！");
                return false;
            }
            if (rank == null || rank == ''){
                alert("請選擇賽馬名次");
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
                                                    <th class="product-quantity">賽馬名次</th>
                                                    <th class="product-remove">刪除</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($bettingData != NULL)
                                                    @foreach($bettingData as $value)
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
                                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                            <input type="hidden" name="num" value="{!! $value->num !!}">
                                                            <input type="hidden" name="horseName" value="{!! $value->horse_name !!}">
                                                            <input type="hidden" name="control" value="5">
                                                            <input type="hidden" name="action" value="poBetting">
                                                            <td class="product-remove" data-title="Remove"><a
                                                                    href="poIntroduceV?action=delete&hId={!! $value->h_id !!}&num={!! $value->num !!}" class="remove">×</a></td>
                                                        </tr>
                                                        @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                            玩法介紹： 選擇賽馬，猜中您指定名次，即可獲得獎金。
                                            <font color="blue">目前賠率：{!! $odds[0]->odds !!}。 </font>
                                            <font color="red"> 帳戶金額：$NT. {!! $memberData[0]->money !!}。 </font>
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