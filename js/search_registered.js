$(function() {
    registered_table =
        $('#Btable').DataTable({
            "responsive": true,
            "scrollCollapse": true,
            "displayLength": 20,
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
            ]
        });

    $('#take-or-not').change( // 選擇系所後
        function(e) {
            if ($(':selected', this).val() !== '') {
                registered_table.ajax.reload();
            }
        }
    );
});
