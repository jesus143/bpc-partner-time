function pbc_home_time_show(idNum)
{
    for(var i =0; i<10; i++) {
        $("#bpc-home-time-box-display-"+i).css('display','none');
    }
    $("#bpc-home-time-box-display-"+idNum).css('display','block');
}
function bpc_tick_time_set_bg(id)
{
    $('#e3ve-cl-times-'+id).css("background-image", "url(https://bookphonecall.com/wp-content/uploads/2017/01/time-clicked.png)");
    setTimeout(function(){
        $('#e3ve-cl-times-'+id).css("background-image", "url(https://bookphonecall.com/wp-content/uploads/2017/01/time-start.png)");
    }, 2000);
}