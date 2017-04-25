<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>會員資料修改</title>
    @include('partials.head')
</head>
<body class="woocommerce woocommerce-page">
<div class="wrap-main">
    @include('partials.nav')
    <div class="site-content-contain">
        <div id="content" class="site-content">
            <div class="wrap">
                <div id="primary" class="content-area">
                    <div class="container">
                        <nav class="woocommerce-breadcrumb">
                            <a href="/">賽馬遊戲</a>
                            會員資料修改
                        </nav>
                    </div>
                    <div class="wrap-main-page-cart tp-content-page tp-page-title-16">
                        <div class="tp-content-cart-items">
                            <div class="tp-table-cart">
                                <div class="container">
                                    <div class="actions">
                                        <div class="text-left tp-btn-con-shopping">
                                            <form action="memberManageV" method="get" enctype="multipart/form-data">
                                                <table border="1">
                                                    <tr>
                                                        <td colspan="2" align="center" bgcolor="#ABFFFF">會員資料</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" width="300px" bgcolor="#FFE1AB">名稱</td>
                                                        <td align="center" width="300px" bgcolor="#ABFFAB">email</td>
                                                    </tr>
                                                    @foreach($memberData as $value)
                                                        <tr>
                                                            <td><input type="text" name="name" value="{!! $value->name !!}"></td>
                                                            <td><input type="text" name="email" value="{!! $value->email !!}"></td>
                                                            <input type="hidden" name="id" value="{!! $value->id !!}">
                                                        </tr>
                                                        @endforeach
                                                </table>
                                                <br>
                                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                <input type="hidden" name="action" value="update">
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

