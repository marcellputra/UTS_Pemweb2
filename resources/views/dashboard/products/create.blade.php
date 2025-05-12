<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Tambah Produk Baru</flux:heading>
        <flux:subheading size="lg" class="mb-6 text-muted">Lengkapi data berikut untuk menambahkan produk ke sistem</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">{{ session('successMessage') }}</flux:badge>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">{{ session('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input label="Nama Produk" name="name" placeholder="Contoh: Kipas Angin Tornado" />

            <flux:input label="Slug" name="slug" placeholder="contoh-produk" />
        </div>

        <flux:textarea label="Deskripsi" name="description" class="text-white" placeholder="Masukkan detail deskripsi produk..." />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <flux:input label="SKU" name="sku" placeholder="SKU12345" />

            <flux:input label="Harga" name="price" type="number" step="0.01" placeholder="100000" />

            <flux:input label="Stok" name="stock" type="number" placeholder="50" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Upload Gambar -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl">
                <label for="image" class="block text-sm font-semibold mb-1 text-white">Upload Gambar</label>
                <input type="file" id="image" name="image" class="w-full file:bg-blue-500 file:text-white file:rounded file:px-4 file:py-1 file:border-0" />
                <p class="text-xs text-muted mt-1">Pilih file gambar produk jika tersedia</p>
            </div>

            <!-- URL Gambar -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl">
                <label for="image_url" class="block text-sm font-semibold mb-1 text-white">URL Gambar</label>
                <input type="url" id="image_url" name="image_url" class="w-full rounded border px-3 py-2" placeholder="https://example.com/gambar.jpg" />
                <p class="text-xs text-muted mt-1">Atau masukkan URL gambar dari internet</p>
            </div>
        </div>

        <flux:switch label="Aktifkan Produk?" name="is_active" class="mt-4" checked />

        <flux:select label="Kategori" name="product_category_id" class="mb-3">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </flux:select>

        <flux:separator />

        <div class="mt-4 flex items-center gap-3">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>
