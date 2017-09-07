//layui JavaScript代码区域
layui.use('element', function(){
    var element = layui.element;
});
layui.use('form', function(){
    var form = layui.form;
    //监听提交
    form.on('submit(formDemo)', function(data){
        //layer.msg(JSON.stringify(data.field));
        //return false;
    });
});
layui.use('layer', function(){
    var layer = layui.layer;
    //form表单中的图片预览
    jQuery(".display-images").click(function () {
        var src= $(this).data('src');
        layer.open({
            title: '图片预览',
            btn:[],
            shadeClose:true,
            content: '<img src="'+src+'" style="width: 100%;"><br/><div style="display: block;width: 100%;padding: 10px;text-align: center;"><a target="_blank" href="'+src+'">查看原图</a></div>'
        });
    })
    //删除按钮弹出的confirmed
    jQuery(".colorsite-delete-confirm").click(function (e) {
        e.preventDefault();
        var href = jQuery(this).attr('href');
        layer.confirm('你确定要删除这条记录吗？', {icon: 3, title:'提示'}, function(index){
            jQuery.post(href);//使用post防止点击链接直接删除了
            layer.close(index);
            return;
        });
    })
    //ifram显示页面,添加了类colorsite-iframe-show的a标签会触发
    jQuery(".colorsite-iframe-show").click(function (e) {
        e.preventDefault();
        var href = jQuery(this).attr('href');
        layer.open({
            type: 2,
            area:['40%', '70%'],
            content: href //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
    })
});


