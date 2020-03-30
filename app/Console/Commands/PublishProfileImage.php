<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
  protected $description = 'Publish an user avatar to public storage';

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
    if ( File::isDirectory(public_path('img/avatar')) ) {
      $profileImagePaths = ['public', 'img', 'profile'];
      $profileImagePath = '';
      
      if ( !Storage::disk('local')->exists(join('/', $profileImagePaths)) ) {
        foreach ( $profileImagePaths as $path ) {
          $profileImagePath .= $path . '/';
          Storage::disk('local')->makeDirectory(rtrim($profileImagePath, '/'));
        }
      }

      if ( Storage::disk('public')->exists('img/profile') ) {
        $imgPath = public_path('img/avatar/avatar-' . $this->argument('avatar') . '.png');
        if ( File::isFile($imgPath) ) {
          File::copy($imgPath, storage_path('app/public/img/profile/default.png'));
        } else {
          $this->error('Profile image avatar-' . $this->argument('avatar') . '.png has missing in ' . public_path('img/avatar') . '.');
          return;
        }
      }

      if ( !File::isDirectory(public_path('storage')) ) {
        $this->call('storage:link');
      }

      $this->info('Profile image was succesfully published.');
    } else {
      $this->error(public_path('img/avatar') . ' not found.');
      return;
    }
  }
}
