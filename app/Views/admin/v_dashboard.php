<?php echo view('template/v_header') ?>
<?php echo view('template/v_sidebar') ?>

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Product</h4>
                        </div>
                        <div class="card-body">
                            <span class="count"><?php echo $total_product;?></span>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Transaction</h4>
                        </div>
                        <div class="card-body">
                            Rp. <span class="count"><?php echo $total_transaction->trx_price;?></span>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-dolly"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Product Best Seller</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $best_seller->product_name;?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>Chart Transaction</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php echo view('template/v_footer') ?>