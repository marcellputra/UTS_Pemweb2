<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Daftar Produk</flux:heading>
        <flux:subheading size="lg" class="mb-6 text-muted">Kelola data produk</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-4">
        <form action="{{ route('products.index') }}" method="get" class="w-full md:w-1/2">
            <flux:input icon="magnifying-glass" name="q" value="{{ $q }}" placeholder="Cari produk..." />
        </form>
        <div>
            <flux:link href="{{ route('products.create') }}">
                <flux:button icon="plus">Tambah Produk</flux:button>
            </flux:link>
        </div>
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-4 block">{{ session('successMessage') }}</flux:badge>
    @endif

    <div class="overflow-x-auto rounded-lg shadow border">
        <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left text-xs font-semibold text-gray-600 uppercase">
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Gambar</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Dibuat</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-900 font-bold bg-gray-100 rounded">{{ $product->id }}</td>
                        <td class="px-4 py-3">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded-full border mx-auto">
                            @else
                                <div class="h-10 w-10 flex items-center justify-center bg-gray-200 text-gray-500 rounded-full mx-auto">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ Str::limit($product->description, 50) }}</td>
                        <td class="px-4 py-3 text-gray-900 font-semibold">Rp {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-gray-900 font-semibold">{{ $product->stock }}</td>
                        <td class="px-4 py-3 text-gray-900 font-semibold">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($product->is_active)
                                <div class="text-center">
                                    <div class="text-sm font-semibold text-black mb-1">Aktif</div>
                                    <flux:badge color="lime" class="text-gray-900 font-bold py-1 px-3 rounded-full"> </flux:badge>
                                </div>
                            @else
                                <div class="text-center">
                                    <div class="text-sm font-semibold text-black mb-1">Nonaktif</div>
                                    <flux:badge color="red" class="text-white font-bold py-1 px-3 rounded-full"> </flux:badge>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-900 font-semibold">{{ $product->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down" size="sm">Aksi</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="eye" href="{{ route('products.show', $product->id) }}">Lihat</flux:menu.item>
                                    <flux:menu.item icon="pencil" href="{{ route('products.edit', $product->id) }}">Edit</flux:menu.item>
                                    <flux:menu.item icon="trash" variant="danger"
                                        onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus produk ini?')) document.getElementById('delete-form-{{ $product->id }}').submit();">
                                        Hapus
                                    </flux:menu.item>
                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</x-layouts.app>
