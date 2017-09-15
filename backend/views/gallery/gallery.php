<?php
/**
 * Date: 2017/9/15 0015
 * Time: 11:17
 */
use yii\helpers\Html;

$this->title = '图片管理:'.$model->title;
$this->params['breadcrumbs'][] = ['label' => '图集列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-gallery">

    <h1 class="layform-h1"><?= Html::encode($this->title) ?></h1>
    <p style="padding: 15px 0px;">
        <button type="button" class="layui-btn" id="upload-images">
            <i class="layui-icon">&#xe681;</i>上传图片
        </button>

        <button type="button" class="layui-btn" id="save-sort">
            保存排序
        </button>

    </p>
    <div class="gallery-form layform-block">
        <div class="layui-row list-group" id="sortable">
            <?php foreach($list as $key=>$value){?>
                <div class="layui-col-md2 layui-col-md-offset1 el-card-box list-group-item">
                    <div class="el-card">
                        <div class="el-card-body">
                            <div class="el-card-top">
                                <a data-id="<?=$value['id']?>" class="el-card-delete layui-btn layui-btn-mini layui-btn-danger">删除</a>
                            </div>
                            <img src="<?=$value['path']?>" class="el-card-img">
                            <div class="el-card-footer">
                                <input data-id="<?=$value['id']?>" class="layui-input layui-input-small" type="text" value="<?=$value['name']?>" />
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<?php

$id = intval(\Yii::$app->request->get("id",0));
$url = \yii\helpers\Url::to(['upload','gallery_id'=>$id]);
$delete_images = \yii\helpers\Url::to(['delete-image']);
$image_name =\yii\helpers\Url::to(['image-name']);
$save_sort =\yii\helpers\Url::to(['save-sort','gallery_id'=>$id]);
$js=<<<JS
layui.use(['upload','layer'], function(){
  var upload = layui.upload;
  var layer = layui.layer;
  //文件上传 执行实例
  var uploadInst = upload.render({
    elem: '#upload-images' //绑定元素
    ,url: '{$url}' //上传接口
    ,done: function(res){
      //上传完毕回调
      if(res.code == 0){
          var data=res.data;
          var dom=create_one(data.path,data.name,data.id);
          jQuery(".layui-row").prepend(dom);
      }
    }
    ,error: function(){
      //请求异常回调
    }
  });
  
  jQuery(document).on("click",".el-card-delete",function(){
      var self = jQuery(this);
        layer.confirm('你确定要删除这种图片吗', {icon: 3, title:'提示'}, function(index){
            jQuery.get('{$delete_images}',{
                id:self.data("id")
            },function(data){
                if(data.success){
                    self.parent().parent().parent().parent().remove();
                    layer.msg('删除成功！');
                }
            });
            layer.close(index);
        });
  })
  jQuery(document).on("change",".layui-input",function(){
      var self = jQuery(this);
        jQuery.get('{$image_name}',{
            id:self.data("id"),
            name:encodeURI(self.val())
        },function(data){
            layer.msg('修改成功！');
        });
  })
  
  jQuery("#save-sort").click(function() {
    var sorts = new Array();
    jQuery(document).find(".layui-input").each(function() {
      sorts.push(jQuery(this).data("id"));
    })
    jQuery.post('{$save_sort}',{
            sorts:sorts
        },function(data){
            layer.msg('修改成功！');
        });
  })
  
  
  
  
}); 
var sort_list = document.getElementById("sortable");
new Sortable(sort_list); // That's all.

function create_one(src,title,id)
{
    var dom='<div class="layui-col-md2 layui-col-md-offset1 el-card-box">\
                    <div class="el-card">\
                        <div class="el-card-body">\
                            <div class="el-card-top">\
                                <a data-id="'+id+'" class="el-card-delete layui-btn layui-btn-mini layui-btn-danger">删除</a>\
                            </div>\
                            <img src="'+src+'" class="el-card-img">\
                            <div class="el-card-footer">\
                                <input data-id="'+id+'" class="layui-input layui-input-small" type="text" value="'+title+'" />\
                            </div>\
                        </div>\
                    </div>\
                </div>';
    return dom;
}


JS;
$this->registerJS($js);
$this->registerJSFile("/admin/vendor/layui/Sortable.min.js");
?>
<style>
.el-card-body{
    position: relative;
}
.el-card-box{
 margin-top:15px;
}
.el-card {
    border: 1px solid #d1dbe5;
    border-radius: 4px;
    background-color: #fff;
    overflow: hidden;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.12),0 0 6px 0 rgba(0,0,0,.04);
}
.el-card-img{
    display: inline-block;
    width:100%;
}
.el-card-footer{
    display: block;
    width:100%;
    padding:14px;
    box-sizing: border-box;
}
.el-card-top{
    position: absolute;
    top:0px;
    left:0px;
    padding:10px 14px;
    width:100%;
    box-sizing: border-box;
}
.el-card-top a{
    float: right;
}
</style>