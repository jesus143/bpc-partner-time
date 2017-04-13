//Calendar
  $( function() {
    $( "#datepicker" ).datepicker({ minDate: 0, firstDay: 1 });
  });
  $(document).on("change", "#datepicker", function () {
  	  $datenow = $.datepicker.formatDate("dd/mm/yy", $(this).datepicker("getDate"));
      document.getElementById('callbackdate').value = $datenow;
  })



  //Facebook
    function statusChangeCallback(response) {
      console.log('statusChangeCallback');
      console.log(response);
      if (response.status === 'connected') {
        bpc_getFBUser();
      } else if (response.status === 'not_authorized') {
        document.getElementById('status').innerHTML = 'Please log ' +
          'into this app.';
      } else {
        document.getElementById('status').innerHTML = 'Please log ' +
          'into Facebook.';
      }
    }
    function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }

    window.fbAsyncInit = function() {
      FB.init({
        appId      : '1844321809114387',
        cookie     : true,
        xfbml      : true,
        version    : 'v2.8'
      });
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    };
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function bpc_getFBUser() {

      console.log('Welcome!  Fetching your information.... ');
      FB.api('/me?fields=id,first_name,last_name,email,gender,birthday', function(response) {
        console.log('Successful login for: ' + response.first_name + ' ' + response.last_name + response.email + response.gender + response.birthday);
        document.getElementById('fb-status').innerHTML =
          '<p>See Facebook user information below:</p> ' + 
          'Full Name: ' + response.first_name + ' ' + response.last_name + '<br>Email Address: ' + response.email + '<br>Gender: ' + response.gender + '<br>Birthday: ' + response.birthday;
        document.getElementById('e3ve-first-name').value = response.first_name;
        document.getElementById('e3ve-last-name').value = response.last_name;
        document.getElementById('e3ve-email').value = response.email;
        document.getElementById('e3ve-fbemail').value = response.email;
        document.getElementById('e3ve-gender').value = response.gender;
        document.getElementById('e3ve-birthday').value = response.birthday;
        if (response.gender == 'male') {
          document.getElementById('e3ve-title').value = 'Mr';
        } else if (response.gender == 'female') { 
          document.getElementById('e3ve-title').value = 'Ms';
        }
      });
    }



//Call Me On
  function bpccheckvalue1(val)
  {
      if(val==="mobilecontact1")
        document.getElementById('contact11').style.display='inline';
      else if(val==="homecontact1")
        document.getElementById('contact11').style.display='inline';
      else if(val==="officecontact1")
        document.getElementById('contact11').style.display='inline';
  }
  function bpccheckvalue2(val)
  {
      if(val==="mobilecontact2")
        document.getElementById('contact22').style.display='inline';
      else if(val==="homecontact2")
        document.getElementById('contact22').style.display='inline';
      else if(val==="officecontact2")
        document.getElementById('contact22').style.display='inline'; 
  }
  function bpccheckvalue3(val)
  {
      if(val==="mobilecontact3")
        document.getElementById('contact33').style.display='inline';
      else if(val==="homecontact3")
        document.getElementById('contact33').style.display='inline';
      else if(val==="officecontact3")
        document.getElementById('contact33').style.display='inline'; 
  }

