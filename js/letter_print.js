$(function() {
    // registered_table =
    //     $('#Btable').DataTable({
    //         // dom: 'Bfrtip',
    //         // buttons: [
    //         //     'pdf', 'print'
    //         // ],
    //         "responsive": true,
    //         "scrollCollapse": true,
    //         "displayLength": 25,
    //         "paginate": true,
    //         "lengthChange": true,
    //         "processing": false,
    //         "serverSide": false,
    //         "ajax": {
    //             url: 'ajax/letter_print_ajax.php',
    //             type: 'POST',
    //             data: function (d) {
    //                 d.oper = "registered"
    //             },
    //             dataType: 'json'
    //         },
    //         "columns": [
    //           { "name": "dept_code" },
    //           { "name": "name" },
    //           { "name": "letter_no" },
    //           { "name": "receive_date" },
    //           { "name": "room_code" },
    //           { "name": "signature" },
    //         ]
    //     });

    $(".btn-print").click(function() {
        $('#form1').attr("action", "rpt/letter_print_list.php")
            .attr("method", "post").attr("target","_blank");
        $('#form1').submit();
    });
});
