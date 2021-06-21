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
                <h4 class="mr-auto">Table Management Category</h4>
                <a href="#" class="btn btn-success" onclick="addCategory()">
                  <i class="fas fa-plus-circle"></i> add data
                </a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="tb_category">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Name Category</th>
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

  <!-- modal -->
  <div class="modal fade" id="mdladdcategory" tabindex="-1" role="dialog" aria-labelledby="mdlcategorytitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlcategorytitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Name Category</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="cat_name" placeholder="Name Category">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Code Category</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="cat_code" placeholder="Code Category" style="text-transform:uppercase;">
            </div>
          </div>
          <fieldset class="form-group">
            <div class="row">
              <div class="col-form-label col-sm-3 pt-0">Status</div>
              <div class="col-sm-9">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="cat_status" id="cat_status1" value="Active">
                  <label class="form-check-label" for="gridRadios1">
                    Active
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="cat_status" id="cat_status2" value="Inactive">
                  <label class="form-check-label" for="gridRadios2">
                    Non-Active
                  </label>
                </div>
              </div>
            </div>
          </fieldset>
          <input type="hidden" val="" id="cat_id">
          <input type="hidden" val="" id="cat_type">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="saveCategory()">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end: modal -->
<?php echo view('template/v_footer') ?>