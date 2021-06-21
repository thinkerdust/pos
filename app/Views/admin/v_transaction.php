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
                <h4 class="mr-auto">Table Management Transaction</h4>
                <a href="#" class="btn btn-success" onclick="addTransaction()">
                  <i class="fas fa-plus-circle"></i> add data
                </a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="tb_transaction">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Date</th>
                        <th>Qty</th>
                        <th>Total</th>
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

  <!-- modal: add Transaction -->
  <div class="modal fade" id="mdladdtransaction" tabindex="-1" role="dialog" aria-labelledby="mdltransactiontitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdltransactiontitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formTransaction">
          <div class="modal-body">
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Product</label>
              <div class="col-sm-9">
                <?php 
                    echo form_dropdown('product_id', $product, '', ' class="form-control select2" id="trx_product" required=""');
                ?>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Qty Product</label>
              <div class="col-sm-9">
                <input type="text" class="form-control number" id="trx_qty" name="transaction_qty" required="" value="1">
                <span class="sr-only">*please check again stock of product</span>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Price Product</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="trx_price" placeholder="Price Transaction" name="transaction_price" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Date Transaction</label>
              <div class="col-sm-9">
                <input type="date" class="form-control" id="trx_date" placeholder="Date Transaction" name="transaction_date" required="">
              </div>
            </div>
            <input type="hidden" val="" id="trx_id" name="transaction_id">
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
<?php echo view('template/v_footer') ?>