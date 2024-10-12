<html lang="en">
<head>
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div>
        <h5>
            {{$record->nomor_po}}
        </h5>
    </div>
    <div class="overflow-x-auto relative">
        <table class="px-6 w-full text-xs text-left text-grblack rtl:text-right dark:text-gray-400">
            <thead class="text-xs font-medium text-gray-700 uppercase bg-gray-50 font dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-2">
                        Nama Barang
                    </th>
                    <th scope="col" class="px-6 py-2">
                        Quantity
                    </th>
                    <th scope="col" class="px-6 py-2">
                        Satuan
                    </th>
                    <th scope="col" class="px-6 py-2">
                        Harga
                    </th>
                    <th scope="col" class="px-6 py-2">
                        Discount
                    </th>
                    <th scope="col" class="px-6 py-2">
                        Subtotal
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->items as $item)
    
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-1 font-medium whitespace-nowrap dark:text-white">
                        {{ $item->produk->nama }}
                    </th>
                    <td class="px-6 py-1 text-center">
                        {{ $item->quantity }}
                    </td>
                    <td class="px-6 py-1">
                        {{ $item->satuan->nama }}
                    </td>
                    <td class="px-6 py-1">
                        {{ 'Rp. '.number_format($item->price,0,'.',',')}}
                    </td>
                    <td class="px-6 py-1">
                        {{ 'Rp. '.number_format($item->discount,0,'.',',')}}
                    </td>
                    <td class="px-6 py-1 text-bold">
                        {{ 'Rp. '.number_format($item->subtotal,0,'.',',')}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
       
   
    
    <div class="flex">
        <div class="flex-1 px-2 py-2 w-2/3">
            <table class="overflow-x-auto">
                <tbody><tr>Catatan : </tr>
                    <tr class="text-xs text-justify">
                        <td>{!!html_entity_decode($record->note)!!}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex-1 w-1/3 max-w-md" >
            
    
    
    
    <div class="overflow-x-auto relative">
        <table class="w-full text-sm text-left text-black rtl:text-right dark:text-gray-400">
            
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Total Untaxed
                    </th>
                    <td class="px-2 py-1">
                        Rp. {{number_format($record->total_po,0,'.','.')}}
                    </td>
                 
                    
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        PPN 
                    </th>
                    <td class="px-2 py-1">
                        Rp. {{number_format($record->ppn,0,'.','.')}}
                    </td>
                   
                  
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800">
                    <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Diskon
                    </th>
                    <td class="px-2 py-1">
                        Rp. {{number_format($record->diskon,0,'.','.')}}
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800">
                    <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Biaya Pengiriman
                    </th>
                    <td class="px-2 py-1">
                        Rp. {{number_format($record->biaya_kirim,0,'.','.')}}
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800">
                    <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Total Bayar
                    </th>
                    <td class="px-2 py-2">
                        Rp. {{number_format($record->total_bayar,0,'.','.')}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    
    
</body>
</html>