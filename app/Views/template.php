<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="dark" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link
    rel="shortcut icon"
    type="image/png"
    href="<?php echo base_url('public/') ?>foto88/horizontal_88group.png" />

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- Core Css -->
  <link rel="stylesheet" href="<?php echo base_url('public/') ?>assets/css/styles.css" />

  <title>E-Kacamatamu</title>

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
  <!-- Select2 CSS -->
  <link rel="stylesheet" href="<?php echo base_url('public/assets/libs/select2/dist/css/select2.min.css') ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Vendor JS - harus sebelum view body -->
  <script src="<?php echo base_url('public/') ?>assets/js/vendor.min.js"></script>
  <script src="<?php echo base_url('public/') ?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url('public/') ?>assets/libs/simplebar/dist/simplebar.min.js"></script>
  <!-- DataTables JS -->
  <script src="<?php echo base_url('public/assets/libs/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <!-- Select2 JS -->
  <script src="<?php echo base_url('public/assets/libs/select2/dist/js/select2.full.min.js') ?>"></script>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="<?php echo base_url('public/') ?>assets/images/logos/loader.svg" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <?php echo view('inc/left_vertical') ?>
    <!--  Sidebar End -->
    <div class="page-wrapper">

      <?php echo view('inc/left_horizontal') ?>

      <div class="body-wrapper">
        <div class="container-fluid">
          <!--  Header Start -->
          <?php echo view('inc/head') ?>
          <!--  Header End -->
          <?php echo view($body) ?>
        </div>
      </div>

      <script>
        function handleColorTheme(e) {
          $("html").attr("data-color-theme", e);
          $(e).prop("checked", !0);
          localStorage.setItem("colorTheme", e);
        }
      </script>

      <button class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn"
        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <i class="icon ti ti-settings fs-7"></i>
      </button>

      <div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
          <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
            Settings
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body h-n80" data-simplebar>
          <h6 class="fw-semibold fs-4 mb-2">Theme</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check light-layout" name="theme-layout" id="light-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="light-layout"><i
                class="icon ti ti-brightness-up fs-7 me-2"></i>Light</label>

            <input type="radio" class="btn-check dark-layout" name="theme-layout" id="dark-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="dark-layout"><i class="icon ti ti-moon fs-7 me-2"></i>Dark</label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Direction</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="direction-l" id="ltr-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="ltr-layout"><i
                class="icon ti ti-text-direction-ltr fs-7 me-2"></i>LTR</label>

            <input type="radio" class="btn-check" name="direction-l" id="rtl-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="rtl-layout"><i
                class="icon ti ti-text-direction-rtl fs-7 me-2"></i>RTL</label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Colors</h6>

          <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
            <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme"
              autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Blue_Theme')"
              for="Blue_Theme" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="BLUE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme"
              autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Aqua_Theme')"
              for="Aqua_Theme" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="AQUA_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Purple_Theme')"
              for="Purple_Theme" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PURPLE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Green_Theme')"
              for="green-theme-layout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="GREEN_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Cyan_Theme')"
              for="cyan-theme-layout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="CYAN_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Orange_Theme')"
              for="orange-theme-layout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ORANGE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Layout Type</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <div>
              <input type="radio" class="btn-check" name="page-layout" id="vertical-layout" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="vertical-layout"><i
                  class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Vertical</label>
            </div>
            <div>
              <input type="radio" class="btn-check" name="page-layout" id="horizontal-layout" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="horizontal-layout"><i
                  class="icon ti ti-layout-navbar fs-7 me-2"></i>Horizontal</label>
            </div>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Container Option</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i
                class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Boxed</label>

            <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="full-layout"><i
                class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Full</label>
          </div>

          <h6 class="fw-semibold fs-4 mb-2 mt-5">Sidebar Type</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <a href="javascript:void(0)" class="fullsidebar">
              <input type="radio" class="btn-check" name="sidebar-type" id="full-sidebar" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="full-sidebar"><i
                  class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Full</label>
            </a>
            <div>
              <input type="radio" class="btn-check " name="sidebar-type" id="mini-sidebar" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="mini-sidebar"><i
                  class="icon ti ti-layout-sidebar fs-7 me-2"></i>Collapse</label>
            </div>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Card With</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="card-layout" id="card-with-border" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="card-with-border"><i
                class="icon ti ti-border-outer fs-7 me-2"></i>Border</label>

            <input type="radio" class="btn-check" name="card-layout" id="card-without-border" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="card-without-border"><i
                class="icon ti ti-border-none fs-7 me-2"></i>Shadow</label>
          </div>
        </div>
      </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
  </div>


  <!-- js alert -->
  <?php if (session()->getFlashdata('sukses')) : ?>
    <script>
      $(document).ready(function() {
        toastr.success(
          "<?= session()->getFlashdata('sukses'); ?>",
          "Berhasil!", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            progressBar: true,
            timeOut: 2000
          }
        );
      });
    </script>
  <?php endif; ?>
  <!-- js alert Ends -->
  <?php if (session()->getFlashdata('gagal')) : ?>
    <script>
      $(document).ready(function() {
        toastr.warning(
          <?= json_encode(session()->getFlashdata('gagal')) ?>,
          "Gagal!", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            progressBar: true,
            timeOut: 2000
          }
        );
      });
    </script>
  <?php endif ?>
  <script src="<?php echo base_url('public/') ?>assets/js/theme/app.dark.init.js"></script>
  <script src="<?php echo base_url('public/') ?>assets/js/theme/theme.js"></script>
  <script src="<?php echo base_url('public/') ?>assets/js/theme/app.min.js"></script>
  <script src="<?php echo base_url('public/') ?>assets/js/theme/sidebarmenu.js"></script>
  <script src="<?php echo base_url('public/') ?>assets/js/theme/feather.min.js"></script>
  <script src="<?php echo base_url('public/assets/js/plugins/toastr-init.js') ?>"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

</body>

</html>