$( // 表示網頁完成後才會載入
    function ()
    {

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
                // dept_name: {
                //     validators: {
                //         notEmpty: {
                //             message: '請輸入系所名稱'
                //         },
                //     }
                // },
                room_code: {
                    validators: {
                        notEmpty: {
                            message: '請輸入收件校區'
                        },
                        between: {
                            min: 1,
                            max: 2,
                            message: '請輸入1(進德校區)或2(寶山校區)'
                        },
                        integer: {
                            message: '請輸入1(進德校區)或2(寶山校區)'
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
                { "name": "MARK" }
            ],

        });
    }

}

function search()
{
    // $('#stu_name').change(
    // function(e){
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
                            // alert(JData);
                            // alert(JData["CLS_ID"].length);
                            // alert(JData["DEPT_FULL_NAME"].length);
                            $ ('#dept_code, #dept_name').val("");
                            if(JData["CLS_ID"][0] !== null && JData["DEPT_FULL_NAME"][0] !== null)
                            {
                                $ ('#dept_code').val(JData["CLS_ID"][0]);
                                $ ('#dept_name').val(JData["DEPT_FULL_NAME"][0]);
                            }
                            // else
                            //     toastr["error"](JData);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {console.log(xhr.responseText);alert(xhr.responseText);}
                });
            }

        // }
    // );
}