<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProfileRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    public function __construct()
    {
        //Verifica si la persona no se ha logueado, se redirige al login
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
        $this->authorize('view', $profile);

        return view('subscriber.profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        //
        $this->authorize('update', $profile);
        $user = Auth::user();
        
        $current_image = $user->profile->photo;
        $split_url = explode("/",$current_image);
        $public_id = explode(".", $split_url[sizeof($split_url)-1]);

        if($request->hasFile('photo')){
            // File::delete(public_path('storage/'. $profile->photo));
            Cloudinary::destroy("Profiles/".$public_id[0]);
            // $photo = $request['photo']->store('profiles');
            $photo = Cloudinary::upload($request['photo']->getRealPath(), [
                'folder' => 'Profiles',
            ])->getSecurePath();
        }else{
            $photo = $user->profile->photo;
        }
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->profile->photo = $photo;
        
        $user->save();

        $user->profile->save();

        return redirect()->route('profiles.edit',$user->profile->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
