<?php

// app/Http/Controllers/VistaAdminController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VistaAdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // Trae todos los usuarios
        return view('admin.vista_admin', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ]);

        $user->update($request->only('name', 'email'));
        return redirect()->route('vista_admin')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('vista_admin')->with('success', 'Usuario eliminado correctamente.');
    }
}
