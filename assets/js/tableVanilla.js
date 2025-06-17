document.addEventListener("DOMContentLoaded", function () {
    // Element-elemen DOM yang digunakan
    const tbody = document.getElementById("table-body");
    const pagination = document.getElementById("pagination");
    const searchInput = document.getElementById("searchInput");
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const dataUrl = document.getElementById("data-url").dataset.url;

    // Variabel-variabel utama
    let allData = []; // Semua data dari server
    let filteredData = []; // Data setelah difilter
    let currentPage = 1; // Halaman saat ini
    let pageSize = parseInt(rowsPerPageSelect.value); // Jumlah data per halaman
    const labels = Array.from(document.querySelectorAll("thead th")).map(th => th.textContent.trim());
 // Label untuk <td data-label="">
    let currentSort = {
        index: null,
        asc: true
    };

    // Ambil data dari server
    fetch(dataUrl)
        .then(res => res.json())
        .then(res => {
            allData = res.data || [];
            filteredData = [...allData];
            renderTable(filteredData);      // Tampilkan tabel
            renderPagination(filteredData); // Tampilkan pagination
        });

    // Fungsi untuk menampilkan tabel sesuai halaman
    function renderTable(data) {
        const start = (currentPage - 1) * pageSize;
        const end = start + pageSize;
        const pageData = data.slice(start, end);

        tbody.innerHTML = "";

        // Jika tidak ada data
        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; color:gray;">Tidak ada data ditemukan</td></tr>`;
            return;
        }

        // Render data ke dalam <tr>
        pageData.forEach(row => {
            const tr = document.createElement("tr");

            row.forEach((cell, index) => {
                const td = document.createElement("td");
                td.innerHTML = cell;
                td.setAttribute("data-label", labels[index]); // Untuk tampilan mobile
                tr.appendChild(td);
            });

            tbody.appendChild(tr);
        });
    }

    // Fungsi untuk membuat tombol pagination
    function renderPagination(data) {
        const pageCount = Math.ceil(data.length / pageSize);
        pagination.innerHTML = "";

        const maxVisiblePages = 3; // Jumlah tombol pagination yg terlihat
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = startPage + maxVisiblePages - 1;

        if (endPage > pageCount) {
            endPage = pageCount;
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // Tombol Prev
        const prevBtn = document.createElement("button");
        prevBtn.textContent = "← Prev";
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => {
            currentPage--;
            renderTable(filteredData);
            renderPagination(filteredData);
        };
        pagination.appendChild(prevBtn);

        // Tombol nomor halaman
        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.className = i === currentPage ? "active-page" : "";
            btn.onclick = () => {
                currentPage = i;
                renderTable(filteredData);
                renderPagination(filteredData);
            };
            pagination.appendChild(btn);
        }

        // Tombol Next
        const nextBtn = document.createElement("button");
        nextBtn.textContent = "Next →";
        nextBtn.disabled = currentPage === pageCount;
        nextBtn.onclick = () => {
            currentPage++;
            renderTable(filteredData);
            renderPagination(filteredData);
        };
        pagination.appendChild(nextBtn);
    }

    // Fungsi untuk memfilter data berdasarkan kata kunci
    function filterData(keyword) {
        return allData.filter(row =>
            row.some(cell =>
                cell.toLowerCase().includes(keyword.toLowerCase())
            )
        );
    }

    // Update tampilan tabel saat filter berubah
    function updateTable() {
        const keyword = searchInput.value;
        filteredData = filterData(keyword);
        currentPage = 1;
        renderTable(filteredData);
        renderPagination(filteredData);
    }

    // Fungsi untuk sorting kolom
    function sortTable(index) {
        const isAsc = currentSort.index === index ? !currentSort.asc : true;
        currentSort = {
            index,
            asc: isAsc
        };

        // Reset ikon sort sebelumnya
        document.querySelectorAll("th.sortable").forEach(th => {
            th.classList.remove("sorted-asc", "sorted-desc");
            th.querySelector(".sort-icon").textContent = "";
        });

        // Tambahkan ikon sort aktif pada kolom
        const th = document.querySelector(`th.sortable[data-index="${index}"]`);
        th.classList.add(isAsc ? "sorted-asc" : "sorted-desc");
        th.querySelector(".sort-icon").textContent = isAsc ? "▲" : "▼";

        // Proses sorting
        filteredData.sort((a, b) => {
            let valA = a[index].replace(/<[^>]+>/g, '').trim().toLowerCase();
            let valB = b[index].replace(/<[^>]+>/g, '').trim().toLowerCase();

            // Coba sorting numerik jika bisa
            if (!isNaN(valA) && !isNaN(valB)) {
                return isAsc ? valA - valB : valB - valA;
            }

            // Jika bukan angka, sorting string
            return isAsc ? valA.localeCompare(valB) : valB.localeCompare(valA);
        });

        currentPage = 1;
        renderTable(filteredData);
        renderPagination(filteredData);
    }

    // Event listener saat user mengetik di search box
    searchInput.addEventListener("input", updateTable);

    // Event saat jumlah baris per halaman diubah
    rowsPerPageSelect.addEventListener("change", () => {
        pageSize = parseInt(rowsPerPageSelect.value);
        currentPage = 1;
        updateTable();
    });

    // Tambahkan event klik ke semua <th> yang bisa disorting
    document.querySelectorAll("th.sortable").forEach(th => {
        th.addEventListener("click", function () {
            const index = parseInt(this.dataset.index);
            sortTable(index);
        });
    });
});
