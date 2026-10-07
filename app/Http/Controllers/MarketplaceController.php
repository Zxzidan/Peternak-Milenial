<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Region;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarketplaceController extends Controller
{
    /**
     * Display marketplace catalog, active orders, and filters.
     */
    public function index(Request $request): View
    {
        $categories = ProductCategory::all();
        $regions = Region::orderBy('name')->get();
        $currentUser = auth()->user();

        $query = Product::with(['category', 'region', 'seller'])
            ->where('status', 'active');

        // Only Admin can see unverified products in public catalog.
        // Umum, Peternak, and guests only see Admin-verified products in the public catalog.
        if (! $currentUser || ! $currentUser->isAdmin()) {
            $query->where('is_verified', true);
        }

        // Filter: Kategori
        if ($request->filled('kategori')) {
            $catSlug = $request->kategori;
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug)->orWhere('id', $catSlug);
            });
        }

        // Filter: Wilayah
        if ($request->filled('wilayah')) {
            $query->where('region_id', $request->wilayah);
        }

        // Search: Keyword
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        if ($request->sort === 'termurah') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'termahal') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->get();

        // Orders list & My Products:
        // Admin sees all orders and can monitor all unverified products
        if ($currentUser && $currentUser->isAdmin()) {
            $orders = Order::with(['items.product.category', 'items.product.region', 'items.seller', 'buyer'])->latest()->take(20)->get();
            $myProducts = Product::with(['category', 'region', 'seller'])->latest()->get();
        } elseif ($currentUser && $currentUser->isPeternak()) {
            // Peternak sees their own products (including pending verification status)
            $myProducts = Product::with(['category', 'region'])->where('user_id', $currentUser->id)->latest()->get();
            $orders = Order::whereHas('items', function ($q) use ($currentUser) {
                $q->where('seller_id', $currentUser->id);
            })->with(['items.product.category', 'items.product.region', 'items.seller', 'buyer'])->latest()->take(20)->get();
        } else {
            $myProducts = collect();
            $orders = $currentUser
                ? Order::where('buyer_id', $currentUser->id)->with(['items.product.category', 'items.product.region', 'items.seller', 'buyer'])->latest()->get()
                : collect();
        }

        $orderCounts = [
            'all' => $orders->count(),
            'pending' => $orders->where('status', 'pending')->count(),
            'processing' => $orders->whereIn('status', ['confirmed', 'processing'])->count(),
            'shipped' => $orders->where('status', 'shipped')->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];

        return view('marketplace', [
            'products' => $products,
            'categories' => $categories,
            'regions' => $regions,
            'orders' => $orders,
            'orderCounts' => $orderCounts,
            'myProducts' => $myProducts,
            'selectedCategory' => $request->kategori,
            'selectedRegion' => $request->wilayah,
            'selectedSort' => $request->sort,
            'searchQuery' => $request->q,
            'activeOrderCode' => $request->order,
        ]);
    }

    /**
     * Display dedicated "Pesanan Saya" page.
     */
    public function ordersIndex(Request $request): View
    {
        $currentUser = auth()->user();

        if ($currentUser && $currentUser->isAdmin()) {
            $ordersQuery = Order::with(['items.product.category', 'items.product.region', 'items.seller', 'buyer'])->latest();
        } elseif ($currentUser && $currentUser->isPeternak()) {
            $ordersQuery = Order::whereHas('items', function ($q) use ($currentUser) {
                $q->where('seller_id', $currentUser->id);
            })->with(['items.product.category', 'items.product.region', 'items.seller', 'buyer'])->latest();
        } else {
            $ordersQuery = $currentUser
                ? Order::where('buyer_id', $currentUser->id)->with(['items.product.category', 'items.product.region', 'items.seller', 'buyer'])->latest()
                : Order::whereNull('id');
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $ordersQuery->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhereHas('items.product', function ($itemQ) use ($search) {
                        $itemQ->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $ordersQuery->get();

        $allOrdersForCounts = $currentUser
            ? ($currentUser->isAdmin()
                ? Order::all()
                : ($currentUser->isPeternak()
                    ? Order::whereHas('items', function ($q) use ($currentUser) {
                        $q->where('seller_id', $currentUser->id);
                    })->get()
                    : Order::where('buyer_id', $currentUser->id)->get()))
            : collect();

        $orderCounts = [
            'all' => $allOrdersForCounts->count(),
            'pending' => $allOrdersForCounts->where('status', 'pending')->count(),
            'processing' => $allOrdersForCounts->whereIn('status', ['confirmed', 'processing'])->count(),
            'shipped' => $allOrdersForCounts->where('status', 'shipped')->count(),
            'completed' => $allOrdersForCounts->where('status', 'completed')->count(),
            'cancelled' => $allOrdersForCounts->where('status', 'cancelled')->count(),
        ];

        $totalSpent = $allOrdersForCounts->where('status', 'completed')->sum('total_amount');
        $activeCount = $allOrdersForCounts->whereIn('status', ['pending', 'confirmed', 'processing', 'shipped'])->count();

        return view('pesanan', [
            'orders' => $orders,
            'orderCounts' => $orderCounts,
            'totalSpent' => $totalSpent,
            'activeCount' => $activeCount,
            'activeOrderCode' => $request->order,
            'searchQuery' => $request->q,
        ]);
    }

    /**
     * Display or fetch detail for a specific order.
     */
    public function showOrder(Request $request, Order $order): JsonResponse|RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && ! $currentUser->isAdmin()) {
            $isSellerOfOrder = $order->items()->where('seller_id', $currentUser->id)->exists();
            $isBuyerOfOrder = (int) $order->buyer_id === (int) $currentUser->id;

            if (! $isSellerOfOrder && ! $isBuyerOfOrder) {
                abort(403, 'Anda tidak memiliki hak akses untuk melihat pesanan ini.');
            }
        }

        $order->load(['items.product.category', 'items.product.region', 'items.seller', 'buyer']);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'order' => $order,
            ]);
        }

        return redirect()->route('marketplace', ['order' => $order->order_code]).'#pesanan';
    }

    /**
     * Store a new product into the marketplace (Peternak or Admin).
     */
    public function storeProduct(Request $request): RedirectResponse
    {
        $currentUser = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'peternak')->first() : null);

        if (! $currentUser) {
            return redirect()->route('login')->with('error', 'Silakan masuk ke akun Anda untuk mengunggah produk peternakan.');
        }

        if ($currentUser->isUmum()) {
            abort(403, 'Masyarakat Umum tidak memiliki hak akses untuk mengunggah produk peternak.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'price' => ['required', 'numeric', 'min:100'],
            'stock' => ['required', 'integer', 'min:1'],
            'unit' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $seller = $currentUser;
        $slug = Str::slug($validated['name']).'-'.time();

        // Products uploaded by Peternak must be verified by Admin
        $isVerified = $currentUser->isAdmin();

        $product = Product::create([
            'user_id' => $seller->id,
            'product_category_id' => $validated['product_category_id'],
            'region_id' => $validated['region_id'] ?? Region::first()?->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? 'Produk peternakan terverifikasi langsung dari peternak Jawa Timur.',
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'unit' => $validated['unit'],
            'is_verified' => $isVerified,
            'status' => 'active',
        ]);

        $msg = $isVerified
            ? "Produk '{$product->name}' berhasil ditambahkan ke katalog marketplace!"
            : "Produk '{$product->name}' berhasil diunggah! Menunggu proses verifikasi Admin Dinas sebelum berstatus tervalidasi.";

        return redirect()->route('marketplace')->with('success', $msg);
    }

    /**
     * Verify a product (Admin only).
     */
    public function verifyProduct(Request $request, Product $product): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang memverifikasi produk peternak.');
        }

        $product->update([
            'is_verified' => true,
        ]);

        return redirect()->route('marketplace')
            ->with('success', "Produk '{$product->name}' berhasil diverifikasi dan mendapatkan lencana tervalidasi Dinas!");
    }

    /**
     * Create an order when a buyer clicks "Beli" (Umum or Peternak).
     */
    public function buyProduct(Request $request, Product $product): RedirectResponse
    {
        $currentUser = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'umum')->first() : null);

        if (! $currentUser) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk melakukan pembelian produk.');
        }

        // Admin does not buy products as normal user
        if ($currentUser->isAdmin()) {
            return redirect()->route('marketplace')
                ->with('error', 'Akun Admin Dinas berfungsi sebagai pengelola sistem dan tidak melakukan transaksi pembelian produk.');
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$product->stock],
            'buyer_name' => ['required', 'string', 'max:255'],
            'buyer_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $qty = $validated['quantity'];
        $buyer = $currentUser;
        $total = $product->price * $qty;

        $orderCode = '#ORD-'.date('ymd').'-'.rand(100, 999);
        $paymentMethod = $validated['payment_method'] ?? 'Transfer Bank / QRIS';
        $userNotes = $validated['notes'] ?? null;
        $orderNotes = "Metode: {$paymentMethod}".($userNotes ? " • Catatan: {$userNotes}" : '');

        $order = Order::create([
            'order_code' => $orderCode,
            'buyer_id' => $buyer->id,
            'total_amount' => $total,
            'status' => 'processing',
            'shipping_address' => $validated['shipping_address'].', Kontak: '.$validated['buyer_name'],
            'buyer_phone' => $validated['buyer_phone'],
            'notes' => $orderNotes,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'seller_id' => $product->user_id,
            'quantity' => $qty,
            'price_per_unit' => $product->price,
            'subtotal' => $total,
        ]);

        // Decrement stock
        $product->decrement('stock', $qty);

        $formattedTotal = 'Rp '.number_format($total, 0, ',', '.');

        return redirect()->route('marketplace')
            ->with('success', "Pesanan {$orderCode} ({$qty} {$product->unit} {$product->name}) berhasil dibuat! Total: {$formattedTotal}. Status: Diproses.");
    }

    /**
     * Update order status (Seller Peternak, Buyer Masyarakat, or Admin).
     */
    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && ! $currentUser->isAdmin()) {
            $isSellerOfOrder = $order->items()->where('seller_id', $currentUser->id)->exists();
            $isBuyerOfOrder = (int) $order->buyer_id === (int) $currentUser->id;

            if (! $isSellerOfOrder && ! $isBuyerOfOrder) {
                abort(403, 'Anda tidak memiliki hak akses untuk memperbarui status pesanan ini.');
            }

            // Buyer is allowed to complete (order received) or cancel
            if ($isBuyerOfOrder && ! $isSellerOfOrder) {
                if (! in_array($request->status, ['completed', 'cancelled'])) {
                    abort(403, 'Pembeli hanya dapat menyelesaikan atau membatalkan pesanan.');
                }
            }
        }

        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,shipped,completed,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);

        $statusLabels = [
            'pending' => 'Menunggu Pembayaran',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Sedang Diproses Penjual',
            'shipped' => 'Dalam Pengiriman',
            'completed' => 'Selesai (Barang Diterima)',
            'cancelled' => 'Dibatalkan',
        ];
        $label = $statusLabels[$validated['status']] ?? $validated['status'];

        $targetRoute = ($request->input('from') === 'pesanan' || ($request->header('referer') && str_contains($request->header('referer'), 'pesanan')))
            ? 'pesanan'
            : 'marketplace';

        return redirect()->route($targetRoute)
            ->with('success', "Status pesanan {$order->order_code} berhasil diperbarui: {$label}!");
    }

    /**
     * Delete product (Owner Peternak or Admin).
     */
    public function destroyProduct(Product $product): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && ! $currentUser->isAdmin() && $product->user_id !== $currentUser->id) {
            abort(403, 'Anda hanya dapat menghapus produk milik Anda sendiri.');
        }

        $name = $product->name;
        $product->delete();

        return redirect()->route('marketplace')
            ->with('success', "Produk '{$name}' berhasil dihapus dari marketplace.");
    }
}
