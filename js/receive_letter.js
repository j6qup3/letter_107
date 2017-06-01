$(function() {
    initTable();
    bootbox.setDefaults({
        locale: "zh_TW",
        backdrop: true
    });

    String.prototype.lpad = function(padString, length) {
        var str = this;
        while (str.length < length)
            str = padString + str;
        return str;
    }
});

// use global variable for datatable
var oTable;

var rollback_history = [];

function initTable() {
    oTable =
        $('#oTable').DataTable({
            "dom": 'Bfrtip',
            "rowId": 'DT_ROWID',
            "responsive": true,
            "processing": true,
            "language": {
                "processing": '<i class="fa fa-refresh fa-spin fa-lg fa-fw"> </i> 讀取中...'
            },
            "ajax": {
                url: 'ajax/receive_letter_ajax.php',
                data: { oper: 'qrydata' },
                type: 'POST',
                dataType: 'json'
            },
            //"deferRender": true, 
            "columns": [
                { "data": "NAME" },
                { "data": "LETTER_NO" },
                { "data": "RECEIVE_DATE" },
                { "data": "TAKE_DATE" },
                { "data": "AGENT" },
                { "data": "MARK" },
                { "data": "ROOM_CODE" }
            ],
            "columnDefs": [
                /*{
                    "targets": 7,
                    "orderable": false,
                    "data": "LETTER_NO",
                    "render": function(data) {
                        // 刪除
                        return "<button type='button' class='btn btn-primary btn-simple' onclick='delData(" + data + ")'><i class='fa fa-times' aria-hidden='true'></i></button>";
                    }
                },
                { "className": "dt-center in-take_date", "targets": 3 },
                { "className": "dt-center in-agent", "targets": 4 },*/
                { "className": "dt-center", "targets": "_all" }
            ],
            "buttons": [{
                text: "復原操作",
                action: function(e, dt, node, config) {
                    var rowdata = rollback_history.pop();
                    var rowid = '#' + rowdata.DT_ROWID;

                    $.post(
                        'ajax/receive_letter_ajax.php', { oper: 'update', take_date: rowdata.TAKE_DATE, agent: rowdata.AGENT, name: rowdata.NAME, letter_no: rowdata.LETTER_NO, receive_date: rowdata.RECEIVE_DATE },
                        function(response) {
                            if (response !== '') {
                                toastr["error"]("復原失敗");
                                rollback_history.push();
                                return;
                            }

                            toastr["success"]("復原成功");

                            oTable.row(rowid).data(rowdata);
                            $(rowid).removeClass('selected');

                            if (!rollback_history.length)
                                oTable.button(0).disable();
                        }
                    );


                },
                enabled: false
            }]
        });
    $('#oTable').on('click', 'tbody tr', function() {
        var rowdata = oTable.row(this).data();
        var rowid = '#' + rowdata.DT_ROWID;

        var old_take_date = rowdata.TAKE_DATE;
        var old_agent = rowdata.AGENT;

        var modalcontent =
            '<p>姓名：' + rowdata.NAME + '</p>' +
            '<p>信件號碼：' + rowdata.LETTER_NO + '</p>' +
            '<p>收件日期：' + rowdata.RECEIVE_DATE + '</p>' +
            '<hr>' +
            '<div class="form-group"><label for="bt-in-take_date">領取日期:</label><input type="text" class="form-control" id="bt-in-take_date"></div><div class="form-group"><label for="bt-in-agent">代領人:</label><input type="text" class="form-control" id="bt-in-agent"></div>';

        var modal = bootbox.confirm({
            title: "修改領取日期與代領人",
            message: modalcontent,
            callback: function(isOK) {
                if (!isOK)
                    return;

                // set new value
                rowdata.TAKE_DATE = $('#bt-in-take_date').val();
                rowdata.AGENT = $('#bt-in-agent').val();

                $.post(
                    'ajax/receive_letter_ajax.php', { oper: 'update', take_date: rowdata.TAKE_DATE, agent: rowdata.AGENT, name: rowdata.NAME, letter_no: rowdata.LETTER_NO, receive_date: rowdata.RECEIVE_DATE },
                    function(response) {
                        if (response !== '') {
                            toastr["error"]("修改失敗");
                            return;
                        }

                        toastr["success"]("修改成功");

                        oTable.row(rowid).data(rowdata);
                        $(rowid).addClass('selected');

                        // used for recovery
                        rowdata.TAKE_DATE = old_take_date;
                        rowdata.AGENT = old_agent;
                        rollback_history.push(rowdata);

                        oTable.button(0).enable(1);
                    }
                );
            }
        });

        modal.init(function() {
            if (rowdata.TAKE_DATE != '^^^^^^')
                $('#bt-in-take_date').val(rowdata.TAKE_DATE);
            else {
                var fulldate = new Date();
                var thisyear = (fulldate.getUTCFullYear() - 1911).toString();
                var thismonth = (fulldate.getMonth() + 1).toString().lpad("0", 2);
                var thisday = fulldate.getDate().toString().lpad("0", 2);

                $('#bt-in-take_date').val(thisyear.concat(thismonth, thisday));

            }

            $('#bt-in-agent').val(rowdata.AGENT);
        });

    });
}