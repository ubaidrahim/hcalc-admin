<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ImageStore;
use Carbon\Carbon;
use App\Models\User;

class AdminSettingsController extends Controller
{
    use ImageStore;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['file','mimes:jpg,jpeg,png,webp'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->designation = $request->role ?? '';
        $user->role = 1;
        if($request->image)
        {
            $user->image = $this->saveImage($request->image);
        }
        $user->save();
        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user)
            {
                response()->json(['success' => false, 'message' => 'User not found!']);
            }
        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'file|mimes:jpg,jpeg,png,webp'
        ]);
        if(auth()->user()->id != $id)
            {
                return response()->json(['success' => false, 'message' => 'You are not authorized to change password for this user.']);
            }
        $user = User::find($id);
        if(!$user)
            {
                return response()->json(['success' => false, 'message' => 'User not found!']);
            }
        $user->name = $request->name;
        if($request->image)
            {
                $user->image = $this->saveImage($request->image);
            }
        if($request->role)
            {
                $user->designation = $request->role;
            }
        $user->save();
        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->user()->id == $id)
        {
            return response()->json(['success' => false, 'message' => 'This user is currently logged in.']);
        }
        $user = User::find($id);
        $user->delete();
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function listAll(Request $request)
    {
        $page = $request->page ?? 1;
        $offset = 0;
        $query = User::latest()->paginate(25);
        $body = view('admin.partials.rows',['query' => $query, 'page' => $page])->render();
        $links = $query->appends(request()->except('page'))->links()->render();
        // $counts = [
        //     'total' => $query->total(),
        //     'active' => (clone $query)->where('status',1)->count(),
        //     'inactive' => (clone $query)->where('status',0)->count()
        // ];
        return response()->json(['body' => $body, 'links' => $links]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'password' => 'required|confirmed'
        ]);
        if(auth()->user()->id != $request->id){
            return response()->json(['success' => false, 'message' => 'You are not authorized to change password for this user.']);
        }

        $user = User::find($request->id);
        if(!$user)
        {
            return response()->json(['success' => false, 'message' => 'User not found!']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['success' => true, 'data' => $user]);
    }
}
