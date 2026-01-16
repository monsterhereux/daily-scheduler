<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @isset($date)
                Aktivitas tanggal {{ $date }}
            @else
                Semua Aktivitas
            @endisset
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔔 NOTIFIKASI SUKSES --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- LIST AKTIVITAS --}}
            {{-- MODAL EDIT AKTIVITAS --}}
<div id="editModal"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded w-96 relative">

        {{-- CLOSE --}}
        <button onclick="closeEditModal()"
                class="absolute top-2 right-2 text-xl text-gray-500">&times;</button>

        <h3 class="font-bold text-lg mb-4">Edit Aktivitas</h3>

        <input type="hidden" id="edit_id">

        <input id="edit_title"
               class="w-full mb-2 border p-2"
               placeholder="Judul">

        <select id="edit_priority" class="w-full mb-2 border p-2">
            <option value="Low">Mudah</option>
            <option value="Medium">Sedang</option>
            <option value="High">Sulit</option>
        </select>

        <textarea id="edit_description"
                  class="w-full mb-2 border p-2"
                  placeholder="Keterangan"></textarea>

        <input type="datetime-local"
               id="edit_start_at"
               class="w-full mb-2 border p-2">

        <input type="datetime-local"
               id="edit_end_at"
               class="w-full mb-4 border p-2">

        <button id="btnSubmitEdit"
        type="button"
        class="w-full bg-blue-600 text-white py-2 rounded">
    Simpan Perubahan
</button>

    </div>
</div>

            @forelse ($activities as $activity)
                <div class="bg-white p-4 rounded shadow mb-4">

                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-lg">
                                {{ $activity->title }}
                            </h3>

                            {{-- PRIORITAS --}}
                            <p class="text-sm text-gray-500">
                                Prioritas:
                                <span class="font-semibold">
                                    {{ $activity->priority }}
                                </span>
                            </p>

                            {{-- WAKTU --}}
                            <p class="text-sm text-gray-400">
                                {{ $activity->start_at }} - {{ $activity->end_at }}
                            </p>
                        </div>

                        {{-- STATUS --}}
                        <span class="px-2 py-1 text-sm rounded
                            {{ $activity->is_done
                                ? 'bg-green-200 text-green-800'
                                : 'bg-yellow-200 text-yellow-800' }}">
                            {{ $activity->is_done ? 'Selesai' : 'Belum selesai' }}
                        </span>
                    </div>

                    {{-- DESKRIPSI --}}
                    @if($activity->description)
                        <p class="mt-2 text-gray-700">
                            {{ $activity->description }}
                        </p>
                    @endif
{{-- AKSI --}}
<div class="flex gap-2 mt-4">

    {{-- EDIT (SELALU ADA) --}}
    <button
        onclick="openEditModal(
            {{ $activity->id }},
            '{{ $activity->title }}',
            '{{ $activity->priority }}',
            '{{ $activity->description }}',
            '{{ $activity->start_at->format('Y-m-d\TH:i') }}',
            '{{ $activity->end_at->format('Y-m-d\TH:i') }}'
        )"
        class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-sm">
        Edit
    </button>

    {{-- HAPUS (SELALU ADA) --}}
    <form method="POST"
          action="{{ route('activities.destroy', $activity) }}"
          onsubmit="return confirm('Yakin hapus aktivitas ini?')">
        @csrf
        @method('DELETE')

        <button
            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
            Hapus
        </button>
    </form>

    {{-- TANDAI SELESAI (HANYA JIKA BELUM) --}}
    @if(!$activity->is_done)
        <form method="POST"
              action="{{ route('activities.done', $activity) }}">
            @csrf
            @method('PATCH')

            <button
                class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                Tandai Selesai
            </button>
        </form>
    @endif

</div>
                </div>
            @empty
                <p class="text-gray-500">Tidak ada aktivitas.</p>
            @endforelse

        </div>
    </div>
    
</x-app-layout>
