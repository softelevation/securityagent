$(document).ready(function() {
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
});