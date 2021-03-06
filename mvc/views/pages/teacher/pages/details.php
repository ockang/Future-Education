<div class="row well" style="border:0px solid">
  <span style="font-size:16px;"><i class="fa fa-files-o"></i> &nbsp;&nbsp;Details</span>
  <a class="pull-right" href="javascript:window.history.go(-1);"><span class="pull-right"><i class="fa fa-long-arrow-left" title="Back"></i> Back</span></a>
</div>

<div class="row alert alert-info" style="border:0px solid">
  <?php if (isset($details)) {?>
  <p><b>Semester Code :</b> <span id="semester_code"><?=$details->semester_code;?></span></p>
  <p><b>Batch :</b> <span id="std_batch"><?=$details->std_batch;?></span></p>
  <p><b>Section :</b> <span id="std_section"><?=$details->std_section;?></span></p>
  <p><b>Subject code :</b> <span id="sub_code"><?=$details->sub_code;?></span></p>
  <p class="capitalize"><b>Subject Name :</b> <?=$details->sub_name;?></p>
  <?php } ?>
</div>

<div class="row well" style="border:0px solid">
  <p class="well" style="padding:10px;">
    <span> <i class="fa fa-users"></i>&nbsp; Assign Student List</span>
  </p>

  <table id="myTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
   <thead>
    <tr>
      <th>ID</th>
      <th>Student ID</th>
      <th>Student Name</th>
      <th>Attendance</th>
      <th>Class Test</th>
      <th>Mid Tram</th>
      <th>Final</th>
      <th>Total</th>
      <th>GPA</th>
      <th>Grade</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($get_list as $row) {
      if(($row->action)==1){?>
      <tr id='rows' class='rows'>
        <td id="get_id"><?=$row->id;?></td>
        <td id="get_std_id"><?=$row->std_id;?></td>
        <td class="capitalize" id="std_name"><?=$row->std_name;?></td>
        <td><input type="text" name="attendance"   id="attendance"   class="custom-form-control" value="<?=$row->attendance;?>" disabled="TRUE"/></td>
        <td><input type="text" name="classTest"    id="classTest"    class="custom-form-control" value="<?=$row->class_test;?>" disabled="TRUE"/></td>
        <td><input type="text" name="mid_exam"     id="mid_exam"     class="custom-form-control" value="<?=$row->mid_exam;?>" disabled="TRUE"/></td>
        <td><input type="text" name="final_exam"   id="final_exam"   class="custom-form-control" value="<?=$row->final_exam;?>" disabled="TRUE"/></td>
        <td><input type="text" name="total_number" id="total_number" class="custom-form-control" value="<?=$row->total_number;?>" disabled="TRUE"/></td>
        <td><input type="text" name="gpa_point"    id="gpa_point"    class="custom-form-control" value="<?=$row->gpa_point;?>"  disabled="TRUE"/></td>
        <td><input type="text" name="grade_point"  id="grade_point"  class="custom-form-control capitalize" value="<?=$row->grade_point;?>"  disabled="TRUE"/></td>
      </tr>
      <?php }else {?>
      <tr id='rows' class='rows'>
        <td id="get_id"><?=$row->id;?></td>
        <td id="get_std_id"><?=$row->std_id;?></td>
        <td class="capitalize" id="std_name"><?=$row->std_name;?></td>
        <td><input type="text" name="attendance"   id="attendance"   class="custom-form-control" value="<?=$row->attendance;?>"/></td>
        <td><input type="text" name="classTest"    id="classTest"    class="custom-form-control" value="<?=$row->class_test;?>"/></td>
        <td><input type="text" name="mid_exam"     id="mid_exam"     class="custom-form-control" value="<?=$row->mid_exam;?>"/></td>
        <td><input type="text" name="final_exam"   id="final_exam"   class="custom-form-control" value="<?=$row->final_exam;?>"/></td>
        <td><input type="text" name="total_number" id="total_number" class="custom-form-control" value="<?=$row->total_number;?>" disabled="TRUE"/></td>
        <td><input type="text" name="gpa_point"    id="gpa_point"    class="custom-form-control" value="<?=$row->gpa_point;?>"  disabled="TRUE"/></td>
        <td><input type="text" name="grade_point"  id="grade_point"  class="custom-form-control capitalize" value="<?=$row->grade_point;?>"  disabled="TRUE"/></td>
      </tr>
      <?php }} ?>
    </tbody>

  </table>
  <?php if(isset($chack_button)) {
    if (($chack_button->action) != 1) { ?>
    <input class="btn pull-right" type="button" name="result_submit_button" id="result_submit_button" value="Submit" />
    <?php }} ?>

  </div>

  <script type="text/javascript">

  $(document).on('blur','#attendance,#classTest,#mid_exam,#final_exam', function(){
   var $row = $(this).closest("#rows");
   var attendance = parseInt($row.find('#attendance').val()) || 0;
   var classTest = parseInt($row.find('#classTest').val()) || 0;
   var mid_exam = parseInt($row.find('#mid_exam').val()) || 0;
   var final_exam = parseInt($row.find('#final_exam').val()) || 0;
   var sum = $row.find('#total_number').val(attendance+classTest+mid_exam+final_exam);
   var total = (attendance+classTest+mid_exam+final_exam);

   $.ajax({
    type: 'POST',
    dataType: "json",
    url: "<?=base_url('teachers_overview/gradeCallMethod')?>",
    data: "total=" + total,
    dataType: "html",
    success: function(data) {
      var response = jQuery.parseJSON(data);
          // alert(response.point);
          var gpa_point = parseInt($row.find('#gpa_point').val(response.point)) || 0;
          var grade_point = parseInt($row.find('#grade_point').val(response.grade)) || 0;
        }
      });
 });


  $('#result_submit_button').click(function() {

    var semester_code = $('#semester_code').text();
    // var std_batch     = $('#std_batch').text();
    var sub_code      = $('#sub_code').text();

    var n = $("table").find("tr").length;

    for (var i = 1; i < n; i++) {

      var get_id       = $("table").find("tr").eq(i).find("td").eq(0).text();
      var get_std_id   = $("table").find("tr").eq(i).find("td").eq(1).text();
      var std_name     = $("table").find("tr").eq(i).find("td").eq(2).text();
      var attendance   = $("table").find("tr").eq(i).find("td").eq(3).find("input").val();
      var classTest    = $("table").find("tr").eq(i).find("td").eq(4).find("input").val();
      var mid_exam     = $("table").find("tr").eq(i).find("td").eq(5).find("input").val();
      var final_exam   = $("table").find("tr").eq(i).find("td").eq(6).find("input").val();
      var total_number = $("table").find("tr").eq(i).find("td").eq(7).find("input").val();
      var gpa_point    = $("table").find("tr").eq(i).find("td").eq(8).find("input").val();
      var grade_point  = $("table").find("tr").eq(i).find("td").eq(9).find("input").val();

      $.ajax({
        type: 'POST',
        url: "<?=base_url('teachers_overview/updateResult')?>",
        data: {
          'semester_code' : semester_code,
          'sub_code'      : sub_code,
          'get_id'        : get_id,
          'get_std_id'    : get_std_id,
          'std_name'      : std_name,
          'attendance'    : attendance,
          'classTest'     : classTest,
          'mid_exam'      : mid_exam,
          'final_exam'    : final_exam,
          'total_number'  : total_number,
          'gpa_point'     : gpa_point,
          'grade_point'   : grade_point,
        },
        dataType: "html",
        success: function (data) {
          toastr.success('Marks submitted Successfully !', "Success");
          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
              // window.location = "overview";
            },
            error: function (err) {
              alert(err);
            }
          })
}
})


</script>
