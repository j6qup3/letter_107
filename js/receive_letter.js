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
            dom: 'Bfrtip',
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
                },*/
                { "className": "dt-center in-take_date", "targets": 3 },
                { "className": "dt-center in-agent", "targets": 4 },
                { "className": "dt-center", "targets": "_all" }
            ],
            "buttons": [{
                text: "復原操作",
                action: function(e, dt, node, config) {
                    $.post(
                        'ajax/receive_letter_ajax.php', rollback_history.pop(),
                        function(response) {
                            if (response !== '') {
                                toastr["error"]("復原失敗");
                                return;
                            }

                            toastr["success"]("復原成功");

                            oTable.ajax.reload();

                            oTable.button(0).disable();
                        }
                    );


                },
                enabled: false
            }]
        });
    $('#oTable').on('click', 'tbody tr', function() {
        var rows = $(this);

        var take_date = rows.children('td.in-take_date');
        var agent = rows.children('td.in-agent');

        var row = rows.children().first();
        var txt_name = row.text();

        row = row.next();
        var txt_letter_no = row.text();

        row = row.next();
        var txt_receive_date = row.text();

        var modal = bootbox.confirm({
            title: "修改領取日期與代領人",
            message: '<div class="form-group"><label for="bt-in-take_date">領取日期:</label><input type="text" class="form-control" id="bt-in-take_date"></div><div class="form-group"><label for="bt-in-agent">代領人:</label><input type="text" class="form-control" id="bt-in-agent"></div>',
            callback: function(isOK) {
                if (!isOK ||
                    (
                        ($('#bt-in-take_date').val() == take_date.text()) &&
                        ($('#bt-in-agent').val() == agent.text())
                    )
                )
                    return;

                var new_take_date = $('#bt-in-take_date').val();
                var new_agent = $('#bt-in-agent').val();

                var data = { oper: 'update', take_date: new_take_date, agent: new_agent, name: txt_name, letter_no: txt_letter_no, receive_date: txt_receive_date };

                $.post(
                    'ajax/receive_letter_ajax.php', data,
                    function(response) {
                        if (response !== '') {
                            toastr["error"]("修改失敗");
                            return;
                        }

                        toastr["success"]("修改成功");

                        data.take_date = take_date.text();
                        data.agent = agent.text();
                        rollback_history.push(data);

                        take_date.text(new_take_date);
                        agent.text(new_agent);

                        oTable.button(0).enable(1);
                    }
                );
            }
        });
        modal.init(function() {
            if (take_date.text() != '^^^^^^')
                $('#bt-in-take_date').val(take_date.text());
            else {
                var fulldate = new Date();
                var thisyear = (fulldate.getUTCFullYear() - 1911).toString();
                var thismonth = (fulldate.getMonth() + 1).toString().lpad("0", 2);
                var thisday = fulldate.getDate().toString().lpad("0", 2);

                $('#bt-in-take_date').val(thisyear.concat(thismonth, thisday));

            }

            $('#bt-in-agent').val(agent.text());
        });

    });
}