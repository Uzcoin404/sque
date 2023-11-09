function AcceptRead(){
    $.ajax({
        url: '/readstatus',
        method: 'get',
        dataType: 'html',
        data: {status: 1},
        success: function(data){
            window.location.replace('/');
        }
    })
}

function CloseRead(){
    $.ajax({
        url: '/readstatus',
        method: 'get',
        dataType: 'html',
        data: {status: 0},
        success: function(data){
            window.location.replace('/');
        }
    })
}

function SubmitInfo(element){
    $status = $(element).attr('data-status');
    $.ajax({
        url: '/info_post',
        method: 'get',
        dataType: 'html',
        data: {status: $status},
        success: function(data){
            data = JSON.parse(data);
            $('.block_btn_info_text_status[data-status="'+$status+'"] .block_btn_info_text_status_text').empty();
            $('.block_btn_info_text_status[data-status="'+$status+'"] .block_btn_info_text_status_text').append(data['text_ru']);
        }
    })

    if($('.block_btn_info_text_status[data-status="'+$status+'"] .block_btn_info_text_status_text').hasClass('active')){
        $('.block_btn_info_text_status[data-status="'+$status+'"] .block_btn_info_text_status_text').removeClass('active');
    } else {

        document.querySelectorAll('.block_btn_info_text_status_text').forEach(el => {
            el.classList.remove('active');
        });

        $('.block_btn_info_text_status[data-status="'+$status+'"] .block_btn_info_text_status_text').addClass('active');
    }
}

