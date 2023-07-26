$(document).ready(function () {
  getData(); //Panggil function getData untuk menampilkan datatable pelajar secara ajax
  getDataProfile();

  let path = "ajax/"; // Path ajax
  let cetakRekening = $(".cetakRekening"); // Tombol cetak rekening
  $(".dataTable").DataTable(); // Data table

  // Menangani klik tombol cetak
  $(cetakRekening).click(function () {
    window.print();
  });

  function getDataProfile() {
    let fotoProfile = $("#fotoProfile");

    $.ajax({
      type: "get",
      url: "ajax/getFotoProfile.php",
      success: function (data) {
        fotoProfile.html(data);
      },
    });
  }

  $("#form_ganti_foto_profile").on("submit", function (e) {
    e.preventDefault();
    let formProfile = $(this); // Menyimpan referensi form saat ini
    let formDataProfile = new FormData(formProfile[0]); // Membuat objek FormData untuk mengambil data form termasuk gambar

    $.ajax({
      type: "post",
      url: "ajax/updateFotoProfile.php",
      data: formDataProfile,
      dataType: "json",
      contentType: false, // Mengabaikan tipe konten yang didefinisikan secara otomatis
      processData: false, // Tidak memproses data secara otomatis
      success: function (response) {
        getDataProfile();

        $("[type=file]").val("");
        $(".hidden-profile-pelajar").modal("hide");

        let res = response.message;

        if (response.success) {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });

          Toast.fire({
            icon: "success",
            title: res,
          });
        } else {
          Swal.fire("GAGAL", res, "error");
        }
      },

      // error: function(xhr, textStatus, errorThrown) {
      //     // Tampilkan pesan kesalahan dengan lebih rinci
      //     console.log('Error status:', xhr.status);
      //     console.log('Error message:', xhr.responseText);
      //     console.log('Error type:', textStatus);
      //     console.log('Error thrown:', errorThrown);

      //     // Tampilkan pesan kesalahan menggunakan Swal.fire atau metode lain yang Anda gunakan
      //     Swal.fire(
      //         'ERROR',
      //         'Terjadi kesalahan saat mengirim data. Silakan coba lagi.',
      //         'error'
      //     );
      // }
    });
  });

  $("#form_tambah_pelajar").on("submit", function (e) {
    e.preventDefault(); // Mencegah perilaku default saat form disubmit

    $.ajax({
      type: "post", // Mendapatkan metode form (POST)
      url: path + $(this).attr("action"), // Mendapatkan URL aksi form
      data: $(this).serialize(), // Mendapatkan data form
      dataType: "json", // Set type json untuk mengurai data dan response dari backend
      success: function (response) {
        getData(); // Memanggil fungsi getData setelah data berhasil ditambahkan

        // Response JSON dari backend
        let messageResponse = response.message;

        // Jika response berhasil
        if (response.success) {
          // Kosongkan field text, number, email, option selected dan tutup modal setelah berhasil di insert
          $("[type=text], [type=number], [type=email]").val("");
          $("option:selected").prop("selected", false);
          $(".hidden-tambah-pelajar").modal("hide");

          // Beri response
          Swal.fire("BERHASIL", messageResponse, "success");
        } else {
          // Response gagal, tampilkan pesan kesalahan ketika terjadi kesalahan pada backend web aplikasi
          Swal.fire("GAGAL", messageResponse, "error");
        }
      },
    });
  });

  // Function untuk mendapatkan tahun
  function getFullYear() {
    let currentYear = new Date().getFullYear();

    // Loop menggunakan each untuk mengisi elemen dengan class 'angkatan'
    $(".angkatan").each(function () {
      let selectElement = $(this);

      // Loop untuk mengisi pilihan tahun mulai dari tahun saat ini hingga tahun 1900
      for (let i = currentYear; i >= 1900; i--) {
        selectElement.append($("<option />").val(i).html(i));
      }
    });
  }

  // Function getData()
  function getData() {
    let mainContent = $("#mainContent"); // Element untuk main content datatable pelajar

    $.ajax({
      type: "get", // Method GET
      url: "ajax/getData.php",
      success: function (data) {
        $(mainContent).html(data);

        $(".deleteData").click(function (e) {
          e.preventDefault(); // Mencegah perilaku default saat tombol diklik

          Swal.fire({
            title: "Apakah Anda yakin ingin menghapus?",
            text: "Data tidak bisa di kembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
          }).then((result) => {
            // Hapus data jika menekan ya, hapus!
            if (result.isConfirmed) {
              Swal.fire("BERHASIL", "Data berhasil di hapus.", "success");

              $.ajax({
                type: "post",
                url: "ajax/" + $(this).attr("href"), // Mendapatkan URL aksi saat tombol diklik
                success: function () {
                  getData(); // Memanggil fungsi getData setelah data berhasil dihapus
                },
              });
            }
          });
        });
      },
    });

    // Panggil function getFullYear()
    getFullYear();
  }

  $("#updatePelajar")
    .modal({
      keyboard: true,
      // backdrop: "static",
      show: false,
    })
    .on("show.bs.modal", function (event) {
      let button = $(event.relatedTarget); // Mendapatkan elemen yang memicu acara "show.bs.modal"
      let id_tabungan = $(event.relatedTarget)
        .closest("tr")
        .find("td:eq(0)")
        .text(); // Mendapatkan ID tabungan dari elemen terkait
      let email = $(event.relatedTarget).closest("tr").find("td:eq(2)").text(); // Mendapatkan email dari elemen terkait
      let nama_lengkap = $(event.relatedTarget)
        .closest("tr")
        .find("td:eq(3)")
        .text(); // Mendapatkan nama lengkap dari elemen terkait
      let jenis_kelamin = $(event.relatedTarget)
        .closest("tr")
        .find("td:eq(4)")
        .text(); // Mendapatkan jenis kelamin dari elemen terkait
      let kelas = $(event.relatedTarget).closest("tr").find("td:eq(5)").text(); // Mendapatkan kelas dari elemen terkait
      let angkatan = $(event.relatedTarget)
        .closest("tr")
        .find("td:eq(6)")
        .text(); // Mendapatkan angkatan dari elemen terkait
      let status = $(event.relatedTarget).closest("tr").find("td:eq(7)").text(); // Mendapatkan status dari elemen terkait
      let saldo = $(event.relatedTarget).closest("tr").find("td:eq(8)").text(); // Mendapatkan saldo dari elemen terkait

      // Set dan update size untuk dropdown
      let dropdownGender = "";
      let updateStringStatus = "";
      let dropdownStatus = "";
      let limitSizeString_Aktif = 82;
      let limitSizeString_TidakAktif = 88;

      if (jenis_kelamin == "laki laki") {
        dropdownGender += "perempuan";
      } else if (jenis_kelamin == "perempuan") {
        dropdownGender += "laki laki";
      }

      if (status.length == limitSizeString_Aktif) {
        updateStringStatus += "aktif";
        dropdownStatus += "tidak aktif";
      } else if (status.length == limitSizeString_TidakAktif) {
        updateStringStatus += "tidak aktif";
        dropdownStatus += "aktif";
      }

      $(this)
        .find("#modal-update")
        .html(
          $(`<!-- Form update -->
<form method="post" action="updateData.php" id="form_update_pelajar">

<div class="mb-3">
  <label for="id_tabungan" class="form-label d-none">-</label>
  <input type="text" class="form-control d-none" id="id_tabungan" name="id_tabungan" autocomplete='off' value="${id_tabungan}" required/>
</div>

<div class="mb-3">
  <label for="email" class="form-label">Email</label>
  <input type="email" class="form-control" id="email" name="email" autocomplete='off' value="${email}" required/>
</div>

<div class="mb-3">
  <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
  <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" autocomplete='off' value="${nama_lengkap}" required/>
</div>

<div class="mb-3">
  <label for="kelas" class="form-label">Kelas</label>
  <input type="text" class="form-control" id="kelas" name="kelas" autocomplete='off' value="${kelas}" required/>
</div>

<div class="mb-3">
  <label for="saldo" class="form-label">Saldo</label>
  <input type="text" class="form-control saldo" id="saldo" name="saldo" autocomplete="off" value="${saldo}"/>
</div>

<div class="mb-3">
  <label for="angkatan" class="form-label">Angkatan</label>
  <select class="form-select angkatan" id="angkatan" name="angkatan">
      <option value="${angkatan}">${angkatan}</option>
  </select>
</div>

<div class="mb-3">
  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
  <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
      <option value="${jenis_kelamin}">${jenis_kelamin}</option>
      <option value="${dropdownGender}">${dropdownGender}</option>   
  </select>
</div>

<div class="mb-3">
  <label for="status" class="form-label">Status</label>
  <select class="form-select" id="status" name="status">
      <option value="${updateStringStatus}">${updateStringStatus}</option>
      <option value="${dropdownStatus}">${dropdownStatus}</option>
  </select>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
  <button type="submit" class="btn btn-warning" name="update" id="update">Update</button>
</div>
</form>
<!-- </Akhir form update -->`)
        );

      // Panggil function getFullYear()
      getFullYear();

      // Ubah titik pada value saldo update
      $(".updateData").click(function (e) {
        e.preventDefault(); // Mencegah perilaku default saat tombol diklik

        let saldoInput = $(".saldo");
        let valueSaldo = saldoInput.val();
        let newValueSaldo = valueSaldo.replace(/\./g, "");
        saldoInput.val(newValueSaldo);
      });

      $("#form_update_pelajar").on("submit", function (e) {
        e.preventDefault(); // Mencegah perilaku default saat form disubmit

        let formUpdate = $(this); // Menyimpan referensi form saat ini
        let formDataUpdate = new FormData(formUpdate[0]);

        $.ajax({
          type: "post", // Mendapatkan metode form (POST)
          url: path + formUpdate.attr("action"), // Mendapatkan URL aksi form
          data: formDataUpdate, // Menggunakan objek FormData sebagai data form
          dataType: "json",
          processData: false,
          contentType: false,
          success: function (response) {
            getData(); // Memanggil fungsi getData setelah data berhasil ditambahkan

            // Response update JSON dari backend
            let messageResponseUpdate = response.message;

            // Jika response berhasil
            if (response.success) {
              // Kosongkan field text, number, email, option selected dan tutup modal setelah berhasil di insert
              $("[type=text], [type=number], [type=email]").val("");
              $("option:selected").prop("selected", false);
              $(".hidden-update-pelajar").modal("hide");

              // Beri response
              Swal.fire("BERHASIL", messageResponseUpdate, "success");
            } else {
              // Response gagal, tampilkan pesan kesalahan ketika terjadi kesalahan pada backend web aplikasi
              Swal.fire("GAGAL", messageResponseUpdate, "error");
            }
          },
          // error: function(xhr, textStatus, errorThrown) {
          //     console.log("Error status:", xhr.status);
          //     console.log("Error message:", xhr.responseText);
          //     console.log("Error type:", textStatus);
          //     console.log("Error thrown:", errorThrown);
          // }
        });
      });
    });
});
