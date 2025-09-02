<div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-[100] hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform transition-transform duration-300 scale-95 md:scale-100">
        <h2 id="modal-title" class="text-2xl font-bold text-gray-800 mb-6">Tambah Ekstrakurikuler Baru</h2>
        <form id="extracurricular-form" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Ekstrakurikuler</label>
                <input type="text" id="name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="category" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Pilih Kategori</option>
                    <option value="olahraga">Olahraga</option>
                    <option value="seni">Seni</option>
                    <option value="sains">Sains</option>
                    <option value="bahasa">Bahasa</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" rows="3" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>
            <div>
                <label for="instructor" class="block text-sm font-medium text-gray-700">Pembimbing</label>
                <input type="text" id="instructor" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="schedule" class="block text-sm font-medium text-gray-700">Jadwal</label>
                <input type="text" id="schedule" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" id="close-modal" class="py-2 px-4 rounded-lg text-gray-600 bg-gray-200 hover:bg-gray-300 transition duration-300 font-semibold">Batal</button>
                <button type="submit" id="submit-button" class="py-2 px-4 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition duration-300">Simpan</button>
            </div>
        </form>
    </div>
</div>
