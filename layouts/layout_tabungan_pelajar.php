<!-- Layout untuk tabungan pelajar -->

<div id="layoutSidenav_content">
    <main>

        <?php if ($_SESSION['role'] == 'admin') { ?>

            <!-- Modal tambah-->
            <div class="modal fade hidden-tambah-pelajar" id="tambahPelajar" tabindex="-1" aria-labelledby="tambahPelajar" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="tambahPelajar">Tambah Tabungan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">

                            <!-- Form tambah pelajar -->
                            <form method="post" action="storeData.php" id="form_tambah_pelajar">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" autocomplete="off" required />
                                </div>

                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" autocomplete="off" required />
                                </div>

                                <div class="mb-3">
                                    <label for="saldo" class="form-label">Saldo</label>
                                    <input type="number" class="form-control" id="saldo" name="saldo" autocomplete="off" required />
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option selected></option>
                                        <option value="aktif">aktif</option>
                                        <option value="tidak aktif">tidak aktif</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-success" name="submit">Tambah</button>
                                </div>
                            </form>
                            <!-- Akhir form tambah pelajar-->

                        </div>
                    </div>
                </div>
            </div>
            <!-- </Akhir modal tambah-->
        <?php } ?>

        <!-- Modal update pelajar-->
        <div class="modal fade hidden-update-pelajar" id="updatePelajar" tabindex="-1" aria-labelledby="updatePelajar" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updatePelajar">Update Tabungan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Edit modal form -->
                    <div class="modal-body" id="modal-update"></div>
                    <!-- </Akhir edit modal form -->

                </div>
            </div>
        </div>
        <!-- </Akhir modal update pelajar-->


        <!-- Main content data table pelajar -->
        <div id="mainContent"></div>
    </main>
</div>

<!-- </Akhir layout tabungan pelajar -->