<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📅 Dashboard Aktivitas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- NOTIFIKASI (JS) --}}
            <div id="successAlert"
                 class="hidden mb-4 p-3 bg-green-100 text-green-700 rounded">
            </div>

            {{-- RINGKASAN --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">📅 Hari ini</p>
                    <p class="text-2xl font-bold">{{ $today }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">⏳ Belum selesai</p>
                    <p class="text-2xl font-bold">{{ $pending }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">✅ Selesai</p>
                    <p class="text-2xl font-bold">{{ $done }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">🔜 Mendatang</p>
                    <p class="text-2xl font-bold">{{ $upcoming }}</p>
                </div>
            </div>

            {{-- KALENDER --}}
                <div id="calendar" style="min-height:600px;"></div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
<div id="activityModal"
     class="hidden fixed inset-0 bg-gradient-to-br from-black/40 to-black/60 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-2xl w-96 relative shadow-2xl transform transition-all duration-300">
        <!-- Close Button -->
        <button id="closeModal"
                type="button"
                class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl transition">
            &times;
        </button>

        <!-- Choice Mode -->
        <div id="choiceMode" class="hidden">
            <h2 class="text-lg font-bold mb-4 text-indigo-600">Aktivitas sudah ada</h2>
            <button id="btnEdit"
                    class="w-full mb-2 bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg shadow transition">
                Lihat Aktivitas
            </button>
            <button id="btnAddNew"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg shadow transition">
                Tambah Aktivitas Baru
            </button>
        </div>

        <!-- Form Mode -->
        <div id="formMode">
            <h2 class="text-lg font-bold mb-4 text-indigo-600">Tambah Aktivitas</h2>

            <input id="title"
                   class="w-full mb-2 border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 p-2 rounded-md transition"
                   placeholder="Nama Aktivitas">

            <select id="priority"
        class="w-full mb-3 border border-gray-300 
               focus:border-indigo-500 focus:ring focus:ring-indigo-200 
               p-2 rounded-lg shadow-sm bg-white text-gray-700 
               transition duration-200 ease-in-out">
    <option value="Low" class="text-green-600">Mudah</option>
    <option value="Medium" class="text-yellow-600">Sedang</option>
    <option value="High" class="text-red-600">Sulit</option>
</select>


            <textarea id="description"
                      class="w-full mb-2 border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 p-2 rounded-md transition"
                      placeholder="Keterangan"></textarea>

            <input type="time" id="start_time"
                   class="w-full mb-2 border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 p-2 rounded-md transition">
            <input type="time" id="end_time"
                   class="w-full mb-2 border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 p-2 rounded-md transition">

            <button id="saveActivity"
                    class="bg-gradient-to-r from-indigo-500 to-cyan-500 hover:from-indigo-600 hover:to-cyan-600 text-white py-2 rounded-lg w-full shadow-md transition">
                Simpan
            </button>
        </div>
    </div>
</div>

 @vite('resources/js/calendar.js')
</x-app-layout>
