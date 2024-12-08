<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Import Data
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="file">Select Excel File</label>
                            <input type="file" name="file" id="file" class="mt-2">
                        </div>
                        <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">
                            Import
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
