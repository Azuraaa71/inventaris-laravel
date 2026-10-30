@extends('layouts.app')

@section('title', 'Pengguna · Inventaris Gudang')

@section('content')
<div class="mb-3">
    <h1 class="h3 mb-1">Manajemen Pengguna</h1>
    <p class="text-muted mb-0">Buat akun dan tentukan hak akses admin atau user.</p>
</div>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-3">
            <h2 class="h5 mb-3">Buat Akun Baru</h2>
            @if ($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul></div>
            @endif
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" maxlength="255" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" maxlength="255" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="user" @selected(old('role', 'user') === 'user')>User — transaksi dan melihat data</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin — akses pengelolaan penuh</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password (minimal 8 karakter)</label>
                    <input id="password" type="password" name="password" class="form-control" autocomplete="new-password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Buat Akun</button>
            </form>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th class="ps-3">Nama</th><th>Email</th><th>Role</th><th class="text-end pe-3">Aksi</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="ps-3 fw-semibold">
                                    {{ $user->name }}
                                    @if (auth()->id() === $user->id) <span class="small text-muted">(Anda)</span> @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge {{ $user->isAdmin() ? 'text-bg-primary' : 'text-bg-secondary' }}">
                                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                                </span></td>
                                <td class="text-end pe-3">
                                    @if (auth()->id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                                        </form>
                                    @else
                                        <span class="small text-muted">Akun aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
