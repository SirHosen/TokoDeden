<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::with('role')
            ->whereHas('role', function ($q) {
                $q->where('name', '!=', 'admin'); // Hanya tampilkan customer, bukan admin
            });

        // Pencarian
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }

        // Filter status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }

        $users = $query->latest()->paginate(10);

        // Untuk statistik
        $totalUsers = User::whereHas('role', function ($q) {
            $q->where('name', '!=', 'admin');
        })->count();

        $activeUsers = User::whereHas('role', function ($q) {
            $q->where('name', '!=', 'admin');
        })->where('is_active', true)->count();

        $inactiveUsers = $totalUsers - $activeUsers;

        return view('admin.users.index', compact('users', 'totalUsers', 'activeUsers', 'inactiveUsers'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $data = $request->except('password', 'password_confirmation', 'avatar');
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'nullable|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_default_address' => 'nullable|boolean',
        ]);

        $data = $request->except('avatar', 'password');

        // Debug log to see what data we're receiving
        \Log::debug('Admin user update data:', [
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_default_address' => $request->has('is_default_address'),
            'is_active' => $request->has('is_active'),
            'request_all' => $request->all(),
        ]);

        // Handle boolean fields explicitly
        $data['is_active'] = $request->has('is_active');
        $data['is_default_address'] = $request->has('is_default_address');

        // Update password only if it's provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Upload new avatar
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Check if user has orders
        if ($user->orders()->count() > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus pengguna yang memiliki pesanan!');
        }

        // Delete avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }

    /**
     * Toggle user active status.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna berhasil {$status}!");
    }

    /**
     * Display the admin profile edit form.
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfile()
    {
        $user = auth()->user();
        return view('admin.users.profile', compact('user'));
    }

    /**
     * Update the admin profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('avatar', 'password');

        // Update password only if it's provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
                'current_password' => 'required|string',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini salah.'
                ])->withInput();
            }

            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Upload new avatar
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
