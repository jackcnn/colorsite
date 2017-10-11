<!DOCTYPE html>
<html>
<head>
    <title>Test1-模块-CSS实现无滚动条滚动</title>

    <meta charset="UTF-8" >
    <style type="text/css">
        .wrap{width:500px;height:500px;overflow:hidden;}
        .box1{width:500px;height:500px;margin:0 20px;overflow-y:scroll;overflow-x:hidden;background-color:#eee;}
        .box2{height:1000px;}
    </style>
</head>

<body>
<div class="wrap">
    <div class="box1">
        <div class="box2">
            <p>box1和box2实现在一定高度的节点(box1)里展示大于该高度的节点(box2)</p>
            <p>box2里面滚动了多少可以通过box1.scrollTop来获取</p>
            <p style="margin-bottom:850px;">wrap作为最外层的节点，作用是用来隐藏滚动条的</p>
            <p id="end">The-end</p>
        </div>
    </div>
</div>
</body>

</html>