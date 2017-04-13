// show 2,3 dropdown when 1 dropdown contact field added with contactact number
function bpc_contact_ino_dd_field_1(value)
{
    $('#bpc_backup_number_text').css('display', 'block');
    $("#contact2").css('display', 'inline');
    // $("#contact3").css('display', 'inline');
}

$dropdowns = ['Please Select...', 'Mobile Phone', 'Home Phone', 'Office Phone'];
$selectedOption = [];

function bpc_clear_dropdown_options(id)
{
    $(id).html("");
}
function bpc_add_dropdown_options(id, options, val) {
    for(var i = 0; i < options.length; i++ ) {
        var isAddOption = true;
        for(j=0; j< val.length; j++) {
            if(val[j] == options[i])  {
                isAddOption = false;
            }
        }

        if(isAddOption) {
            $(id).append($(new Option(options[i], options[i])));
        }
    }
}

function bpc_display_inline(id) {
    document.getElementById(id).style.display='inline';
}

function bpc_set_empty_input(id)
{
    $(id).val("");
}

function bpc_hide_dropdown(id) {
    $(id).css('display', 'none');
}

//Call Me On
function bpccheckvalue1(val)
{ 
    // clear global selected option
    $selectedOption = [];

    if(val == 'Please Select...') {
        // hide other open dropdown and fields
        bpc_hide_dropdown('#contact22, #contact3,#contact33, #contact11, #bpc_backup_number_text, #contact2, #contact3');
        // empty the field open
        bpc_set_empty_input('#contact11');
    } else if(val == 'Mobile Phone') {
        document.getElementById('phoneimg1').innerHTML = '<img src="https://bookphonecall.com/wp-content/uploads/2017/01/mobile.png" width="21" height="30" style="margin-right: 10px;" />';
        document.getElementById('phonechoice').innerHTML = val;
        bpc_hide_dropdown('#contact22, #contact3,#contact33, #bpc_backup_number_text, #contact2, #contact3');
        // empty the field open
        bpc_set_empty_input('#contact11');
        // display field number
        bpc_display_inline('contact11');
    } else {
        document.getElementById('phoneimg1').innerHTML = '<img src="https://bookphonecall.com/wp-content/uploads/2017/01/phone.png" width="21" height="17" style="margin-right: 10px;" />';
        document.getElementById('phonechoice').innerHTML = val;
        // hide other open dropdown and fields
        bpc_hide_dropdown('#contact22, #contact3,#contact33, #bpc_backup_number_text, #contact2, #contact3');
        // empty the field open
        bpc_set_empty_input('#contact11');
        // display field number
        bpc_display_inline('contact11');
    }

    // store value to array
    $selectedOption[0] = val;
    // restore selected option in 2,3
    bpc_clear_dropdown_options("#contact2, #contact3");
    // add option dropdown in 2 and 3  ;
    bpc_add_dropdown_options("#contact2, #contact3", $dropdowns, $selectedOption);
}

function bpccheckvalue2(val)
{
    if(val == 'Please Select...') {
        // hide other open dropdown and fields
        bpc_hide_dropdown('#contact22, #contact33');
        // empty the field open
        bpc_set_empty_input('#contact22, #contact33');
        $selectedOption[1] = '';
    } else if(val == 'Mobile Phone') {
        document.getElementById('phoneimg2').innerHTML = '<img src="https://bookphonecall.com/wp-content/uploads/2017/01/mobile.png" width="21" height="30" style="margin-right: 10px;" />';       
        // empty the field open
        bpc_set_empty_input('#contact22');
        // display field number
        bpc_display_inline('contact22');
        // store value to array
        $selectedOption[1] = val;
    } else {
        document.getElementById('phoneimg2').innerHTML = '<img src="https://bookphonecall.com/wp-content/uploads/2017/01/phone.png" width="21" height="17" style="margin-right: 10px;" />';
        // empty the field open
        bpc_set_empty_input('#contact22');
        // display field number
        bpc_display_inline('contact22');
        // store value to array
        $selectedOption[1] = val;
    }

    // restore selected option in 2,3
    bpc_clear_dropdown_options("#contact3");
    // add option dropdown in 2 and 3  ;
    bpc_add_dropdown_options("#contact3", $dropdowns, $selectedOption);

}
// function bpccheckvalue3(val)
// {
//     if(val == 'Please Select...') {
//         // hide other open dropdown and fields
//         bpc_hide_dropdown('#contact33');
//         // empty the field open
//         bpc_set_empty_input('#contact33');
//     } else if(val == 'Mobile Phone') {
//         document.getElementById('phoneimg3').innerHTML = '<img src="http://bookphonecall.com/wp-content/uploads/2017/01/mobile.png" width="21" height="30" style="margin-right: 10px;" />';       
//         // display field number
//         bpc_display_inline('contact33');
//     } else  {
//         document.getElementById('phoneimg3').innerHTML = '<img src="http://bookphonecall.com/wp-content/uploads/2017/01/phone.png" width="21" height="17" style="margin-right: 10px;" />';
//         // display field number
//         bpc_display_inline('contact33');
//     }
// }