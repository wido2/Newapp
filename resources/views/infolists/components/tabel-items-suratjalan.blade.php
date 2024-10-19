<x-dynamic-component :component="$getEntryWrapperView()">
    <div>
        {{ $getState() }}
    </div>


    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-grblack rtl:text-right dark:text-gray-400">
            <thead
                class="text-xs font-medium text-gray-700 uppercase bg-gray-50 font dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama Barang
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Quantity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Satuan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Keterangan
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($getRecord()->barangs as $item)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                            {{ $item->produk->nama }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->qty }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->satuan->nama }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->deskripsi }}
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <br>
    <hr class="my-8 h-px bg-gray-200 border-0 dark:bg-gray-700">
    </hr>


</x-dynamic-component>
