$( // 表示網頁完成後才會載入
    function ()
    {

        $.ajax({
            url: 'ajax/letter_create_ajax.php',
            data:{  oper: 'area' },
            type: 'POST',
            dataType: "json",
            success: function(JData) {
                if (JData.error_code)
                    toastr["error"](JData.error_message);
                else
                {
                    $('#room_code').empty();
                    if(JData == 1)
                    {
                        var row = "<option value = '1' selected>進德校區</option><option value = '2'>寶山校區</option>";
                    }
                    else
                    {
                        var row = "<option value = '1'>進德校區</option><option value = '2' selected>寶山校區</option>";
                    }
                    $('#room_code').append(row);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {console.log(xhr.responseText);alert(xhr.responseText);}
        });

        var options = {
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

        $('#receive_date').datetimepicker(options);

        //bootstrapValidator
        $("#letter_new").bootstrapValidator({
            live: 'submitted',
            fields: {
                stu_name: {
                    validators: {
                        notEmpty: {
                            message: '請輸入收件人姓名'
                        },
                    }
                },
                letter_no: {
                    validators: {
                        notEmpty: {
                            message: '請輸入信件號碼'
                        },
                    }
                },
                dept_code: {
                    validators: {
                        notEmpty: {
                            message: '請輸入系所代碼'
                        },
                    }
                },
                room_code: {
                    validators: {
                        notEmpty: {
                            message: '請選擇收件校區'
                        }
                    }
                },
                receive_date: {
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

            var stu_name, letter_no, dept_name, dept_code, room_code, receive_date, comment;

            stu_name = $('#stu_name').val();
            letter_no = $('#letter_no').val();
            dept_name = $('#dept_name').val();
            dept_code = $('#dept_code').val();
            room_code = $('#room_code').val();
            receive_date = $('#receive_date').val();
            comment = $('#comment').val();

            $.ajax({
                url: 'ajax/letter_create_ajax.php',
                data:{  oper: 'create' , stu_name: stu_name, letter_no: letter_no, dept_name: dept_name, dept_code: dept_code, room_code: room_code,
                        receive_date: receive_date, comment: comment
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
                            $ ('#stu_name, #letter_no, #dept_name, #dept_code, #room_code, #comment').val("");
                            CRUD(0);
                        }
                        else
                            toastr["error"](JData);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {console.log(xhr.responseText);alert(xhr.responseText);}
            });
            e.preventDefault();
            // e.unbind();
        });

        CRUD(0);
    }
);

function CRUD (oper)
{
    if(oper == 0)
    {
        $('#Btable').DataTable({
            "scrollY": "500px",
            "scrollCollapse": true,
            "displayLength": 10,
            "destroy": true,
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"}
            ],
            "ajax": {
                url: 'ajax/letter_create_ajax.php',
                data: { oper: "query" },
                type: 'POST',
                dataType: 'json'
            },
            "columns": [
                { "name": "STU_NAME" },
                { "name": "LETTER_NO" },
                { "name": "RECEIVE_DATE" },
                { "name": "TAKE_DATE" },
                { "name": "DEPT_CODE" },
                { "name": "ROOM_CODE" },
                { "name": "AGENT" },
                { "name": "MARK" },
                { "name": "BUTTON1" },
                { "name": "BUTTON2" }
            ],
            "aaSorting": [
                [ 2, "desc" ]
            ]

        });
    }

}

function toDate(dateStr) {
    const [year, month, day] = dateStr.split("/")
    return new Date(year, month - 1, day)
}

function search(op)
{
    if(op == 1 )
    {
        if ( $('#stu_name').val() != '')
        {
            var stu_name = $('#stu_name').val();

            $.ajax({
                url: 'ajax/letter_create_ajax.php',
                data:{  oper: 'dept_fill' , stu_name: stu_name },
                type: 'POST',
                dataType: "json",
                success: function(JData) {
                    if (JData.error_code)
                        toastr["error"](JData.error_message);
                    else
                    {

                        $ ('#dept_code, #dept_name').val("");
                        if(JData["CLS_ID"][0] !== null && JData["DEPT_FULL_NAME"][0] !== null)
                        {
                            $ ('#dept_code').val(JData["CLS_ID"][0]);
                            $ ('#dept_name').val(JData["DEPT_FULL_NAME"][0]);
                            $('#letter_no').focus();
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {console.log(xhr.responseText);alert(xhr.responseText);}
            });
        }
        else
        {
            $ ('#dept_code').val("");
            $ ('#dept_name').val("");
        }

    }
    else
    {
        if ( $('#edit_stu_name').val() != '')
        {
            var stu_name = $('#edit_stu_name').val();

            $.ajax({
                url: 'ajax/letter_create_ajax.php',
                data:{  oper: 'dept_fill' , stu_name: stu_name },
                type: 'POST',
                dataType: "json",
                success: function(JData) {
                    if (JData.error_code)
                        toastr["error"](JData.error_message);
                    else
                    {

                        $ ('#edit_dept_code, #edit_dept_name').val("");
                        if(JData["CLS_ID"][0] !== null && JData["DEPT_FULL_NAME"][0] !== null)
                        {
                            $ ('#edit_dept_code').val(JData["CLS_ID"][0]);
                            $ ('#edit_dept_name').val(JData["DEPT_FULL_NAME"][0]);
                            $('#edit_letter_no').focus();
                        }

                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {console.log(xhr.responseText);alert(xhr.responseText);}
            });
        }
        else
        {
            $ ('#edit_dept_code').val("");
            $ ('#edit_dept_name').val("");
        }
    }

}

function Edit(NAME, LETTER_NO, RECEIVE_DATE, DEPT_CODE, ROOM_CODE, AGENT, MARK)
{
    var name = NAME, letter_no = LETTER_NO.toString(), receive_date = RECEIVE_DATE, dept_code = DEPT_CODE, room_code = ROOM_CODE, agent = AGENT, mark = MARK;

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

    var room_code = ROOM_CODE;
    $('#edit_room_code').empty();
    if(room_code == 1)
    {
        var row = "<option value = '1' selected>進德校區</option><option value = '2'>寶山校區</option>";
    }
    else
    {
        var row = "<option value = '1'>進德校區</option><option value = '2' selected>寶山校區</option>";
    }
    $('#edit_room_code').append(row);

    var edit_reyear_origin = (parseInt(receive_date.toString().substring(0,3))+1911).toString();
    var edit_remonth_origin = receive_date.toString().substring(3,5);
    var edit_reday_origin = receive_date.toString().substring(5,7);
    var _eco = edit_reyear_origin + "/" + edit_remonth_origin + "/" + edit_reday_origin;
    var eco = toDate(_eco);

    $('#edit_stu_name').val(name);
    $('#edit_letter_no').val(letter_no);
    $('#edit_dept_code').val(dept_code);
    $('#edit_receive_date').data("DateTimePicker").date(eco);
    $('#edit_comment').val(mark);

    var origin_stu_name, origin_letter_no, origin_dept_code, origin_room_code, origin_receive_date, origin_comment;
    origin_stu_name = name;
    origin_letter_no = letter_no;
    origin_dept_code = dept_code;
    origin_room_code = room_code;
    origin_receive_date = receive_date;
    origin_comment = mark;

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
            edit_dept_code: {
                validators: {
                    notEmpty: {
                        message: '請輸入系所代碼'
                    },
                }
            },
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

        var edit_stu_name, edit_letter_no, edit_dept_name, edit_dept_code, edit_room_code, edit_receive_date, edit_comment;

        edit_stu_name = $('#edit_stu_name').val();
        edit_letter_no = $('#edit_letter_no').val();
        edit_dept_name = $('#edit_dept_name').val();
        edit_dept_code = $('#edit_dept_code').val();
        edit_room_code = $('#edit_room_code').val();
        edit_receive_date = $('#edit_receive_date').val();
        edit_comment = $('#edit_comment').val();


        $.ajax({
            url: 'ajax/letter_create_ajax.php',
            data:{  oper: 'update' , stu_name: edit_stu_name, letter_no: edit_letter_no, dept_name: edit_dept_name, dept_code: edit_dept_code, room_code: edit_room_code,
                    receive_date: edit_receive_date, comment: edit_comment,
                    origin_stu_name: origin_stu_name, origin_letter_no: origin_letter_no, origin_dept_code: origin_dept_code, origin_room_code: origin_room_code,
                    origin_receive_date: origin_receive_date, origin_comment: origin_comment
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
                        CRUD(0);
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

function Delete(NAME, LETTER_NO, RECEIVE_DATE, DEPT_CODE, ROOM_CODE, AGENT, MARK)
{
    if(confirm("確定要刪除?"))
        $.ajax({
            url: 'ajax/letter_create_ajax.php',
            data:{  oper: 'delete',stu_name: NAME, letter_no: LETTER_NO, dept_code: DEPT_CODE, room_code: ROOM_CODE,
                        receive_date: RECEIVE_DATE, agent: AGENT, comment: MARK},
            type: 'POST',
            dataType: "json",
            success: function(JData) {
                if (JData.error_code)
                    toastr["error"](JData.error_message);
                else
                {
                    toastr["success"](JData);
                    CRUD(0);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {console.log(xhr.responseText);alert(xhr.responseText);}
        });
}

