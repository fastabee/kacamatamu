<section class="welcome">
    <div class="row">
        <div class="col-lg-12 col-xl-6 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body position-relative">
                    <div>
                        <h5 class="mb-1 fw-bold">Welcome <?= session('nama') ?></h5>
                        <p class="fs-3 mb-3 pb-1">Check all the statastics</p>

                    </div>
                    <div class="school-img d-none d-sm-block">
                        <img src="<?php echo base_url('public/') ?>assets/images/backgrounds/school.png" class="img-fluid" alt="" />
                    </div>

                    <div class="d-sm-none d-block text-center">
                        <img src="<?php echo base_url('public/') ?>assets/images/backgrounds/school.png" class="img-fluid" alt="" />
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</section>

<!-- Dashboard-specific scripts -->
<script src="<?php echo base_url('public/') ?>assets/libs/jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?php echo base_url('public/') ?>assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="<?php echo base_url('public/') ?>assets/js/extra-libs/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
<script src="<?php echo base_url('public/') ?>assets/js/dashboards/dashboard.js"></script>
