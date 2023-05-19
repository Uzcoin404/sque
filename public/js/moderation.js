function ModerationStatusPublic(element){
    id = [];
    status_question = [];
    id.push($(element).attr("data-id-question"));
    status_question.push($(element).attr("data-status"));
    console.log(status_question, id);
    $.ajax({
        url: '/questions/updatestatus',
        method: 'get',
        dataType: 'html',
        data: {question_id: id, status_id: status_question},
        success: function(data){
            location.reload();
        }
    })
}

function BlockReturn(id){
    $('.block_return.'+id+'').css('height','100vh');
}

function BlockReturnClose(id){
    $('.block_return.'+id+'').css('height','0vh');
}