(function($){
    $(function(){


      //Materialize.toast('提交成功！我们将尽快联系你', 4000)

        $('.button-collapse').sideNav();

        $('.modal').modal();


        $("#submit").click(function () {
            var name = $("#submit_name").val();
            var tel = $("#submit_phone").val();
            var list = new Array();
            $(".func").each(function(){
              if($(this).is(":checked")){
                list.push($(this).val());
              }
            });

            $.post(URL,{
              name:name,
                tel:tel,
                list:list
            },function(res){

                Materialize.toast(res.msg, 4000);


                $('.modal').modal('close');

            });
        })

    }); // end of document ready
})(jQuery); // end of jQuery name space