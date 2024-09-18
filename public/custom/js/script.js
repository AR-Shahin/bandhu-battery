function initalizeDatatable(route,columns,table="data-table"){
    $(function () {
        $('.'+table).DataTable({
            "processing": true,
            "retrieve": true,
            "serverSide": true,
            'paginate': true,
            'searchDelay': 700,
            "bDeferRender": true,
            "responsive": true,
            "autoWidth": true,
            "order": [ [0, 'asc'] ],
            lengthMenu: [[5,10,15, 25, 50, -1], [5,10,15, 25, 50, "All"]],
            pageLength: 15,
            ajax: route,
            columns: columns
        });
      });
}


function initFilterDataTable(route,columns,filterData,table="data-table"){
    $(function () {
        let dt_table = $('.'+table).DataTable({
            "processing": true,
            "retrieve": true,
            "serverSide": true,
            'paginate': true,
            'searchDelay': 700,
            "bDeferRender": true,
            "responsive": true,
            "autoWidth": true,
            "order": [ [0, 'asc'] ],
            lengthMenu: [[5,10,15, 25, 50, -1], [5,10,15, 25, 50, "All"]],
            pageLength: 15,
            ajax: {
                url : route,
                data : filterData
            },
            columns: columns
        });

        $("#filterForm").submit(function(e){
            dt_table.draw();
       })
      });
}
