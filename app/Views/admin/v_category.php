<?php echo view('template/v_header') ?>
<?php echo view('template/v_sidebar') ?>

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
        <div class="section-header">
            <h1>Blank Page</h1>
        </div>

        <div class="section-body">
        <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Advanced Table</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="tb_category">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <!-- <th>Action</th> -->
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
<?php echo view('template/v_footer') ?>