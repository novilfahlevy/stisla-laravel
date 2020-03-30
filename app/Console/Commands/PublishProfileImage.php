<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class PublishProfileImage extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'avatar:publish {avatar=1}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Publish an user avatar from \'public/img/avatar\' to storage in \'storage/app/public/img/profile\' as default.png';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $availabelAvatarPath = public_path('img/avatar');

    if ( File::isDirectory($availabelAvatarPath) ) {
      $profileImagePaths = ['public', 'img', 'profile'];
      
      if ( !Storage::disk('local')->exists(join('/', $profileImagePaths)) ) {
        $profileImagePath = '';
        foreach ( $profileImagePaths as $path ) {
          $profileImagePath .= $path . '/';
          Storage::disk('local')->makeDirectory(rtrim($profileImagePath, '/'));
        }
      }

      if ( Storage::disk('public')->exists('img/profile') ) {
        $avatar = $this->argument('avatar');
        $imgPath = public_path('img/avatar/avatar-' . $avatar . '.png');
        
        if ( File::isFile($imgPath) ) {
          $imgPathToStorage = storage_path('app/public/img/profile/default.png');
          $imageHasCopied = File::copy($imgPath, $imgPathToStorage);

          if ( $imageHasCopied ) {
            Image::make($imgPathToStorage)->resize(500, 500);
          } 
        } else {
          $this->error('Profile image avatar-' . $avatar . '.png has missing in ' . $availabelAvatarPath . '.');
          return;
        }
      }

      if ( !File::isDirectory(public_path('storage')) ) {
        $this->call('storage:link');
      }

      $this->info('Profile image was succesfully published.');
    } else {
      $this->error($availabelAvatarPath . ' not found.');
      return;
    }
  }
}
