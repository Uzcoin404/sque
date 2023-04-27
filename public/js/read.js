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