<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public $rules = [
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    ];

    public function messages()
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email address is already taken.',
            'password.required' => 'Password is required.'
        ];
    }

    public function index()
    {
        $users = User::query()->paginate(10);


        $sensors = Sensor::all();

        return view('users.index', compact('users', 'sensors'));
    }

    public function getData($offset , $limit )
    {
        $users = User::query()->skip($offset)->take($limit)->get();


        return view('users.data', compact('users'));
    }

    public function create(Request $request)
    {

        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required']
        ], $this->messages());

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        foreach ($request->sensor as $sensor) {
            $user->sensors()->attach($sensor);
        }

        return response()->json($user);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'sensors' => $user->sensors,

        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($id)],
        ], $this->messages());

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        $user->sensors()->sync($request->sensor);

        $user->save();

        return response()->json($user);
    }


    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|different:current_password',
        ]);

        $user = User::find($request->id);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully.']);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->input('remember-me', false))) {
            return redirect()->route('home');
        }else{
            return redirect()->route('login')->withErrors(['email' => 'Invalid credentials', 'password' => 'Invalid credentials']);
        }
    }
}
