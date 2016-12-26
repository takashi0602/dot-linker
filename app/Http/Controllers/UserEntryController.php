<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;
use App\AwsUploader;
use App\Models\User;
use App\Models\Tag;

use Auth;
use Image;
use Crypt;

class UserEntryController extends Controller
{ 
    public function InputProfile(Request $request)
    {
		
		$icon = $request->file('icon')->move("cacheimg");		
		Session::put('icon', $icon->getRealPath());
    	Session::put('profile',$request->except("icon","submit"));		
		
		$value = $request->get('submit');
		
		if($value == "toTag"){	// プロフィール設定からお気に入りタグを設定する場合 
			return redirect()->route('user-entry-tag');
		}elseif($value == "toConfirm"){	// プロフィール設定から確認画面に行く場合
			Session::put('tags',[]);
			return redirect()->route('user-entry-confirm');
		}
    }

    public function InputTag(Request $request)
    {
    	Session::put('tags',$request->get('tags'));		

    	return redirect()->route('user-entry-confirm');
    }

    public function Confirm(Request $request)
    {
    	$data = $request->session()->all();
		$data["tags"] = Tag::whereIn('id',$data["tags"])->get()->map(function($tag) {
			return $tag->name;
		});
    	return view('user/user-entry-confirm',$data);
    }

    public function Create(Request $request)
    {
    	$Sessiondata = $request->session()->all();

    	$UserProfire = array_merge($Sessiondata['google'],$Sessiondata['profile']);

    	$TagIds = $request->session()->get('tags');
   
    	$user = User::create($UserProfire);

    	$user->tags()->attach($TagIds);
		$icon = Session::get("icon");		
		$user->iconUp($icon);
		Auth::login($user);
		if (Session::has('redirect_route')) return redirect()->route(Session::pull('redirext_route'));		
        return redirect()->route('user-mypage-recommend');
    }

    public function Cancel(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('landing');
    } 
}
