<?php

// app/Http/Controllers/VistaAdminController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VistaAdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.vista_admin', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Usuario creado exitosamente');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Eliminar roles del usuario
            $user->roles()->detach();
            
            // Eliminar el usuario
            $user->delete();
            
            return response()->json(['message' => 'Usuario eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el usuario'], 500);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = $user->roles->first()->name ?? null;
        
        return response()->json([
            'user' => $user,
            'role' => $role
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        // Actualizar rol
        $user->syncRoles([$request->role]);

        return response()->json(['message' => 'Usuario actualizado exitosamente']);
    }
}
