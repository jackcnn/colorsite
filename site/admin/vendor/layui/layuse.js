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
    jQuery(".display-images").click(function () {
        var src= $(this).data('src');
        layer.open({
            title: '图片预览',
            btn:[],
            shadeClose:true,
            content: '<img src="'+src+'" style="width: 100%;"><br/><div style="display: block;width: 100%;padding: 10px;text-align: center;"><a target="_blank" href="'+src+'">查看原图</a></div>'
        });
    })
    jQuery(".colorsite-delete-confirm").click(function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        layer.confirm('你确定要删除这条记录吗？', {icon: 3, title:'提示'}, function(index){
            location.href= href;
            layer.close(index);
            return;
        });

    })
});


