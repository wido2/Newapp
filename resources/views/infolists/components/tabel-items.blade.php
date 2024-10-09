<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        {{ $getState() }}
    </div>


<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs font-medium text-gray-700 uppercase bg-gray-50 font dark:bg-gray-700 dark:text-gray-400">
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
                    Harga
                </th>
                <th scope="col" class="px-6 py-3">
                    Discount
                </th>
                <th scope="col" class="px-6 py-3">
                    Subtotal
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($getRecord()->items as $item)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->produk->nama }}
                </th>
                <td class="px-6 py-4">
                    {{ $item->quantity }}
                </td>
                <td class="px-6 py-4">
                    {{ $item->satuan->nama }}
                </td>
                <td class="px-6 py-4">
                    {{ 'Rp. '.number_format($item->price,0,'.',',')}}
                </td>
                <td class="px-6 py-4">
                    {{ 'Rp. '.number_format($item->discount,0,'.',',')}}
                </td>
                <td class="px-6 py-4">
                    {{ 'Rp. '.number_format($item->subtotal,0,'.',',')}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
   
<br>
<hr class="my-8 h-px bg-gray-200 border-0 dark:bg-gray-700"></hr>


<div class="flex">
    <div class="flex-1 w-14 ...">
      
    </div>
    <div class="flex-1 w-64 ...">
      
    </div>
    <div class="flex-1 w-32 ...">
        



<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Total Untaxed
                </th>
                <td class="px-6 py-4">
                    Rp. {{number_format($getRecord()->total_po,0,'.','.')}}
                </td>
             
                
            </tr>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    PPN 
                </th>
                <td class="px-6 py-4">
                    Rp. {{number_format($getRecord()->ppn,0,'.','.')}}
                </td>
               
              
            </tr>
            <tr class="bg-white dark:bg-gray-800">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Diskon
                </th>
                <td class="px-6 py-4">
                    Rp. {{number_format($getRecord()->diskon,0,'.','.')}}
                </td>
            </tr>
            <tr class="bg-white dark:bg-gray-800">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Biaya Pengiriman
                </th>
                <td class="px-6 py-4">
                    Rp. {{number_format($getRecord()->biaya_kirim,0,'.','.')}}
                </td>
            </tr>
            <tr class="bg-white dark:bg-gray-800">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Total Bayar
                </th>
                <td class="px-6 py-4">
                    Rp. {{number_format($getRecord()->total_bayar,0,'.','.')}}
                </td>
            </tr>
        </tbody>
    </table>
</div>




        
    </div>
  </div>
    
</x-dynamic-component>
