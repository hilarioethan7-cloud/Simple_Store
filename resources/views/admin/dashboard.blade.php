<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Simple Store</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0f0f0f;
            --surface: #1a1a1a;
            --surface2: #242424;
            --border: #2e2e2e;
            --text: #f0ece4;
            --muted: #7a7570;
            --accent: #e8c07d;
            --accent2: #7ec8a4;
            --danger: #e07a7a;
            --blue: #7ab3e0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            animation: slideIn .4s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to   { transform: translateX(0);     opacity: 1; }
        }

        .logo {
            font-family: 'DM Serif Display', serif;
            font-size: 1.4rem;
            color: var(--accent);
            margin-bottom: 2.5rem;
            letter-spacing: .02em;
        }

        .logo span { color: var(--muted); font-size: .75rem; display: block; font-family: 'DM Sans', sans-serif; margin-top: 2px; }

        .nav-label {
            font-size: .65rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: .75rem;
            margin-top: 1.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem .75rem;
            border-radius: 8px;
            color: var(--muted);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            transition: all .2s;
            margin-bottom: .25rem;
            cursor: pointer;
        }

        .nav-item:hover, .nav-item.active {
            background: var(--surface2);
            color: var(--text);
        }

        .nav-item .icon { font-size: 1rem; width: 20px; text-align: center; }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1rem;
        }

        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--accent);
            color: var(--bg);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: .875rem;
            flex-shrink: 0;
        }

        .user-name { font-size: .875rem; font-weight: 500; }
        .user-role { font-size: .7rem; color: var(--accent); }

        .logout-btn {
            width: 100%;
            padding: .6rem;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            font-size: .8rem;
            cursor: pointer;
            transition: all .2s;
        }

        .logout-btn:hover { border-color: var(--danger); color: var(--danger); }

        /* Main */
        .main {
            margin-left: 240px;
            flex: 1;
            padding: 2.5rem 2rem;
            animation: fadeUp .5s ease .1s both;
        }

        @keyframes fadeUp {
            from { transform: translateY(16px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }

        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .page-title {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            color: var(--text);
        }

        .page-date { font-size: .8rem; color: var(--muted); }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform .2s, border-color .2s;
        }

        .stat-card:hover { transform: translateY(-2px); border-color: var(--accent); }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            border-radius: 50%;
            opacity: .06;
        }

        .stat-card:nth-child(1)::before { background: var(--accent);  transform: translate(20px,-20px); }
        .stat-card:nth-child(2)::before { background: var(--accent2); transform: translate(20px,-20px); }
        .stat-card:nth-child(3)::before { background: var(--blue);    transform: translate(20px,-20px); }
        .stat-card:nth-child(4)::before { background: var(--danger);  transform: translate(20px,-20px); }

        .stat-label { font-size: .72rem; text-transform: uppercase; letter-spacing: .1em; color: var(--muted); margin-bottom: .5rem; }

        .stat-value {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            line-height: 1;
            margin-bottom: .4rem;
        }

        .stat-card:nth-child(1) .stat-value { color: var(--accent); }
        .stat-card:nth-child(2) .stat-value { color: var(--accent2); }
        .stat-card:nth-child(3) .stat-value { color: var(--blue); }
        .stat-card:nth-child(4) .stat-value { color: var(--danger); }

        .stat-sub { font-size: .75rem; color: var(--muted); }

        /* Tables */
        .section { margin-bottom: 2.5rem; }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.2rem;
        }

        .badge {
            font-size: .7rem;
            padding: .2rem .6rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-gold   { background: rgba(232,192,125,.15); color: var(--accent); }
        .badge-green  { background: rgba(126,200,164,.15); color: var(--accent2); }
        .badge-blue   { background: rgba(122,179,224,.15); color: var(--blue); }
        .badge-red    { background: rgba(224,122,122,.15); color: var(--danger); }
        .badge-gray   { background: rgba(122,117,112,.15); color: var(--muted); }

        .table-wrap {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            padding: .75rem 1.25rem;
            text-align: left;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--muted);
            background: var(--surface2);
            font-weight: 600;
        }

        tbody tr {
            border-top: 1px solid var(--border);
            transition: background .15s;
        }

        tbody tr:hover { background: var(--surface2); }

        tbody td {
            padding: .85rem 1.25rem;
            font-size: .85rem;
            color: var(--text);
        }

        .text-muted { color: var(--muted); }
        .font-mono  { font-family: monospace; font-size: .8rem; }

        .action-btn {
            padding: .3rem .7rem;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--muted);
            font-size: .75rem;
            cursor: pointer;
            transition: all .2s;
            font-family: 'DM Sans', sans-serif;
        }

        .action-btn:hover { border-color: var(--accent); color: var(--accent); }
        .action-btn.danger:hover { border-color: var(--danger); color: var(--danger); }

        /* Alerts */
        .alert {
            padding: .75rem 1rem;
            border-radius: 8px;
            font-size: .85rem;
            margin-bottom: 1.5rem;
        }

        .alert-success { background: rgba(126,200,164,.1); border: 1px solid rgba(126,200,164,.3); color: var(--accent2); }
        .alert-error   { background: rgba(224,122,122,.1); border: 1px solid rgba(224,122,122,.3); color: var(--danger); }
    </style>
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar">
    <div class="logo">
        Simple Store
        <span>Admin Panel</span>
    </div>

    <div class="nav-label">Overview</div>
    <a class="nav-item active"><span class="icon">◈</span> Dashboard</a>

    <div class="nav-label">Manage</div>
    <a class="nav-item" href="{{ route('admin.products.index') }}"><span class="icon">⬡</span> Products</a>
    <a class="nav-item" href="{{ route('admin.orders.index') }}"><span class="icon">◎</span> Orders</a>
    <a class="nav-item" href="{{ route('admin.users.index') }}"><span class="icon">◉</span> Users</a>

    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">← Sign out</button>
        </form>
    </div>
