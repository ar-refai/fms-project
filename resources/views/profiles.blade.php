<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profiles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($clients as $client)
                        <div class="grid grid-cols-2 bg-gray-100 rounded-lg shadow-md p-4transition dark:bg-gray-700 hover:shadow-lg">
                            <div class="px-4 py-2">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                                    {{ $client->client_name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Type: {{ ucfirst($client->client_type) }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Source: {{ $client->client_source }}
                                </p>
                                <a href="{{ route('profiles.show', $client->id) }}"
                                class="inline-block px-2 py-1 mt-4 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                    View Profile
                                </a>
                            </div>
                            <div class="px-2 py-2">
                                <img src="{{asset('images/profile.png')}}" alt="profile-image"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
