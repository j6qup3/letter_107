$(
  function (){
  $ .ajax({
      url: 'ajax/student_data_ajax.php',
      data: { oper: 'qry_dpt' },
      type: 'POST',
      dataType: "json",
      success: function(JData) {
          row0 = "<option selected value=''>請選擇單位</option>";
          $ ('#cls_id_qry').append(row0);

          for (var i = 0; i < JData.DEPT_NO.length ; i++)
          {
              var depart = JData.DEPT_NO[i];
              var dept_name = JData.DEPT_FULL_NAME[i];
              row = "<option value=" + depart + ">" + dept_name + "</option>";

              $ ('#cls_id_qry').append(row);
          }

      },
      error: function(xhr, ajaxOptions, thrownError) {console.log(xhr.responseText);alert(xhr.responseText);}
  });


  $('#check_btn').click(
    function() {
      CRUD(0);
    }
  );
}
);

function CRUD(oper, id) {
  id = id || '';
  //alert('IN!');
  var stu_idvar,stu_namevar,stu_enamevar,cls_id,emailvar;
  stu_idvar=$ ('#stu_id').val();
  stu_namevar=$ ('#stu_name').val();
  stu_enamevar=$ ('#stu_ename').val();
  cls_id=$ ('#cls_id_qry').val();
  emailvar=$ ('#stu_email').val();
  $('#Btable').DataTable({
      "responsive": true,
      "scrollCollapse": true,
      "displayLength": 20,
      "destroy": true,
      "paginate": true,
      "lengthChange": true,
      "processing": false,
      "serverSide": false,
      "ajax": {
          url: 'ajax/student_data_ajax.php',
          type: 'POST',
          data: { oper: 0, stu_id:stu_idvar,stu_name:stu_namevar,stu_ename:stu_enamevar,cls_id: cls_id,email:emailvar},
          dataType: 'json'
      },
      "columns": [
        { "name": "id" },
        { "name": "name" },
        { "name": "ename" },
        { "name": "cls_id" },
        { "name": "email" },
      ]
  });
}