</aside>

{{-- Main Content --}}
<main class="main">

    <div class="page-header">
        <div>
            <div class="page-date">{{ now()->format('l, F j Y') }}</div>
            <h1 class="page-title">Dashboard</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₱{{ number_format($totalRevenue, 0) }}</div>
            <div class="stat-sub">All time</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ $totalOrders }}</div>
            <div class="stat-sub">{{ $pendingOrders }} pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Products</div>
            <div class="stat-value">{{ $totalProducts }}</div>
            <div class="stat-sub">{{ $lowStock }} low stock</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Customers</div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-sub">Registered users</div>
        </div>
    </div>

    {{-- Products Table --}}
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Products</h2>
            <a href="{{ route('admin.products.create') }}" class="action-btn">+ Add Product</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="text-muted font-mono">{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td><span class="badge badge-gold">{{ $product->category->name ?? '—' }}</span></td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->stock <= 5)
                                <span class="badge badge-red">{{ $product->stock }} left</span>
                            @else
                                <span class="badge badge-green">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td style="display:flex; gap:.5rem;">
                            <a href="{{ route('admin.products.edit', $product) }}" class="action-btn">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-muted" style="text-align:center; padding:2rem;">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="action-btn">View all</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="font-mono text-muted">#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                        <td>₱{{ number_format($order->total, 2) }}</td>
                        <td>
                            @php
                                $badgeMap = [
                                    'pending'   => 'badge-gold',
                                    'completed' => 'badge-green',
                                    'cancelled' => 'badge-red',
                                    'shipped'   => 'badge-blue',
                                ];
                                $cls = $badgeMap[$order->status] ?? 'badge-gray';
                            @endphp
                            <span class="badge {{ $cls }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="action-btn">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-muted" style="text-align:center; padding:2rem;">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Users</h2>
            <a href="{{ route('admin.users.index') }}" class="action-btn">View all</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted font-mono">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'badge-gold' : 'badge-gray' }}">
                                {{ ucfirst($user->role ?? 'customer') }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-muted" style="text-align:center; padding:2rem;">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>

</body>
</html>