<?php

namespace App\Http\Controllers;

use App\ChartererInspection;
use App\ChartererInspectionDeficiency;
use App\FscInspection;
use App\FscInspectionDeficiency;
use App\InternalAudit;
use App\InternalAuditDeficiency;
use App\PscInspection;
use App\PscInspectionDeficiency;
use App\SireInspection;
use App\SireInspectionDetail;
use App\TerminalInspection;
use App\TerminalInspectionDeficiency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\UserProgramTask;
use App\UserProgramTaskDocument;
use App\UserStory;

class UploadsController extends Controller
{
  public function uploadUserImage(Request $request)
  {
    $request->validate([
      'userid'        => 'required',
    ]);

    $imagePath = '';
    if ($request->hasFile('selfie_image_path')) {
      $file = $request->file('selfie_image_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/selfies/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->selfie_image_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;
    }
    if ($request->hasFile('gallery_image_path')) {
      $file = $request->file('gallery_image_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/galleries/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->gallery_image_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;
    }
    if ($request->hasFile('voice_clip_path')) {
      $file = $request->file('voice_clip_path');
      $name = $request->filename ?? 'audio.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/voices/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->voice_clip_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;
    }

    return response()->json([
      'data'  => [
        'image_path'  =>  $imagePath
      ],
      'success' =>  true
    ]);
  }

  public function uploadUserStory(Request $request)
  {
    $request->validate([
      'userid'        => 'required',
    ]);

    $imagePath = '';
    if ($request->hasFile('image_path')) {
      $file = $request->file('image_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'user-stories/images/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $UserStory = UserStory::where('id', '=', request()->userid)->first();
      $UserStory->image_path = $imagePath;
      $UserStory->update();
    }

    if ($request->hasFile('video_path')) {
      $file = $request->file('video_path');
      $name = $request->filename ?? 'video.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'user-stories/video/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $UserStory = UserStory::where('id', '=', request()->userid)->first();
      $UserStory->video_path = $imagePath;
      $UserStory->update();
    }

    return response()->json([
      'data'  => [
        'image_path'  =>  $imagePath
      ],
      'success' =>  true
    ]);
  }

  public function uploadBannerImage(Request $request)
  {
    $request->validate([
      'settingid'        => 'required',
    ]);

    $banner_path_1 = '';
    if ($request->hasFile('banner_path_1')) {
      $file = $request->file('banner_path_1');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $banner_path_1 = 'banner/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($banner_path_1, file_get_contents($file), 'public');

      $setting = UserStory::where('id', '=', request()->userid)->first();
      $setting->banner_path_1 = $banner_path_1;
      $setting->update();
    }

    $banner_path_2 = '';
    if ($request->hasFile('banner_path_2')) {
      $file = $request->file('banner_path_2');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $banner_path_2 = 'banner/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($banner_path_2, file_get_contents($file), 'public');

      $setting = UserStory::where('id', '=', request()->userid)->first();
      $setting->banner_path_2 = $banner_path_2;
      $setting->update();
    }

    $banner_path_3 = '';
    if ($request->hasFile('banner_path_3')) {
      $file = $request->file('banner_path_3');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $banner_path_3 = 'banner/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($banner_path_3, file_get_contents($file), 'public');

      $setting = UserStory::where('id', '=', request()->userid)->first();
      $setting->banner_path_3 = $banner_path_3;
      $setting->update();
    }


    return response()->json([
      'data'  => [
        'banner_path_1'  =>  $banner_path_1,
        'banner_path_2'  =>  $banner_path_2,
        'banner_path_3'  =>  $banner_path_3,
      ],
      'success' =>  true
    ]);
  }
}
