<!-- Bagian Footer Copyright Sidik -->
        <footer class="text-center py-3 mt-5 border-top">
            <p class="text-muted mb-0 small">
                &copy; <?php echo date('Y'); ?> Elearning Corp. Developed by 
                <a href="https://instagram.com/muhmmdsidiik_" target="_blank" class="text-decoration-none text-dark fw-bold">
                    <i class="bi bi-instagram text-danger"></i> Muhammad Sidik Permana
                </a>. All Rights Reserved.
            </p>
        </footer>

    </div><!-- /.col-md-10 (ditutup dari sidebar.php) -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Sidebar Collapse Styles */
    @media (min-width: 768px) {
        body.sidebar-collapsed .sidebar {
            width: 80px !important;
            flex: 0 0 80px !important;
            max-width: 80px !important;
        }
        body.sidebar-collapsed .sidebar .sidebar-text {
            display: none !important;
        }
        body.sidebar-collapsed .sidebar .nav-link {
            text-align: center;
            padding: 0.8rem 0;
            justify-content: center;
        }
        body.sidebar-collapsed .sidebar .nav-link i {
            font-size: 1.5rem;
            margin-right: 0 !important;
            display: block;
        }
        body.sidebar-collapsed .main-content {
            width: calc(100% - 80px) !important;
            flex: 0 0 calc(100% - 80px) !important;
            max-width: calc(100% - 80px) !important;
        }
        /* Smooth transition */
        .sidebar, .main-content {
            transition: all 0.3s ease;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                document.body.classList.toggle('sidebar-collapsed');
            });
        }

        // Hapus data (Admin)
        const deleteBtns = document.querySelectorAll('.btn-delete');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                const text = this.getAttribute('data-text') || 'Hapus data ini?';
                
                Swal.fire({
                    title: 'Konfirmasi',
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });

        // Submit Kuis (Karyawan)
        const submitKuisBtn = document.querySelector('.btn-submit-kuis');
        if (submitKuisBtn) {
            submitKuisBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = document.getElementById('formKuis');
                const text = this.getAttribute('data-text');
                
                // Cek validasi HTML5 bawaan sebelum show popup
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi',
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Submit!',
                    cancelButtonText: 'Cek Lagi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    });
</script>
</body>
</html>