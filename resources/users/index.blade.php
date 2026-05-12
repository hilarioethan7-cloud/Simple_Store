<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #0f0f0f; --surface: #1a1a1a; --surface2: #242424;
            --border: #2e2e2e; --text: #f0ece4; --muted: #7a7570;
            --accent: #e8c07d; --accent2: #7ec8a4; --danger: #e07a7a; --blue: #7ab3e0;
        }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; }
        .sidebar {
            width: 240px; min-height: 100vh; background: var(--surface);
            border-right: 1px solid var(--border); display: flex; flex-direction: column;
            padding: 2rem 1.5rem; position: fixed; top: 0; left: 0; bottom: 0;
        }
        .logo { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--accent); margin-bottom: 2.5rem; }
        .logo span { color: var(--muted); font-size: .75rem; display: block; font-family: 'DM Sans', sans-serif; margin-top: 2px; }
        .nav-label { font-size: .65rem; letter-spacing: .12em; text-transform: uppercase; color: var(--muted); margin-bottom: .75rem; margin-top: 1.5rem; }
        .nav-item {
            display: flex; align-items: center; gap: .75rem; padding: .6rem .75rem;
            border-radius: 8px; color: var(--muted); text-decoration: none;
            font-size: .875rem; font-weight: 500; transition: all .2s; margin-bottom: .25rem;
        }
        .nav-item:hover, .nav-item.active { background: var(--surface2); color: var(--text); }
        .nav-item .icon { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-footer { margin-top: auto; padding-top: 1.5rem; border-top: 1px solid var(--border); }
        .user-chip { display: flex; align-items: center; gap: .75rem; margin-bottom: 1rem; }
        .avatar {
            width: 36px; height: 36px; border-radius: 50%; background: var(--accent);
            color: var(--bg); display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .875rem; flex-shrink: 0;
        }
        .user-name { font-size: .875rem; font-weight: 500; }
        .user-role { font-size: .7rem; color: var(--accent); }
        .logout-btn {
            width: 100%; padding: .6rem; background: transparent; border: 1px solid var(--border);
            border-radius: 8px; color: var(--muted); font-family: 'DM Sans', sans-serif;
            font-size: .8rem; cursor: pointer; transition: all .2s;
        }
        .logout-btn:hover { border-color: var(--danger); color: var(--danger); }
        .main { margin-left: 240px; flex: 1; padding: 2.5rem 2rem; }
        .page-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 2rem; }
        .page-title { font-family: 'DM Serif Display', serif; font-size: 2rem; }
        .page-date { font-size: .8rem; color: var(--muted); }
        .table-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: .75rem 1.25rem; text-align: left; font-size: .7rem;
            text-transform: uppercase; letter-spacing: .1em; color: var(--muted);
            background: var(--surface2); font-weight: 600;
        }
        tbody tr { border-top: 1px solid var(--border); transition: background .15s; }
        tbody tr:hover { background: var(--surface2); }
        tbody td { padding: .85rem 1.25rem; font-size: .85rem; }
        .text-muted { color: var(--muted); }
        .font-mono { font-family: monospace; font-size: .8rem; }
        .badge { font-size: .7rem; padding: .2rem .6rem; border-radius: 20px; font-weight: 600; }
        .badge-gold { background: rgba(232,192,125,.15); color: var(--accent); }
        .badge-gray { background: rgba(122,117,112,.15); color: var(--muted); }
        .action-btn {
            padding: .3rem .7rem; border-radius: 6px; border: 1px solid var(--border);
            background: transparent; color: var(--muted); font-size: .75rem;
            cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif;
            text-decoration: none; display: inline-block;
        }
        .action-btn:hover { border-color: var(--accent); color: var(--accent); }
        .action-btn.danger:hover { border-color: var(--danger); color: var(--danger); }
        .alert-success { background: rgba(126,200,164,.1); border: 1px solid rgba(126,200,164,.3); color: var(--accent2); padding: .75rem 1rem; border-radius: 8px; font-size: .85rem; margin-bottom: 1.5rem; }
        .alert-error   { background: rgba(224,122,122,.1); border: 1px solid rgba(224,122,122,.3); color: var(--danger); padding: .75rem 1rem; border-radius: 8px; font-size: .85rem; margin-bottom: 1.5rem; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="logo">Simple Store <span>Admin Panel</span></div>

    <div class="nav-label">Overview</div>
    <a class="nav-item" href="{{ route('admin.dashboard') }}"><span class="icon">◈</span> Dashboard</a>

    <div class="nav-label">Manage</div>
    <a class="nav-item" href="{{ route('admin.products.index') }}"><span class="icon">⬡</span> Products</a>
    <a class="nav-item" href="{{ route('admin.orders.index') }}"><span class="icon">◎</span> Orders</a>
    <a class="nav-item active"><span class="icon">◉</span> Users</a>

    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">← Sign out</button>
        </form>
    </div>
</aside>

<main class="main">
    <div class="page-header">
        <div>
            <div class="page-date">{{ now()->format('l, F j Y') }}</div>
            <h1 class="page-title">Users</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
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
                    <td style="display:flex; gap:.5rem;">
                        <a href="{{ route('admin.users.edit', $user) }}" class="action-btn">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-muted" style="text-align:center; padding:2rem;">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

</body>
</html>