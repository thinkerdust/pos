// Global
$(".select2").select2();

$("#pro_category").select2({
    dropdownParent: $('#mdladdproduct')
});

$("#trx_product").select2({
    dropdownParent: $('#mdladdtransaction')
});

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

const readURL = (input,el) => {
	if (input.files && input.files[0]) {
		const reader = new FileReader()
		reader.onload = (e) => {
			$('#'+el).removeAttr('src')
			$('#'+el).attr('src', e.target.result)
		}
		reader.readAsDataURL(input.files[0])
	}
}

$('#image').on('change', function() {
	readURL(this,'preview_image')
})

// zoom img
function zoomImg(url)
{
    $('.fullimage').attr('src', url);
    $('#modalimage').modal('show'); 
}

// counter number
$(document).ready(function() {
    $('.count').each(function() {
        var $this = $(this);
        $(this).prop('Counter', 0).animate({
           
           Counter: $this.text()
        }, {
           
           duration: 3000,
           easing: 'swing',
           step: function(now) {
              
              $(this).text(Math.ceil(now).toLocaleString('en'));
           }
        });
       
     });
});

// input number only
$('.number').keypress(function(e){ 
    if (e.which > 31 && (e.which < 48 || e.which > 57)){
       return false;
    }
    if (this.value.length == 0 && e.which == 48 ){
       return false;
    }
    return true;
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
    buttons: ['excel', 'pdf'],
    dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
});

TableCategory.buttons().container().appendTo( '#tb_category .col-md-6:eq(0)' );

function addCategory(){
    $('#mdladdcategory').modal({show:true, backdrop: 'static'});
    $('#mdlcategorytitle').text('Add Category');
    $('#cat_name').val('');
    $('#cat_code').val('');
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
            $('#cat_code').val(data['kode']);
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
    let kode = $('#cat_code').val();
    let status = $("input[type='radio']:checked").val();
    let cUrl = '';
    let type = $('#cat_type').val();
    let id = $('#cat_id').val();

    if(type == 'CREATE'){
        cUrl = 'category/store';
    }else{
        cUrl = 'category/update/'+id;
    }

    if(name && status && kode){
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
                    data: {'name':name, 'kode':kode, 'status':status},
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
    buttons: ['excel', 'pdf'],
    dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
});

TableProduct.buttons().container().appendTo( '#tb_product .col-md-6:eq(0)' );

function clear_form_product(){
    $('#pro_id').val('');
    $("input[type='file']").trigger('change');
    $('#pro_category').val('-1').change();
    $('#pro_name').val('');
    $('#pro_price').val('');
    $('#pro_sku').val('');
    $('#pro_desc').val('');
    $('#pro_stock').val('');
    $("input[type='radio']").prop('checked', false);
}

function addProduct(){
    clear_form_product();
    $('#mdladdproduct').modal({show:true, backdrop: 'static'});
    $('#mdlproducttitle').text('Add Product');
    $('#form_pro_sku').attr('hidden', true);
    $('#preview_image').attr('src', "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/600px-No_image_available.png");
    $('#image').attr('required', true);
}

function editProduct(id){
    $('#mdladdproduct').modal({show:true, backdrop: 'static'});
    $('#mdlproducttitle').text('Edit Product');
    $('#form_pro_sku').attr('hidden', false);
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
            $('#image').attr('required', false);
            $('#pro_stock').val(data['product_stock']);
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
        type: "warning",
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
                  clear_form_product();
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

function deleteProduct(id)
{
    Swal.fire({
        title: "Are you sure?",
        text: "Data will be deleted",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete"
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: 'product/delete/'+id,
                type: 'get',
                dataType: 'JSON',
                success: function(data){
                    if(data){
                        Swal.fire(
                            'Deleted!',
                            'Data successfully deleted',
                            'success'
                        )
                        TableProduct.ajax.reload();
                    }else{
                        Swal.fire(
                            'Failed!',
                            'Data fail to deleted',
                            'error'
                        )
                    }
                },
                error: function(error){
                    console.log(error);
                }
            })
        }
    })
}

// Transaction
const TableTransaction = $("#tb_transaction").DataTable({
    bProcessing: true,
    serverSide: true,
    responsive:true,
    // scrollY: "400px",
    // scrollX: true,
    scrollCollapse: true,
    ajax: {
        url: "transaction/get-data-ajax", // json datasource
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
    buttons: ['excel', 'pdf'],
    dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
});

TableTransaction.buttons().container().appendTo( '#tb_transaction .col-md-6:eq(0)' );

function clear_form_transaction()
{
    $('#trx_id').val('');
    $('#trx_product').val('').change();
    $('#trx_qty').val('');
    $('#trx_date').val('');
}

function addTransaction()
{
    clear_form_transaction();
    $('#mdladdtransaction').modal({show:true, backdrop: 'static'});
    $('#mdltransactiontitle').text('Add Transaction');
}

$("#formTransaction").submit(function (event) {
    event.preventDefault();
    formData = new FormData($(this)[0]);
    Swal.fire({
        title: "Are you sure?",
        text: "Data will be saved",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function(result) {
        if (result.value) {
            $.ajax({
              url: 'transaction/store',
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
                  $("#formTransaction")[0].reset();
                  clear_form_transaction();
                  $('#mdladdtransaction').modal('hide');
                  TableTransaction.ajax.reload();
                } else {
                    Swal.fire(
                        'Failed!',
                        'Out of stock',
                        'error'
                    )
                }
              },
              error: function (error) {
                console.log(error);
                Swal.fire(
                    'Failed!',
                    'Failed to save data',
                    'error'
                )
              }
          })
        }
    });
});

function editTransaction(id)
{
    $('#mdladdtransaction').modal({show:true, backdrop: 'static'});
    $('#mdltransactiontitle').text('Edit Transaction');
    $('#trx_id').val(id);

    $.ajax({
        url: 'transaction/edit/'+id,
        type: 'get',
        dataType: 'JSON',
        success: function(data){
            $('#trx_product').val(data['product_id']).change();
            $('#trx_qty').val(data['trx_qty']);
            $('#trx_date').val(data['trx_date']);
        }
    })
}

function deleteTransaction(id)
{
    Swal.fire({
        title: "Are you sure?",
        text: "Data will be deleted",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete"
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: 'transaction/delete/'+id,
                type: 'get',
                dataType: 'JSON',
                success: function(data){
                    if(data){
                        Swal.fire(
                            'Deleted!',
                            'Data successfully deleted',
                            'success'
                        )
                        TableTransaction.ajax.reload();
                    }else{
                        Swal.fire(
                            'Failed!',
                            'Data fail to deleted',
                            'error'
                        )
                    }
                },
                error: function(error){
                    console.log(error);
                }
            })
        }
    })
}

$('#trx_product').change(function() {
    let id = $(this).val();
    $.ajax({
        url: 'transaction/get-price',
        type: 'get',
        data: {id:id},
        dataType: 'JSON',
        success: function(data){
            if(data)
            {
                $('#trx_price').val('Rp. ' +  new Intl.NumberFormat(['ban', 'id']).format(data['product_price']));
            }else{
                $('#trx_price').val('');
            }
        }
    })
})