$(document).ready(function(){
  // Submit button disabled
  $("#bookphonecallsubmit").attr("disabled","disabled");
  $("#agreement").click(function(){
    if($("#agreement").is(":checked")){
      $("#bookphonecallsubmit").removeAttr("disabled");   
    }
    else{
      $("#bookphonecallsubmit").attr("disabled","disabled");
    }
  });

  $("input[name='enquiry']").click(function () {
    $('#organisationname-column').css('display', ($(this).val() === 'organisation') ? 'block':'none');
    document.getElementById('director-column-q').style.display='none';
  });

  $("input[name='enquiry']").click(function () {
    $('#director-column').css('display', ($(this).val() === 'ltdcompany') ? 'block':'none');
  });

  $( "#company" ).keyup(function(e) {
    var query = $(this).val(); 
    $( "#company" ).autocomplete({
      source: "cha/company.php?query="+query,
      minLength: 2,
      open: function(event, ui) {
      //$("ul.ui-autocomplete.ui-menu .ui-menu-item:odd").css("background-color","#dedede");
        var url = "Can't Find Your Company? <span id='gotoOrganisation' onclick=gotoOrganisationFunction() style='text-decoration: underline; color: #0000FF; cursor: pointer;'>click here ></a>"; 
        $("ul.ui-autocomplete.ui-menu").append(url);
      },
      select: function (event, ui) {
        var company_number = (JSON.stringify(ui.item.company_number));
        var address_snippet = (JSON.stringify(ui.item.address_snippet));
        document.getElementById('company_number').value = company_number.replace(/\"/g, "");   
        address_snippet_split = address_snippet.replace(/,/g, '<br>'); 
        document.getElementById('address_snippet').innerHTML = '<strong>Address:</strong> <br>' + address_snippet_split.replace(/\"/g, "");
        document.getElementById('verifycompany').style.display='block';  
        document.getElementById('company_officers_name').innerHTML = '';
        // document.getElementById('directorYes').checked = false; 
        var company_number_for_officer = document.getElementById('company_number').value;
        $.get('cha/companyofficers.php?term=' + company_number_for_officer, function(data){
          data = JSON.parse(data);
          // console.log(data);
            for (var i = 0; i < data.length; i++) {
            var  t =  data[i]['namesss'];
            var n = t.indexOf("'");
              if( n === -1) {
                document.getElementById('company_officers_name').innerHTML += "<p style='cursor: pointer;' name='officersname' id='company_officers_name_radio' onclick=myFunction('"+i+"') /><img src='https://bookphonecall.com/wp-content/uploads/2016/12/ltd-company.png' width='15' />" + data[i]['namesss'] + "</p>";
                document.getElementById('company_officers_name').innerHTML += "<input type='hidden' value='"+ data[i]['namesss'] +"' id='company_officers_name_text_"+i+"' />";     
              } else {
                var strnameString = t.replace(/'/g, "&#8217;");
                document.getElementById('company_officers_name').innerHTML += "<p style='cursor: pointer;' name='officersname' id='company_officers_name_radio' onclick=myFunction('"+i+"') /><img src='https://bookphonecall.com/wp-content/uploads/2016/12/ltd-company.png' width='15' />" + data[i]['namesss'] + "</p>";
                document.getElementById('company_officers_name').innerHTML += "<input type='hidden' value='"+ strnameString +"' id='company_officers_name_text_"+i+"' />";         
              }
            }
        });
      },
    }); 
  }); 

  $("input[name='verifycompany']").click(function () {
    $('#director-column-q').css('display', ($(this).val() === 'verifycompany') ? 'block':'none');
  });

  $("input[name='director']").click(function () {
    $('#director_name_container').css('display', ($(this).val() === 'Yes') ? 'block':'none');
    document.getElementById('company_officers_name').style.display='block';   
    document.getElementById('name_not_listed').setAttribute("style", "display: block; text-decoration: underline; cursor: pointer;");
  });

  $("input[name='director']").click(function () {
    $('#company_officers_name').css('display', ($(this).val() === 'No') ? 'none':'block');
  });

  $("input[name='officersname']").click(function () {
    $('#company_officers_name').css('display', ($(this).val() === 'No') ? 'none':'block');
  });

}) //end of document ready

function myFunction(id)
{ 
  var dname = $("#company_officers_name_text_"+id).val(); 
  $('#director_name').val(dname);
  console.log($("#company_officers_name_text_"+id).val() );
}

function gotoOrganisationFunction()
{ 
  document.getElementById('organisation').checked = true;
  document.getElementById('director-column').style.display='none';
  document.getElementById('organisationname-column').style.display='block'; 
  document.getElementById('director-column-q').style.display='none';
  document.getElementById('director_name_container').style.display='none';
  document.getElementById('company_officers_name').style.display='none';
  document.getElementById('name_not_listed').style.display='none'; 
}
