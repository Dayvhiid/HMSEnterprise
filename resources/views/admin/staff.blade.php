{{-- Staff accounts. Public sign-up is off, so this is where an administrator adds staff. --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff · {{ config('clinic.product_name') }}</title>
    <style>
        body{margin:0;background:#f4f7fa;color:#0f2a3d;font:15px/1.5 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}
        .st-wrap{max-width:1100px;margin:0 auto;padding:24px 16px 48px}
        h1{font-size:26px;margin:0 0 4px}
        .st-sub{color:#4e6b80;margin:0 0 24px}
        .st-grid{display:grid;grid-template-columns:2fr 1fr;gap:20px;align-items:start}
        @media (max-width:860px){.st-grid{grid-template-columns:1fr}}
        .st-card{background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(15,42,61,.08);padding:20px;overflow-x:auto}
        table{width:100%;border-collapse:collapse;font-size:14px}
        th,td{text-align:left;padding:10px 8px;border-bottom:1px solid #e6edf2;white-space:nowrap}
        th{color:#4e6b80;font-weight:600;font-size:12px;text-transform:uppercase;letter-spacing:.4px}
        .st-role{display:inline-block;padding:2px 10px;border-radius:10px;background:#e1ecf4;font-size:12px}
        .st-role.admin{background:#fde8c8}
        label{display:block;font-weight:600;font-size:13px;margin:12px 0 4px}
        input,select{width:100%;box-sizing:border-box;padding:9px 10px;border:1px solid #c9d6df;border-radius:6px;font:inherit}
        button{margin-top:16px;width:100%;padding:10px;border:0;border-radius:6px;background:#2a6f97;color:#fff;font-weight:600;cursor:pointer}
        .st-ok{background:#e8f6ee;color:#14532d;padding:10px 14px;border-radius:8px;margin-bottom:16px}
        .st-muted{color:#4e6b80;font-size:13px}
    </style>
</head>
<body>
@include('partials.session-bar')
<div class="st-wrap">
    <h1>Staff</h1>
    <p class="st-sub">{{ $users->count() }} staff {{ Str::plural('account', $users->count()) }} at {{ config('clinic.name') }}.</p>

    @if (session('success'))
        <div class="st-ok" role="status">{{ session('success') }}</div>
    @endif

    <div class="st-grid">
        <div class="st-card">
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Role</th><th>Two-factor</th><th>Added</th></tr>
                </thead>
                <tbody>
                    @forelse ($users as $staff)
                        <tr>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->email }}</td>
                            <td><span @class(['st-role', 'admin' => $staff->isAdmin()])>{{ $staff->roleLabel() }}</span></td>
                            <td>{{ $staff->two_factor_confirmed_at ? 'On' : 'Off' }}</td>
                            <td>{{ $staff->created_at?->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="st-muted">No staff accounts yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="st-card">
            <h2 style="margin:0;font-size:18px;">Add staff member</h2>
            <p class="st-muted" style="margin:4px 0 0;">Give them the temporary password; they can change it under their profile after signing in.</p>
            <form method="POST" action="{{ route('admin.staff.store') }}">
                @csrf
                <label for="name">Full name</label>
                <input id="name" name="name" value="{{ old('name') }}" required maxlength="255">
                <label for="email">Email (used to sign in)</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}" @selected(old('role', 'user') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <label for="password">Temporary password</label>
                <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password">
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password">
                <button type="submit">Add staff member</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
