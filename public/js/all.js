function ABTN(element=false,status=false){
    if(!element) return;
    var animation_btn=$(element);
    if(status){
        animation_btn.attr("data-old-text",animation_btn.html()).attr("disabled","disabled").addClass("disabled").text("Загрузка");
    }else{
        animation_btn.attr("disabled","false").removeClass("disabled").html(animation_btn.attr("data-old-text"));
    }
    
}

function ChangePassword(element){
    var isAdmin = confirm("Вы уверены,что хотите поменять пароль? Новый пароль будет отправлен Вам на почту, используйте его для входа в аккаунт");
    if(!isAdmin)return 0;
    ABTN(element,1);
    var token=$(element).attr('data-token');
    $.ajax({
        type: "POST",
        url: '/changepassword',
        data:{
            token:token,
        },

        }
    )
    .done(function(data) {
        if(data.success){
            ABTN(element,0);
        }
       
    })
    .fail(function () {
      
    })
}

function Restore(form,element){
  
    ABTN(element,1);
    $('#'+form).submit();
    
   
}

function Registration(form,element){
  
    // ABTN(element,1);
    $('#'+form).submit();
   
}