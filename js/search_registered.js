$(function() {
    registered_table =
        $('#Btable').DataTable({
            "responsive": true,
            "scrollCollapse": true,
            "displayLength": 25,
            "paginate": true,
            "lengthChange": true,
            "processing": false,
            "serverSide": false,
            "ajax": {
                url: 'ajax/search_registered_ajax.php',
                type: 'POST',
                data: function (d) {
                    d.oper = "registered",
                    d.take_or_not = $('#take-or-not').val()
                },
                dataType: 'json'
            },
            "columns": [
              { "name": "name" },
              { "name": "letter_no" },
              { "name": "receive_date" },
              { "name": "room_code" },
              { "name": "dept_code" },
              { "name": "BUTTON" },
            ]
        });

    $('#take-or-not').change( // 選擇系所後
        function(e) {
            if ($(':selected', this).val() !== '') {
                registered_table.ajax.reload();
            }
        }
    );

    // $(".ttt").click(function(e){
    //        var id = registered_table.row( this ).id();
    //        alert(id);
    // })
    $.ajax({
        url: 'ajax/search_registered_ajax.php',
        data: {
            oper: "codeToName",
        },
        type: 'POST',
        dataType: "json",
        success: function(JData) {
            if (JData.error_code)
                //toastr["error"](JData.error_message);
                message(JData.error_message, "danger", 5000);
            else {
                $('#edit_dept_code').empty();
                for (var dept_code in JData) {
                    var str_option = "<option value='" + dept_code + "'> " + JData[dept_code] + "</option>"
                    $('#edit_dept_code').append(str_option);
                }
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    });
});

function toDate(dateStr) {
    const [year, month, day] = dateStr.split("/")
    return new Date(year, month - 1, day)
}

function Edit(name, letter_no, receive_date, room_code, dept_code)
{
    var name = name, letter_no = letter_no.toString(), receive_date = receive_date, dept_code = dept_code, room_code = room_code;

    var options2 = {
          ignoreReadonly: true,
          defaultDate: moment().add(0, 'd').toDate(),
          maxDate: moment().add(0, 'd').toDate(),
          format: 'YYYY/MM/DD',
          tooltips: {
              clear: "清除所選",
              close: "關閉日曆",
              decrementHour: "減一小時",
              decrementMinute: "Decrement Minute",
              decrementSecond: "Decrement Second",
              incrementHour: "加一小時",
              incrementMinute: "Increment Minute",
              incrementSecond: "Increment Second",
              nextCentury: "下個世紀",
              nextDecade: "後十年",
              nextMonth: "下個月",
              nextYear: "下一年",
              pickHour: "Pick Hour",
              pickMinute: "Pick Minute",
              pickSecond: "Pick Second",
              prevCentury: "上個世紀",
              prevDecade: "前十年",
              prevMonth: "上個月",
              prevYear: "前一年",
              selectDecade: "選擇哪十年",
              selectMonth: "選擇月份",
              selectTime: "選擇時間",
              selectYear: "選擇年份",
              today: "今日日期",
          },
          locale: 'zh-tw',
    }

    $('#edit_receive_date').datetimepicker(options2);
    if(room_code == 1){
        $('#edit_room_code').val("1");
    }
    else {
        $('#edit_room_code').val("2");
    }

    var edit_reyear_origin = (parseInt(receive_date.toString().substring(0,3)) + 1911).toString();
    var edit_remonth_origin = receive_date.toString().substring(3, 5);
    var edit_reday_origin = receive_date.toString().substring(5, 7);
    var _eco = edit_reyear_origin + "/" + edit_remonth_origin + "/" + edit_reday_origin;
    var eco = toDate(_eco);

    $('#edit_stu_name').val(name);
    $('#edit_letter_no').val(letter_no);
    $('#edit_dept_code').val(dept_code);
    $('#edit_receive_date').data("DateTimePicker").date(eco);

    // 若系所不在提供的選項內
    if ($('#edit_dept_code').val() == null){
      $('#edit_dept_code').append("<option value='" + dept_code + "'> " + dept_code + "</option>");
      $('#edit_dept_code').val(dept_code);
    }

    var origin_stu_name, origin_letter_no, origin_dept_code, origin_room_code, origin_receive_date;
    origin_stu_name = name;
    origin_letter_no = letter_no;
    origin_dept_code = dept_code;
    origin_room_code = room_code;
    origin_receive_date = receive_date;

    $("#myModal").modal("show");

    $("#letter_edit").bootstrapValidator({
        live: 'submitted',
        fields: {
            edit_stu_name: {
                validators: {
                    notEmpty: {
                        message: '請輸入收件人姓名'
                    },
                }
            },
            edit_letter_no: {
                validators: {
                    notEmpty: {
                        message: '請輸入信件號碼'
                    },
                }
            },
            // edit_dept_code: {
            //     validators: {
            //         notEmpty: {
            //             message: '請選擇系所'
            //         },
            //     }
            // },
            edit_room_code: {
                validators: {
                    notEmpty: {
                        message: '請選擇收件校區'
                    }
                }
            },
            edit_receive_date: {
                validators: {
                    notEmpty: {
                        message: '收件日期不可空白'
                    },
                    date: {
                        format: 'YYYY/MM/DD',
                        message: '不正確的日期格式！'
                    }
                }
            }
        }
    })
    // 不論表單驗證正確與否時，皆可按下表單按鈕
    // Triggered when any field is invalid
    .on('error.field.bv', function(e, data) {
        data.bv.disableSubmitButtons(false);
    })
    // Triggered when any field is valid
    .on('success.field.bv', function(e, data) {
        data.bv.disableSubmitButtons(false);
    })
    //submit by ajax----------------------------------
    .on( 'success.form.bv' , function(e) {
        var edit_stu_name, edit_letter_no, edit_dept_name, edit_dept_code, edit_room_code, edit_receive_date;

        edit_stu_name = $('#edit_stu_name').val();
        edit_letter_no = $('#edit_letter_no').val();
        edit_dept_code = $('#edit_dept_code').val();
        edit_dept_name = $("#edit_dept_name option[value='" + edit_dept_code + "']").val();
        edit_room_code = $('#edit_room_code').val();
        edit_receive_date = $('#edit_receive_date').val();


        $.ajax({
            url: 'ajax/search_registered_ajax.php',
            data:{  oper: 'update', stu_name: edit_stu_name, letter_no: edit_letter_no,
                    dept_code: edit_dept_code, room_code: edit_room_code,
                    receive_date: edit_receive_date,
                    origin_stu_name: origin_stu_name, origin_letter_no: origin_letter_no, origin_dept_code: origin_dept_code, origin_room_code: origin_room_code,
                    origin_receive_date: origin_receive_date
                },
            type: 'POST',
            dataType: "json",
            success: function(JData) {
                if (JData.error_code)
                    toastr["error"](JData.error_message);
                else
                {
                    if(JData.length == 4)
                    {
                        toastr["success"](JData);
                        registered_table.ajax.reload();
                        $("#myModal").modal("hide");
                    }
                    else
                        toastr["error"](JData);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {console.log(xhr.responseText);alert(xhr.responseText);}
        });
        e.preventDefault();
    });

}

function Delete(name, letter_no, receive_date, room_code, dept_code)
{
    if(confirm("確定要刪除?"))
        $.ajax({
            url: 'ajax/search_registered_ajax.php',
            data:{  oper: 'delete',stu_name: name, letter_no: letter_no,
                        dept_code: dept_code, room_code: room_code,
                        receive_date: receive_date},
            type: 'POST',
            dataType: "json",
            success: function(JData) {
                if (JData.error_code)
                    toastr["error"](JData.error_message);
                else
                {
                    toastr["success"](JData);
                    registered_table.ajax.reload();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {console.log(xhr.responseText);alert(xhr.responseText);}
        });
}
