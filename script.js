window.onload = function () {
    fetch("api/get_data.php")
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                document.getElementById("namaDisplay").innerText =
                    "Nama: " + data.data.nama;
                document.getElementById("NIMDisplay").innerText =
                    "NIM: " + data.data.nim;
            }
        })
        .catch(() => console.log("Belum ada data tersimpan."));
};

function simpan() {
    const nama = document.getElementById("namaInput").value;
    const NIM  = document.getElementById("NIMInput").value;
    const pesan = document.getElementById("pesan");

    // Validasi sisi client (tetap dipertahankan)
    if (nama === "" && NIM === "") {
        tampilPesan("Nama & NIM tidak boleh kosong!", "red");
        return;
    } else if (nama === "") {
        tampilPesan("Nama tidak boleh kosong!", "red");
        return;
    } else if (NIM === "") {
        tampilPesan("NIM tidak boleh kosong!", "red");
        return;
    }

    // Kirim ke PHP via FormData
    const formData = new FormData();
    formData.append("nama", nama);
    formData.append("nim", NIM);

    fetch("api/simpan.php", {
        method: "POST",
        body: formData,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                document.getElementById("namaDisplay").innerText =
                    "Nama: " + data.data.nama;
                document.getElementById("NIMDisplay").innerText =
                    "NIM: " + data.data.nim;
                tampilPesan(data.message, "green");
            } else {
                tampilPesan(data.message, "red");
            }
        })
        .catch(() => tampilPesan("Terjadi kesalahan koneksi!", "red"));
}

function tampilPesan(teks, warna) {
    const pesan = document.getElementById("pesan");
    pesan.innerText = teks;
    pesan.style.color = warna;
}

function ubahTema() {
    document.body.classList.toggle("dark");
}