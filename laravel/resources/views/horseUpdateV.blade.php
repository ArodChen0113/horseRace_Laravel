<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>賽馬資料修改</title>
    @include('partials.head')
</head>
<body class="woocommerce woocommerce-page">
<div class="wrap-main">
    @include(('partials.nav'))
    <div class="site-content-contain">
        <div id="content" class="site-content">
            <div class="wrap">
                <div id="primary" class="content-area">
                    <div class="container">
                        <nav class="woocommerce-breadcrumb">
                            <a href="/">賽馬遊戲</a>
                            賽馬資料修改
                        </nav>
                    </div>
                    <div class="wrap-main-page-cart tp-content-page tp-page-title-16">
                        <div class="tp-content-cart-items">
                            <div class="tp-table-cart">
                                <div class="container">
                                    <div class="actions">
                                        <div class="text-left tp-btn-con-shopping">
                                            <form action="action_horse" method="post" enctype="multipart/form-data">
                                                <table border="1">
                                                    <tr>
                                                        <td colspan="4" align="center" bgcolor="#ABFFFF">賽馬資料</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" width="300px" bgcolor="#FFABFF">圖片</td>
                                                        <td align="center" width="300px" bgcolor="#FFE1AB">名稱</td>
                                                        <td align="center" width="300px" bgcolor="#ABFFAB">年齡</td>
                                                        <td align="center" width="300px" bgcolor="#FFABFF">介紹</td>
                                                    </tr>
                                                    @foreach($horseData as $value)
                                                        <tr>
                                                            <td align="center"><img src="/userUpload/{!! $value->horse_picture !!}" width="150"
                                                                                    height="150"></td>
                                                            <td><input type="text" name="horseName" value="{!! $value->horse_name !!}"></td>
                                                            <td><input type="text" name="horseAge" value="{!! $value->horse_age !!}"></td>
                                                            <td><input type="text" name="horseIntroduce" value="{!! $value->horse_introduce !!}"></td>
                                                            <input type="hidden" name="hId" value="{!! $value->h_id !!}">
                                                        </tr>
                                                        @endforeach
                                                </table>
                                                <br>
                                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                <input type="hidden" name="token" value="{!! $token !!}">
                                                <input type="hidden" name="action" value="update">
                                                <input type="submit" value="確定修改">
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
</body>
</html>

