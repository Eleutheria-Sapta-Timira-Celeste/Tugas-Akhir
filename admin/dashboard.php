<main class="p-6">
    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-500 text-white p-4 rounded shadow">
            <h3 class="font-bold">PENERIMAAN KAS</h3>
            <p>Hari Ini: Rp. 0</p>
            <p>Bulan Ini: Rp. 0</p>
            <p>Tahun Ini: Rp. 2.250.000</p>
        </div>
        <div class="bg-red-500 text-white p-4 rounded shadow">
            <h3 class="font-bold">PENGELUARAN KAS</h3>
            <p>Hari Ini: Rp. 0</p>
            <p>Bulan Ini: Rp. 0</p>
            <p>Tahun Ini: Rp. 17.210.000</p>
        </div>
        <div class="bg-green-600 text-white p-4 rounded shadow">
            <h3 class="font-bold">PEMBAYARAN SISWA</h3>
            <p>Hari Ini: Rp. 0</p>
            <p>Bulan Ini: Rp. 0</p>
            <p>Tahun Ini: Rp. 250.000</p>
        </div>
        <div class="bg-orange-400 text-white p-4 rounded shadow">
            <h3 class="font-bold">TABUNGAN SISWA</h3>
            <p>Hari Ini: Rp. 0</p>
            <p>Bulan Ini: Rp. 0</p>
            <p>Tahun Ini: Rp. 500.000</p>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow overflow-x-auto">
        <h3 class="text-lg font-semibold mb-4">Realisasi Akun Pembayaran</h3>

        <div class="flex gap-4 mb-4 flex-wrap">
            <select class="border p-2 rounded">
                <option>2024/2025</option>
            </select>
            <select class="border p-2 rounded">
                <option>Juli</option>
            </select>
            <select class="border p-2 rounded">
                <option>Juni</option>
            </select>
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
            <button class="bg-green-600 text-white px-4 py-2 rounded">Export XLS</button>
        </div>

        <table class="w-full text-sm text-left border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">Unit</th>
                    <th class="p-2 border">Akun Pembayaran</th>
                    <th class="p-2 border">Tagihan</th>
                    <th class="p-2 border">Terbayar</th>
                    <th class="p-2 border">Belum Terbayar</th>
                    <th class="p-2 border">Pencapaian</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-green-100">
                    <td class="p-2 border">TK</td>
                    <td class="p-2 border">SPP TK TK</td>
                    <td class="p-2 border">Rp 4.800.000</td>
                    <td class="p-2 border">Rp 100.000</td>
                    <td class="p-2 border">Rp 4.700.000</td>
                    <td class="p-2 border">2.1%</td>
                </tr>
            </tbody>
        </table>
    </div>
</main>
