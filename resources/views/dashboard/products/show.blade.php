<x-layouts.app :title="__('Product Details')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Detail Produk</flux:heading>
        <flux:subheading size="lg" class="mb-6 text-muted">Informasi lengkap produk</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Gambar Produk -->
        <div class="flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-800 p-4 rounded-xl shadow">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-48 h-48 object-cover rounded-lg mb-3 shadow-lg">
            @else
                <div class="w-48 h-48 flex items-center justify-center bg-gray-300 rounded-lg text-gray-600">
                    No Image
                </div>
            @endif
            <p class="text-sm text-gray-500 mt-2">Gambar Produk</p>
        </div>

        <!-- Informasi Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Nama Produk</p>
                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $product->name }}</p>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Slug</p>
                <p class="text-base text-gray-900 dark:text-white">{{ $product->slug }}</p>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">SKU</p>
                <p class="text-base text-gray-900 dark:text-white">{{ $product->sku }}</p>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Harga</p>
                <p class="text-base text-gray-900 dark:text-white">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Stok</p>
                <p class="text-base text-gray-900 dark:text-white">{{ $product->stock }}</p>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Kategori</p>
                <p class="text-base text-gray-900 dark:text-white">{{ $product->category->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Status</p>
                @if($product->is_active)
                    <flux:badge color="lime">Aktif</flux:badge>
                @else
                    <flux:badge color="red">Nonaktif</flux:badge>
                @endif
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Dibuat Pada</p>
                <p class="text-base text-gray-900 dark:text-white">{{ $product->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Deskripsi Produk -->
    <div class="mb-6">
        <p class="text-sm font-semibold text-gray-600 mb-1">Deskripsi</p>
        <div class="bg-white dark:bg-gray-900 border rounded-lg p-4 whitespace-pre-line text-gray-800 dark:text-gray-300 shadow-sm">
            {{ $product->description }}
        </div>
    </div>

    <div class="mt-6">
        <flux:link href="{{ route('products.index') }}" variant="ghost">← Kembali ke Daftar Produk</flux:link>
    </div>
</x-layouts.app>
