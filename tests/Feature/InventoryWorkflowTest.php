<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_must_login_before_accessing_inventory(): void
    {
        $this->get('/products')->assertRedirect(route('login'));
    }

    public function test_regular_user_can_view_inventory_but_cannot_manage_master_products(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/products')->assertOk();
        $this->actingAs($user)->get('/products/create')->assertForbidden();
        $this->actingAs($user)->post('/categories', ['nama_kategori' => 'Terlarang'])->assertForbidden();
    }

    public function test_stock_in_and_out_are_recorded_and_stock_cannot_become_negative(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['nama_kategori' => 'Elektronik']);
        $product = Product::create([
            'category_id' => $category->id,
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Laptop',
            'harga' => 7000000,
        ]);

        $this->actingAs($user)->post('/stock', [
            'product_id' => $product->id,
            'jenis' => 'masuk',
            'jumlah' => 10,
            'keterangan' => 'Stok awal',
        ])->assertRedirect(route('stock.index'));

        $this->assertSame(10, (int) $product->fresh()->stok);

        $this->post('/stock', [
            'product_id' => $product->id,
            'jenis' => 'keluar',
            'jumlah' => 4,
        ])->assertRedirect(route('stock.index'));

        $this->assertSame(6, (int) $product->fresh()->stok);

        $this->from('/stock')->post('/stock', [
            'product_id' => $product->id,
            'jenis' => 'keluar',
            'jumlah' => 7,
        ])->assertSessionHasErrors('jumlah');

        $this->assertSame(6, (int) $product->fresh()->stok);
        $this->assertDatabaseCount('stock_movements', 2);
    }

    public function test_product_stok_cannot_be_changed_through_master_product_form(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $category = Category::create(['nama_kategori' => 'Elektronik']);
        $product = Product::create([
            'category_id' => $category->id,
            'kode_barang' => 'BRG-002',
            'nama_barang' => 'Monitor',
            'harga' => 2000000,
        ]);

        $this->actingAs($admin)->put('/products/'.$product->id, [
            'category_id' => $category->id,
            'kode_barang' => 'BRG-002',
            'nama_barang' => 'Monitor Baru',
            'harga' => 2500000,
            'stok' => 900,
        ])->assertRedirect(route('products.index'));

        $this->assertSame(0, (int) $product->fresh()->stok);
    }

    public function test_product_with_stock_cannot_be_archived(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $category = Category::create(['nama_kategori' => 'Peralatan']);
        $product = Product::create([
            'category_id' => $category->id,
            'kode_barang' => 'BRG-003',
            'nama_barang' => 'Kursi',
            'harga' => 300000,
        ]);
        $product->forceFill(['stok' => 5])->save();

        $this->actingAs($admin)->delete('/products/'.$product->id)->assertSessionHasErrors('product');
        $this->assertNotSoftDeleted('products', ['id' => $product->id]);
    }
}
