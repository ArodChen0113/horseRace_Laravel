<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>會員資料編輯</title>
    @include('partials.head')
</head>
<body class="woocommerce woocommerce-page" onload="define()">
<div class="wrap-main">
    @include('partials.nav')
    <body>
    <div class="site-content-contain">
        <div id="content" class="site-content">
            <div class="wrap">
                <div id="primary" class="content-area">
                    <div class="container">
                        <nav class="woocommerce-breadcrumb">
                            <a href="/">賽馬遊戲</a>
                            會員資料編輯&刪除
                        </nav>
                    </div>
                    <div class="wrap-main-page-cart tp-content-page tp-page-title-16">
                        <div class="tp-content-cart-items">
                            <div class="tp-table-cart">
                                <div class="container">
                                    <div class="actions">
                                        <div class="">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <table border="1">
                                                    <tr>
                                                        <td colspan="6" align="center" bgcolor="#FFABAB">會員資料</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" width="300px" bgcolor="#ABFFAB">名稱</td>
                                                        <td align="center" width="300px" bgcolor="#00FFFF">信箱</td>
                                                        <td align="center" width="300px" bgcolor="#FFFFAB">金額</td>
                                                        <td align="center" width="300px" bgcolor="#DBABFF">修改</td>
                                                        <td align="center" width="300px" bgcolor="#FFABAB">刪除</td>
                                                    </tr>
                                                    @foreach($memberData as $value)
                                                        <tr>
                                                            <td align="center">{!! $value->name !!}</td>
                                                            <td align="center">{!! $value->email !!}</td>
                                                            <td align="center">{!! $value->money !!}</td>
                                                            <td align="center"><a href="memberUpdateV?id={!! $value->id !!}&memberName={!! $value->name !!}">
                                                                    <img src="icon/pencil.jpeg" width="30" height="30"></a></td>
                                                            <td align="center"><a href="action_memberDel?token={!! $token !!}&action=delete&id={!! $value->id !!}">
                                                                    <img src="icon/x.jpeg" width="30" height="30"></a></td>
                                                        </tr>
                                                        @endforeach
                                                </table>
                                                <br>
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
    @if($action == 'update')
        <script>
            function define() {
                alert("{!! $memberName !!} 資料已修改！");
            }
        </script>
        @endif
    @if($action == 'delete')
        <script>
            function define() {
                alert("{!! $memberName !!} 資料已刪除！");
            }
        </script>
        @endif
    @if($action == 'insert')
        <script>
            function define() {
                alert("{!! $memberName !!} 資料已新增！");
            }
        </script>
        @endif
    </body>
</html>