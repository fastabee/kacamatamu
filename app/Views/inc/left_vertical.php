<aside class="left-sidebar with-vertical">

    <!-- ===== Brand / Logo ===== -->
    <div class="brand-logo d-flex flex-column justify-content-center align-items-center py-3">
        <a href="<?= base_url() ?>" class="text-nowrap logo-img mb-2">
            <img src="<?= base_url('public/foto88/logodash.png') ?>"
                alt="Logo"
                class="light-logo w-100 h-auto"
                style="max-width: 120px;" />
            <img src="<?= base_url('public/image/logo_login.png') ?>"
                alt="Logo"
                class="dark-logo w-100 h-auto"
                style="max-width: 120px;" />
        </a>

        <a href="javascript:void(0)"
            class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
        </a>
    </div>

    <!-- ===== Sidebar Scroll Area ===== -->
    <div class="scroll-sidebar" data-simplebar>

        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="mb-0">

               

                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg" href="<?= base_url('/') ?>">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:screencast-2-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Dashboard</span>
                    </a>
                </li>

                

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:database-linear" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Data Master</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="<?= base_url('lensa') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:eye-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Lensa</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url('frame') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:glasses-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Frame</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url('kacamata') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:eye-scan-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Kacamata</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url('customer') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:user-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Customer</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url('supplier') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:truck-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Supplier</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Stok -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)" aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:cart-linear" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Pembelian</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="<?= base_url('pembelian') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:document-text-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Data Pembelian</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Penjualan -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)" aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:tag-price-linear" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Penjualan</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="<?= base_url('penjualan') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:document-text-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Data Penjualan</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Stok Barang -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:box-linear" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Stok</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="<?= base_url('stok/lensa') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:eye-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Stok Lensa</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url('stok/frame') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:glasses-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Stok Frame</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url('stok/kacamata') ?>" class="sidebar-link primary-hover-bg">
                                <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                    <iconify-icon icon="solar:eye-scan-linear" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">Stok Kacamata</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>

        <!-- ===== Fixed Profile / Logout ===== -->
        <div class="fixed-profile mx-3 mt-3">
            <div class="card bg-primary-subtle mb-0 shadow-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= base_url('public/assets/images/profile/user-1.jpg') ?>"
                                width="45" height="45"
                                class="img-fluid rounded-circle" alt="" />
                            <div>
                                <h5 class="mb-1"><?= session('nama_pegawai') ?></h5>
                                <p class="mb-0">Admin</p>
                            </div>
                        </div>
                        <a href="<?= base_url('logout') ?>"
                            data-bs-toggle="tooltip"
                            data-bs-title="Logout">
                            <iconify-icon icon="solar:logout-line-duotone"
                                class="fs-8"></iconify-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</aside>
