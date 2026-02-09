<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * List users + search
     */
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        if ($keyword) {
            $users = User::whereRaw(
                    "MATCH(name, email) AGAINST(? IN BOOLEAN MODE)",
                    [$keyword]
                )
                ->paginate(10)
                ->withQueryString();
        } else {
            $users = User::query()
                ->paginate(10)
                ->withQueryString();
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store new user
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('admin.users')
            ->with('success', 'User berhasil dibuat');
    }

    /**
     * Show edit form
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update user
     */
    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users')
            ->with('success', 'User berhasil diupdate');
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // 1. hapus item penjualan dari setiap produk
        foreach ($user->produk as $produk) {
            $produk->itemPenjualan()->delete();
        }

        // 2. hapus produk
        $user->produk()->delete();

        

        return redirect()
            ->route('admin.users')
            ->with('success', 'User berhasil dihapus');
    }


}
