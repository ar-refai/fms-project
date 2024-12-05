<div id="recipients" class="p-8 mt-6 rounded shadow lg:mt-0">
    <table id="{{ $tableId }}" class="w-full text-sm text-left text-gray-900 stripe display rtl:text-right dark:text-gray-100"
        style="width:100%; padding-top: 1em; padding-bottom: 1em;">
        <thead class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-100">
            <tr>
                @foreach ($columns as $column)
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            {{ $column }}
                        </div>
                    </th>
                @endforeach
                @if ($actions ?? false)
                    <th scope="col" class="px-6 py-3 bg-gray-800">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr class="border-b dark:border-gray-700">
                    @foreach ($row as $key => $cell)
                        <td class="px-6 py-4">{{ $cell }}</td>
                    @endforeach
                    @if ($actions ?? false)
                        <td class="px-6 py-4 text-right">
                            @if ($editable ?? false)
                                <button
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    {{-- x-data --}}
                                    {{-- @click="$dispatch('open-modal', { --}}
                                    {{-- // json_encode($row) --}}
                                        {{-- name: 'edit-client' --}}
                                    {{-- })" --}}
                                    @click="$dispatch('open-modal', { name: 'edit-client' })">

                                    >
                                    Edit
                                </button>
                            @endif
                            @if ($deletable ?? false && isset($row['id']))
                                <button
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline"
                                    {{-- x-data --}}
                                    @click="$dispatch('open-modal', { name: 'delete-client' })"
                                >
                                    Delete
                                </button>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
