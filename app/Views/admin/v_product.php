<?php echo view('template/v_header') ?>
<?php echo view('template/v_sidebar') ?>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="mr-auto">Table Management Product</h4>
                <a href="#" class="btn btn-success" onclick="addProduct()">
                  <i class="fas fa-plus-circle"></i> add data
                </a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="tb_product">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Thumbnail</th>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end: Main Content -->

  <!-- modal: add product -->
  <div class="modal fade" id="mdladdproduct" tabindex="-1" role="dialog" aria-labelledby="mdlproducttitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlproducttitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formProduct">
          <div class="modal-body">
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Category</label>
              <div class="col-sm-9">
              <?php 
								echo form_dropdown('category_id', $category, '-1', ' class="form-control" id="pro_category" required=""');
							?>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Name Product</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="pro_name" placeholder="Name Product" name="product_name" required="">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Price Product</label>
              <div class="col-sm-9">
                <input type="text" class="form-control harga" id="pro_price" placeholder="Price Product" name="product_price" required="">
              </div>
            </div>
            <div class="form-group row" id="form_pro_sku">
              <label for="inputPassword3" class="col-sm-3 col-form-label">SKU Product</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="pro_sku" name="product_sku" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Description Product</label>
              <div class="col-sm-9">
                <textarea class="form-control" id="pro_desc" placeholder="Description Product" name="product_desc" style="height:110px" required=""></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Image Product</label>
              <div class="col-sm-9">
                <img id="preview_image" src="" style="height:150px"><br><br>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="image" name="product_image" accept=".png,.jpg,.jpeg">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                  <span class="text-muted">Max. file 2Mb | Kosongi jika tidak ingin mengganti</span>
                </div>
              </div>
					  </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Stock Product</label>
              <div class="col-sm-9">
                <input type="text" class="form-control number" id="pro_stock" name="product_stock" value="1" required>
              </div>
            </div>
            <fieldset class="form-group">
              <div class="row">
                <div class="col-form-label col-sm-3 pt-0">Status</div>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="product_status" id="pro_status1" value="Active" required="">
                    <label class="form-check-label" for="gridRadios1">
                      Active
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="product_status" id="pro_status2" value="Inactive">
                    <label class="form-check-label" for="gridRadios2">
                      Non-Active
                    </label>
                  </div>
                </div>
              </div>
            </fieldset>
            <input type="hidden" val="" id="pro_id" name="product_id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end: modal -->

  <!-- modal: preview image -->
  <div class="modal fade" id="modalimage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    <div class="modal-header">
	    	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    </div>
      	<div class="modal-body">
        	<img src="" class="fullimage" style="width: 100%;" >
      	</div>
	    </div>
	  </div>
	</div>
  <!-- end: modal -->
<?php echo view('template/v_footer') ?>