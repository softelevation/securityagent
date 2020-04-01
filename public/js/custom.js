$(document).ready(function() {
  // Set Global Variables
  var locale = 'en-US';
  var timezone = 'Europe/Paris';
  function get_current_date_time(){
    return new Date().toLocaleString(locale, {timeZone: timezone});
  }


  // Multi select
  $(document).find('.multi_select').select2({
    placeholder: "Select Options",
  });
  // Display note of 8 hours
  $('.mission_hours').on('change',function(){
    let selected = $(this).children(':selected').val();
    if(selected==0){
      $('.mission_hours_note').removeClass('d-none');
    }else{
      $('.mission_hours_note').addClass('d-none');
    }
  });
  
  $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
    if (!$(this).next().hasClass('show')) {
      $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
    }
    var $subMenu = $(this).next('.dropdown-menu');
    $subMenu.toggleClass('show');
    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
      $('.dropdown-submenu .show').removeClass('show');
    });
    return false;
  });
  // Availability toggle 
  $(document).on('click','#availability_check_btn',function(){
    let checkStatus = 0;
    let checked = $(this).is(':checked');
    if(checked){
      checkStatus=1;   
    }
    $(document).find('#availability_status').val(checkStatus);
    $('#agent_availabity_form').trigger('submit');
  });
  
  // Tooltips
  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="popover"]').popover();
  
  $(function() {
    // Datepicker
    $( ".datepicker" ).datepicker();
    // Datetimepicker
    jQuery('.datetimepicker').datetimepicker({
      format:'m/d/Y H:i'
    });
    jQuery('.timepicker').datetimepicker({
      datepicker:false,
      format:'H:i',
      // minTime:''11:00''
    });
  });

  $(document).on('click','.mission_start_radio', function(){
      if($(this).val()==0){
          $(document).find('#misionStartEndDiv').removeClass('d-none');
      }else{
          $('.datetimepicker').val('');
          $(document).find('#misionStartEndDiv').addClass('d-none');
      }
  });
  // Show message
  $(document).on('click','.alert-msg',function(){
    let message = $(this).attr('data-msg');
    let msgType = $(this).attr('data-msg-type');
    if(msgType=='success'){ toastr.success(message); }
    if(msgType=='error'){ toastr.error(message); }
  });

  $(document).on('click','.notification-item',function(){
    let id = $(this).attr('data-notification-id');
    let notificationUrl = $(this).attr('data-notification-url');
    $('#notification_id').val(id);
    $('#notification_url').val(notificationUrl);
    $('#customer_notification_form').submit();
  });

  // Agent Schedule
  $(document).on('click','.day_off',function(){
    $(this).addClass('d-none');
    $(this).closest('tr').find('input.timepicker').prop("disabled",true);
    $(this).closest('tr').find('.day_on').removeClass('d-none');
    $(this).closest('tr').find('.day_off_field').val(1);
  });
  $(document).on('click','.day_on',function(){
    $(this).addClass('d-none');
    $(this).closest('tr').find('input.timepicker').prop("disabled",false);
    $(this).closest('tr').find('.day_off').removeClass('d-none');
    $(this).closest('tr').find('.day_off_field').val(0);
  });
  
  // Book Agent Later Missions
  $(document).on('click','.book_agent_later',function(){
    let agent_id = $(this).attr('id');
    $(document).find('#agent_book_later_mission').val(agent_id);
    $(document).find('#general_form').submit();
  });

  //Payment Approval Action
  $(document).on('click','.pa_act_btn',function(){
    let record_id = $(this).attr('data-record-id');
    let type = $(this).attr('data-type');
    $(document).find('#p_a_r_id').val(record_id);
    $(document).find('#p_a_type').val(type);
    $(document).find('#general_form').submit();
  }); 

  // function to create a countdown timer
  function showCountDownTimer(elementId,expire_time,mission_id){
    // Set the date we're counting down to
    var countDownDate = new Date(expire_time).getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {
      // Get today's date and time
      var cdt = get_current_date_time();
      var now = new Date(cdt).getTime();
      // Find the distance between now and the count down date
      var distance = countDownDate - now;
      // Time calculations for days, hours, minutes and seconds
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      // Output the result in an element with id="demo"
      document.getElementById(elementId).innerHTML = minutes + " Min " + seconds + " Sec ";
      // If the count down is over, write some text 
      if (distance < 0) {
        clearInterval(x);
        document.getElementById(elementId).innerHTML = "EXPIRED";
        $(document).find('#expired_mission_id').val(mission_id);
        $(document).find('#general_form').submit();
      }
    }, 1000);
  }

  // fetch all rows and show timeout
  $(document).find('.timeout_p').each(function(key, value){
    let timerId = $(this).attr('id');
    let timeout = $(this).attr('data-timeout');
    let mission_id = $(this).attr('data-record-id');
    showCountDownTimer(timerId,timeout,mission_id);
  });

  // cancel mission
  $(document).on('click','.cancel_mission_cls',function(e){
    e.preventDefault();
    let url = $(this).attr('href');
    ajaxGetRequest(url);
  });

  // delete mission
  $(document).on('click','.delete_mission_cls',function(e){
    e.preventDefault();
    let url = $(this).attr('href');
    ajaxGetRequest(url);
  });

  // function to hit get request
  function ajaxGetRequest(url){
    $.ajax({
      type: 'GET',
      url: url,
      dataType: 'json',
      beforeSend  : function () {
          $("#preloader").show();
      },
      complete: function () {
          $("#preloader").hide();
      },
      success: function(response) {
        $.toast().reset('all');
        var delayTime=0;
        if(response.delayTime){
          delayTime = response.delayTime;
        }
        if (response.success){
          toastr.success(response.message,delayTime);
        }else{
          toastr.error(response.message,delayTime);
        }
        if(response.url){
          if(response.delayTime){
            setTimeout(function() { window.location.href=response.url;}, response.delayTime);
          }else{
            window.location.href=response.url;
          }
        }
      }
    });
  }

  //refund request
  $(document).on('click','.refund_cls',function(){
    let record_id = $(this).attr('id');
    let status = $(this).attr('data-status');
    $(document).find('#record_id').val(record_id);
    $(document).find('#refund_status').val(status);
    $(document).find('#general_form').submit();
  }); 

  //refund request
  $(document).on('click','.refund_now_btn',function(){
    let charge_id = $(this).attr('id');
    $(document).find('#charge_id').val(charge_id);
    $(document).find('#general_form').submit();
  });

  $( ".agent_schedule" ).datepicker({
    minDate:0,
    onSelect:function(dateText,inst){
      var show_date = [];
      let new_date = dateText.split("/");
      $(document).find('.modal-title span').html(dateText);
      $(document).find('#schedule_date').val(dateText);
      let current_date = new_date[2]+'-'+new_date[0]+'-'+new_date[1];
      show_date = schedule.filter(function (schedule) { return schedule.schedule_date == current_date });
      if(show_date.length!=0){
        $(document).find('#available_from').val(show_date[0].available_from);
        $(document).find('#available_to').val(show_date[0].available_to);
      }else{
        $(document).find('#available_from').val('');
        $(document).find('#available_to').val('');
      }
      $('#schedule_model').modal('show');
    },
    beforeShowDay:function(date) {
        var set_date = [];
        var timing = '';
        var m = date.getMonth()+1, d = date.getDate(), y = date.getFullYear();
        if(m < 10){ m = '0'+m; }
        if(d < 10){ d = '0'+d; }
        let current_date = y+'-'+m+'-'+d;
        set_date = schedule.filter(function (schedule) { return schedule.schedule_date == current_date });
        if(set_date.length!=0){
          let from = set_date[0].available_from;
          from = from.split(":");
          let to = set_date[0].available_to
          to = to.split(":");
          timing = from[0]+':'+from[1]+' - '+to[0]+':'+to[1];
          addCustomInformation();
          return[true,'schedule_set_on',timing]
        }
        return [true];
    }
  });
  function addCustomInformation() {
    setTimeout(function() {
      $(".ui-datepicker-calendar td").attr("data-toggle","tooltip");
      $('[data-toggle="tooltip"]').tooltip({
        placement: 'top'
      });
    }, 0);
  }

  // remove mission request
  $(document).on('click','.remove_mission_request',function(e){
    e.preventDefault();
    let url = $(this).attr('href');
    ajaxGetRequest(url);
  });


});