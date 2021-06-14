// Global
$(".select2").select2();

$('.harga').keyup(function(e) {
    if (/^0/.test(this.value)) {
        this.value = this.value.replace(/^0/, "")
    }else{
        $(this).val(formatRupiah($(this).val(), 'Rp. '));
    }
});

/* Fungsi formatRupiah */
function formatRupiah(angka,prefix){
  let number_string = angka.replace(/[^,\d]/g, '').toString(),
  split         = number_string.split(','),
  sisa          = split[0].length % 3,
  rupiah            = split[0].substr(0, sisa),
  ribuan            = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if(ribuan){
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
};

// onchange file upload
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

// Category
const TableCategory = $("#tb_category").DataTable({
    bProcessing: true,
    serverSide: true,
    responsive:true,
    // scrollY: "400px",
    // scrollX: true,
    scrollCollapse: true,
    ajax: {
        url: "category/get-data-ajax", // json datasource
        type: "post",
        data: {
            // key1: value1 - in case if we want send data with request
        }
    },
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

function addCategory(){
    $('#mdladdcategory').modal({show:true, backdrop: 'static'});
    $('#mdlcategorytitle').text('Add Category');
    $('#cat_name').val('');
    $('#cat_status1').prop('checked', false);
    $('#cat_status2').prop('checked', false);
    $('#cat_type').val('CREATE');
}

function editCategory(id){
    $('#mdladdcategory').modal({show:true, backdrop: 'static'});
    $('#mdlcategorytitle').text('Edit Category');
    $('#cat_type').val('UPDATE');
    $('#cat_id').val(id);
    $.ajax({
        url: 'category/edit/'+id,
        type: 'get',
        dataType: 'JSON',
        success: function(data){
            $('#cat_name').val(data['category_name']);
            if(data['category_status'] == 'Active'){
                $('#cat_status1').prop('checked', true);
            }else{
                $('#cat_status2').prop('checked', true);
            }
        }
    })
}

function saveCategory(){
    let name = $('#cat_name').val();
    let status = $("input[type='radio']:checked").val();
    let cUrl = '';
    let type = $('#cat_type').val();
    let id = $('#cat_id').val();

    if(type == 'CREATE'){
        cUrl = 'category/store';
    }else{
        cUrl = 'category/update/'+id;
    }

    if(name && status){
        Swal.fire({
            title: "Do you want to save the changes?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Save"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: cUrl,
                    type: 'post',
                    data: {'name':name, 'status':status},
                    success: function(data){
                        console.log(data)
                        if(data){
                            TableCategory.ajax.reload();
                            $('#mdladdcategory').modal('hide');
                            Swal.fire('Saved!', '', 'success');
                        }else{
                            Swal.fire('Failed!', '', 'danger');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        console.log(jqXHR);
                        alert('Error get data from ajax');
                    }
                })
            }
        });
    }else{
        Swal.fire(
            'Opps!',
            'Please fill the form',
            'error'
        );
    }
}

function deleteCategory(id){
    Swal.fire({
        title: "Do you want to delete the data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete"
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: 'category/delete/'+id,
                type: 'get',
                success: function(data){
                    if(data){
                        TableCategory.ajax.reload();
                        Swal.fire('Success!', '', 'success');
                    }else{
                        Swal.fire('Failed!', '', 'error');
                    }
                }
            })
        }
    });
}

// Product
const TableProduct = $("#tb_product").DataTable({
    bProcessing: true,
    serverSide: true,
    responsive:true,
    // scrollY: "400px",
    // scrollX: true,
    scrollCollapse: true,
    ajax: {
        url: "product/get-data-ajax", // json datasource
        type: "post",
        data: {
            // key1: value1 - in case if we want send data with request
        }
    },
    columnDefs: [
        // { orderable: true, targets: [0, 1, 2] }
        { orderable: false, searchable: false, targets: -1 } 
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

function addProduct(){
    $('#mdladdproduct').modal({show:true, backdrop: 'static'});
    $('#mdlproducttitle').text('Add Product');
    $('#preview_image').attr('src', "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/600px-No_image_available.png")
}

function editProduct(id){
    $('#mdladdproduct').modal({show:true, backdrop: 'static'});
    $('#mdlproducttitle').text('Edit Product');
    $('#pro_id').val(id);
    $.ajax({
        url: 'product/edit/'+id,
        type: 'get',
        dataType: 'json',
        success: function(data){
            $('#pro_category').val(data['category_id']).change();
            $('#pro_name').val(data['product_name']);
            $('#pro_price').val('Rp. ' +  new Intl.NumberFormat(['ban', 'id']).format(data['product_price']));
            $('#pro_sku').val(data['product_sku']);
            $('#pro_desc').val(data['product_description']);
            $('#preview_image').attr('src', base_url+'/uploads/'+data['product_image']);
            if(data['product_status'] === 'Active'){
                $('#pro_status1').prop('checked', true);
            }else{
                $('#pro_status2').prop('checked', true);
            }
        }
    })
}

$("#formProduct").submit(function (event) {
    event.preventDefault();
    formData = new FormData($(this)[0]);
    Swal.fire({
        title: "Are you sure?",
        text: "Data will be saved",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function(result) {
        if (result.value) {
            $.ajax({
              url: 'product/store',
              type: "post",
              data: formData,
              async: true,
              cache: false,
              dataType: "json",
              contentType: false,
              processData: false,
              success: function (data) {
                if (data) {
                    Swal.fire(
                        'Saved!',
                        'Data successfully saved',
                        'success'
                    )
                  $("#formProduct")[0].reset();
                  $("input[type='file']").trigger('change');
                  $('#mdladdproduct').modal('hide');
                  TableProduct.ajax.reload();
                } else {
                    Swal.fire(
                        'Failed!',
                        'Failed to save data',
                        'error'
                    )
                }
              },
              error: function (error) {
                console.log(error);
              }
          })
        }
    });
});

// zoom img
function zoomImg(url)
{
    $('.fullimage').attr('src', url);
    $('#modalimage').modal('show'); 
}