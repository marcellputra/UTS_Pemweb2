<x-layouts.app :title="__('Edit Product')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Edit Produk</flux:heading>
        <flux:subheading size="lg" class="mb-6 text-muted">Perbarui informasi produk di bawah ini</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">{{ session('successMessage') }}</flux:badge>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">{{ session('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input label="Nama Produk" name="name" value="{{ old('name', $product->name) }}" />

            <flux:input label="Slug" name="slug" value="{{ old('slug', $product->slug) }}" />
        </div>

        <flux:textarea label="Deskripsi" name="description" class="text-white">
            {{ old('description', $product->description) }}
        </flux:textarea>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <flux:input label="SKU" name="sku" value="{{ old('sku', $product->sku) }}" />

            <flux:input label="Harga" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" />

            <flux:input label="Stok" name="stock" type="number" value="{{ old('stock', $product->stock) }}" />
        </div>

        {{-- Preview Gambar --}}
        @if($product->image_url)
            <div class="mb-3">
                <p class="text-sm text-gray-500 mb-1">Gambar Saat Ini:</p>
                <img src="{{ $product->image_url }}" alt="Product Image" class="w-24 h-24 object-cover rounded border">
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Upload Gambar -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl">
                <label for="image" class="block text-sm font-semibold mb-1 text-white">Upload Gambar Baru</label>
                <input type="file" id="image" name="image" class="w-full file:bg-blue-500 file:text-white file:rounded file:px-4 file:py-1 file:border-0" />
                <p class="text-xs text-muted mt-1">Pilih file gambar baru jika ingin mengganti.</p>
            </div>

            <!-- URL Gambar -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl">
                <label for="image_url" class="block text-sm font-semibold mb-1 text-white">URL Gambar</label>
                <input type="url" id="image_url" name="image_url" class="w-full rounded border px-3 py-2"
                    value="{{ old('image_url', $product->image_url) }}"
                    placeholder="https://example.com/gambar.jpg" />
                <p class="text-xs text-muted mt-1">Atau masukkan URL gambar dari internet.</p>
            </div>
        </div>

        <flux:switch label="Aktifkan Produk?" name="is_active" :checked="(bool) old('is_active', $product->is_active)" />
        
        <flux:select label="Category" name="product_category_id" class="mb-3">
            <option value="">-- Select Category --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </flux:select>
        <flux:separator />

        <div class="mt-4 flex items-center gap-3">
            <flux:button type="submit" variant="primary">Perbarui</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost">Batal</flux:link>
        </div>
    </form>
</x-layouts.app>
