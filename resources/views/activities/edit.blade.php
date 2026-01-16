<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Aktivitas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- Form edit activity --}}
                <form action="{{ route('activities.update', $activity->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" id="title" name="title"
                               value="{{ old('title', $activity->title) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas</label>
                        <input type="text" id="priority" name="priority"
                               value="{{ old('priority', $activity->priority) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea id="description" name="description"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $activity->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="start_at" class="block text-sm font-medium text-gray-700">Mulai</label>
                        <input type="datetime-local" id="start_at" name="start_at"
                               value="{{ old('start_at', $activity->start_at->format('Y-m-d\TH:i')) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="end_at" class="block text-sm font-medium text-gray-700">Selesai</label>
                        <input type="datetime-local" id="end_at" name="end_at"
                               value="{{ old('end_at', $activity->end_at->format('Y-m-d\TH:i')) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                        <a href="{{ route('activities.byDate', $activity->start_at->toDateString()) }}"
                           class="text-gray-600 hover:text-gray-900">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
