<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- 引入样式 -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-default/index.css">
</head>
<body>
<div id="app">
    <el-radio class="radio" v-model="radio" label="1">备选项</el-radio>
    <el-radio class="radio" v-model="radio" label="2">备选项</el-radio>
    <el-button @click="visible = true">按钮</el-button>
    <el-dialog v-model="visible" title="Hello world">
        <p>欢迎使用 Element</p>
    </el-dialog>
</div>
</body>
<!-- 先引入 Vue -->
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<!-- 引入组件库 -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script>
    new Vue({
        el: '#app',
        data: function() {
            return {
                visible: false,
                radio : '1'
            }
        }
    })
</script>
</html>