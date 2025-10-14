<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash; // ✅ Add this line

class UserController extends Controller
{
    //

    private function authorizeAdminOrDeveloper(){
        $currentUser = Auth::user();
        if (!$currentUser->hasRole(['Admin', 'Developer'])) {
            return redirect()->back()->with('danger', 'Access Restricted')->send();
        }
    }

    /**
     * List all users
     */
    public function index(){
        $this->authorizeAdminOrDeveloper();

        $users = User::orderBy('created_at', 'desc')->get();
        return view('user.index', ['users' => $users]);
    }

    /**
     * View a single user
     */
    public function view($id){
        $this->authorizeAdminOrDeveloper();

        $user = User::findOrFail($id);

        // Get all roles
        $roles = Role::all(); // returns collection of role names

        return view('user.view', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Activate / Deactivate a user
     */
    public function updateStatus(Request $request){
        $this->authorizeAdminOrDeveloper();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'action'  => 'required|string|in:Active,Inactive'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->status = $request->action;
        $user->save();

        return redirect()->back()->with('success', 'Status Changed!');
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request){
        $this->authorizeAdminOrDeveloper();

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $newPassword = $this->generateRandomString(8);
        $user->password = Hash::make($newPassword);
        $user->save();

        return redirect()->back()->with('success', 'Password Reset. New password is ' . $newPassword);
    }

    /**
     * Update display picture
     */
    public function updateDP(Request $request){
        $this->authorizeAdminOrDeveloper();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'dp'      => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = User::findOrFail($request->user_id);

        if ($request->hasFile('dp')) {
            $imageName = $user->id . '.' . $request->dp->extension();

            // Save to storage/app/public/user_dp
            $request->dp->storeAs('user_dp', $imageName, 'public');

            // Save file name to user
            $user->user_dp = $imageName;
            $user->save();
        }


        return redirect()->back()->with('success', 'Profile Picture Updated');
    }

    /**
     * Search users for select inputs
     */
    public function selectSearch(Request $request){
        $users = [];
        if ($request->has('q')) {
            $keyword = $request->q;
            $users = User::select('id', 'name', 'designation')
                ->where('name', 'LIKE', "%$keyword%")
                ->orWhere('id', 'LIKE', "%$keyword%")
                ->get();
        }

        return response()->json($users);
    }

    /**
     * Get active users list
     */
    public function activeUsersList(){
        return User::where('status', 'Active')->get();
    }

    /**
     * Generate a random string
     */
    private function generateRandomString($length = 10){
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString     = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Add role to user
     */
    public function addRole(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);

        // Assign role
        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Role added successfully.');
    }

    /**
     * Remove role from user
     */

    public function removeRole(Request $request){
    // Ensure only Admins or Developers can execute this
    $this->authorizeAdminOrDeveloper();

    $request->validate([
        'user_id' => 'required|exists:users,id',
        'role'    => 'required|string|exists:roles,name',
    ]);

    $user = User::findOrFail($request->user_id);

    // Check if trying to remove the Developer role
    if ($request->role === 'Developer') {
        $activeDevelopers = User::role('Developer')
            ->where('status', 'Active')
            ->where('id', '!=', $user->id) // exclude the current user
            ->count();

        if ($activeDevelopers < 1) {
            return redirect()->back()->with(
                'error',
                'At least one active Developer must remain in the system.'
            );
        }
    }



    // Remove role (all other roles are safe)
    $user->removeRole($request->role);

    return redirect()->back()->with('success', 'Role removed successfully.');
}



   
    
}