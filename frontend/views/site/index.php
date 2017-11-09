<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>橙蓝科技</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/assets/materialize/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/assets/materialize/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/assets/chenglansite/icon/iconfont.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="#" class="brand-logo">
            <div class="icon iconfont icon-logo"></div>
            橙蓝网络
        </a>
        <ul class="right hide-on-med-and-down">
           <li><a href="#modal1" class="modal-trigger">联系我们</a></li>
         </ul>

         <ul id="nav-mobile" class="side-nav">
           <li><a href="#modal1" class="modal-trigger">联系我们</a></li>
         </ul>
         <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
</nav>
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <br><br>
        <h1 class="header center orange-text">橙蓝科技</h1>
        <div class="row center">
            <h5 class="header col s12 light">不只是工作 也可以是合作</h5>
        </div>
        <div class="row center">
            <a href="#modal1" id="download-button" class="btn-large waves-effect waves-light orange modal-trigger">联系我们</a>
        </div>
        <br><br>

    </div>
</div>


<div class="container">
    <div class="section">

        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12 m3">
                <div class="icon-block">
                    <h2 class="center light-blue-text"><i class="material-icons">devices</i></h2>
                    <h5 class="center">网站应用开发</h5>

                    <p class="light">网站建设综合服务，是为企业提供一对一的定制建站方案，帮助企业在网络中全面展示品牌优势，扩大商业影响力</p>
                </div>
            </div>

            <div class="col s12 m3">
                <div class="icon-block">
                    <h2 class="center light-blue-text"><i class="material-icons">group</i></h2>
                    <h5 class="center">公众帐号开发</h5>

                    <p class="light">微信公众帐号开发，为亿万微信用户提供轻便的服务。</p>
                </div>
            </div>

            <div class="col s12 m3">
                <div class="icon-block">
                    <h2 class="center light-blue-text"><i class="material-icons">all_inclusive</i></h2>
                    <h5 class="center">微信小程序开发</h5>

                    <p class="light">一种新的开放能力，可以在微信内被便捷地获取和传播，同时具有出色的使用体验。</p>
                </div>
            </div>

            <div class="col s12 m3">
                <div class="icon-block">
                    <h2 class="center light-blue-text"><i class="material-icons">web</i></h2>
                    <h5 class="center">搭建运营服务</h5>

                    <p class="light">不仅为你开发好所需的功能，更提供专业的搭建与运营服务，免去额外的学习成本，更好的关注你的业务。</p>
                </div>
            </div>


        </div>

    </div>
    <br><br>
</div>

<footer class="page-footer orange">
    <div class="container">
        <div class="row">
            <div class="col l7 s12">
                <h5 class="white-text">公司理念</h5>
                <p class="grey-text text-lighten-4">
                    以实事求是为原则，打造信赖产品；以坚守承诺为准绳，建立诚信团队。<br/>
                    以尽职尽责的态度，担当工作职责；以乐于奉献的精神，承担公司责任。
                </p>


            </div>
            <div style="display:none;" class="col l3 s12">
                <h5 class="white-text">Settings</h5>
                <ul>
                    <li><a class="white-text" href="#!">Link 1</a></li>
                    <li><a class="white-text" href="#!">Link 2</a></li>
                    <li><a class="white-text" href="#!">Link 3</a></li>
                    <li><a class="white-text" href="#!">Link 4</a></li>
                </ul>
            </div>
            <div style="display:none;" class="col l3 s12">
                <h5 class="white-text">Connect</h5>
                <ul>
                    <li><a class="white-text" href="#!">Link 1</a></li>
                    <li><a class="white-text" href="#!">Link 2</a></li>
                    <li><a class="white-text" href="#!">Link 3</a></li>
                    <li><a class="white-text" href="#!">Link 4</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            Copyright © 2017 <a class="orange-text text-lighten-3" href="javascript:;">广州市橙蓝网络科技有限公司, All Rights Reserved</a>
        </div>
    </div>
</footer>


<div id="modal1" class="modal">
    <div class="modal-content">
        <h4>联系我们</h4>
        <p>提交你的信息，我们将尽快联系你。</p>
        <div class="row">
            <form method="post" class="col s12">
                <div class="row">
                    <div class="input-field col m6 s12">
                        <input id="submit_name" type="text" class="">
                        <label for="submit_name">姓名</label>
                    </div>
                    <div class="input-field col m6 s12">
                        <input id="submit_phone" type="text" class="">
                        <label for="submit_phone">手机号</label>
                    </div>
                </div>
                <div class="row">

                    <div class="col m12 s12">
            <span>
              <input type="checkbox" name="list[]" value="网站开发" class="func filled-in" id="filled-in-box-1" />
              <label for="filled-in-box-1">网站开发</label>
            </span>
                        <span>
              <input type="checkbox" name="list[]" value="微信公众号开发" class="func filled-in" id="filled-in-box-2" />
              <label for="filled-in-box-2">微信公众号开发</label>
            </span>
                        <span>
              <input type="checkbox" name="list[]" value="小程序开发" class="func filled-in" id="filled-in-box-3" />
              <label for="filled-in-box-3">小程序开发</label>
            </span>
                        <span>
              <input type="checkbox" name="list[]" value="搭建代运营服务" class="func filled-in" id="filled-in-box-4" />
              <label for="filled-in-box-4">搭建代运营服务</label>
            </span>
                        <span>
              <input type="checkbox" name="list[]" value="其他" class="func filled-in" id="filled-in-box-5" />
              <label for="filled-in-box-5">其他</label>
            </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6">
                        <a id="submit" class="waves-effect waves-light orange btn">提交</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="/assets/materialize/js/materialize.min.js"></script>
<script>
    var URL="<?=\yii\helpers\Url::to(['/site/index'])?>";
</script>
<script src="/assets/materialize/js/init.js"></script>
</body>
</html>
