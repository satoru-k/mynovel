<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Profile;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
  //protected $user;

  public function edit(Request $request)
  {
      //Userモデルからデータを取得する
      $user = User::find($request->id);
      if (empty($user)) {
        abort(404);
      }

      //投稿者本人と管理者のみ編集できる
      $this->authorize('edit', $user);

      //Profileモデルにそのuserのレコードがなければ、作成してsaveする
      if (count(Profile::where('user_id', '=', $request->id)->get()) != 0) {
        $profile = Profile::where('user_id', '=', $user->id)->first();
      } else {
        $profile = new Profile;
        $profile->user_id = $user->id;
        $profile->save();
      }

      return view('admin.user.edit', ['user_form' => $user, 'profile_form' => $profile]);
  }

  public function update(UserRequest $request)
  {

  // public function update(Request $request)
  // {
  //     $this->user = Auth::user();
  //
  //     //Validationをかける(User)
  //     $validator = Validator::make($request->all(), [
  //         'name'  => 'required|max:255',
  //         'email' => 'required|email|max:255|unique:users,email,'.$this->user->id,
  //     ]);
  //     //エラーチェック
  //     if ($validator->fails())
  //     {
  //         return back()->withInput()->withErrors($validator);
  //     }

      //モデルからデータを取得する
      $user = User::find($request->id);
      //送信されてきたフォームデータを格納する
      $user_form = $request->all();

      unset($user_form['_token']);

      //該当するデータを上書きして保存する
      $user->fill($user_form)->save();

      //Validationをかける(Profile)
//$this->validate($request, Profile::$rules);
      //モデルからデータを取得する
      $profile = Profile::where('user_id', '=', $user->id)->first();

      $profile->ruby = $request->ruby;
      $profile->gender = $request->gender;
      $profile->blood = $request->blood;
      $profile->hobby = $request->hobby;
      $profile->job = $request->job;
      $profile->website = $request->website;
      $profile->introduction = $request->introduction;
      $profile->save();

      return redirect('user/'.$user->id);
  }

  public function delete(Request $request)
  {
      //Userモデルからデータを取得する
      $user = User::find($request->id);

      //本人と管理者のみ退会できる
      $this->authorize('edit', $user);

      //退会
      $user->delete();

      return redirect('/');
  }
}
