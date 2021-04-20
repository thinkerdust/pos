const site_url = "<?php echo site_url(); ?>";
$("#tb_category").dataTable({
    bProcessing: true,
    serverSide: true,
    // scrollY: "400px",
    scrollCollapse: true,
    ajax: {
        url: "category-ajax-data", // json datasource
        type: "post",
        data: {
            // key1: value1 - in case if we want send data with request
        }
    },
    columns: [
        { data: "category_id" },
        { data: "category_name" },
        { data: "category_status" },
        // { data: "action" }
    ],
    columnDefs: [
        { orderable: true, targets: [0, 1, 2] }
    ],
    bFilter: true, // to display datatable search
    order: [
        [0, "asc"]
    ],
    lengthMenu: [
        [10, 25, 100, -1],
        [10, 25, 100, "All"]
    ],
    pageLength: 10,
    paging: true,
    dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
});