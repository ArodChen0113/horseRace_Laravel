<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>賽馬賠率設定</title>
    @include('partials.head')
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
                            賽馬賠率設定
                        </nav>
                    </div>
                    <div class="wrap-main-page-cart tp-content-page tp-page-title-16">
                        <div class="tp-content-cart-items">
                            <div class="tp-table-cart">
                                <div class="container">
                                    <div class="actions">
                                        <div class="text-left tp-btn-con-shopping">
                                            <form action="raceOddsV" method="get" enctype="multipart/form-data">
                                                <table border="1">
                                                    <tr>
                                                        <td colspan="4" align="center" bgcolor="#ABFFFF">賽馬遊戲資料</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" width="300px" bgcolor="#FFABFF">遊戲名稱</td>
                                                        <td align="center" width="300px" bgcolor="#FFE1AB">賠率</td>
                                                    </tr>

                                                    @foreach($oddsData as $value)
                                                        <tr>
                                                            <td><input type="text" name="gameName[]" value="{!! $value->game_name !!}"></td>
                                                            <td><input type="text" name="odds[]" value="{!! $value->odds !!}"></td>
                                                            <input type="hidden" name="num[]" value="{!! $value->num !!}">
                                                        </tr>
                                                    @endforeach
                                                </table>
                                                <br>
                                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                <input type="hidden" name="action" value="update2">
                                                <input type="submit" value="確定修改">
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

