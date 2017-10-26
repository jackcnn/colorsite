<?php
/**
 * Date: 2017/10/23
 * Time: 9:57
 */
?>
<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Logo</a>
        <ul class="right hide-on-med-and-down">
            <li><a href="#">女装类目</a></li>
            <li><a href="#">男装类目</a></li>
            <li><a href="#">家电类目</a></li>
            <li><a href="#">手机类目</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
            <li><a href="#">女装类目</a></li>
            <li><a href="#">男装类目</a></li>
            <li><a href="#">家电类目</a></li>
            <li><a href="#">手机类目</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
</nav>


<!--头部轮播图-->
<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 m9">
                <div class="carousel carousel-slider">
                    <a class="carousel-item" href="#one!"><img src="/uploads/common/1.jpg"></a>
                    <a class="carousel-item" href="#two!"><img src="/uploads/common/2.jpg"></a>
                    <a class="carousel-item" href="#three!"><img src="/uploads/common/3.jpg"></a>
                    <a class="carousel-item" href="#four!"><img src="/uploads/common/5.jpg"></a>
                </div>
            </div>
            <div class="col s12 m3 bg-white header-right-list">
                <h5><span></span>今日推荐</h5>
                <ul>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                    <li><a href="#!">光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗光阳陶器手作陶瓷杯碗</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>

<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 m12">
                <h3 class="block-title">男装</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m3">
                <a class="card-link" href="#">
                <div class="card">
                    <div class="card-image">
                        <img src="/uploads/common/11.jpg">
                    </div>
                    <div class="card-content">
                        <span>潮流男装潮流男装潮流男装潮流男装装潮流男装潮流男装装潮流男装潮流男装</span>
                    </div>
                </div>
                </a>
            </div>
            <div class="col s12 m3">
                <a class="card-link" href="#">
                    <div class="card">
                        <div class="card-image">
                            <img src="/uploads/common/11.jpg">
                        </div>
                        <div class="card-content">
                            <span>潮流男装潮流男装潮流男装潮流男装</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col s12 m3">
                <a class="card-link" href="#">
                    <div class="card">
                        <div class="card-image">
                            <img src="/uploads/common/11.jpg">
                        </div>
                        <div class="card-content">
                            <span>潮流男装潮流男装潮流男装潮流男装</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col s12 m3">
                <a class="card-link" href="#">
                    <div class="card">
                        <div class="card-image">
                            <img src="/uploads/common/11.jpg">
                        </div>
                        <div class="card-content">
                            <span>潮流男装潮流男装潮流男装潮流男装</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
    <br><br>
</div>



<?php
$js = <<<JS

$('.carousel.carousel-slider').carousel({fullWidth: true,indicators:true,duration:50});

// setInterval(function(){
//     $('.carousel').carousel('next');
// },5000)

$(document).on("mouseover",".indicator-item",function(){
    console.log($(this).index())
    $('.carousel').carousel('set',$(this).index());
})

JS;

$this->registerJS($js);

?>
