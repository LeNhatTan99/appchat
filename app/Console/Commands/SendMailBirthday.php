<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\SendMailUser;
use Illuminate\Support\Facades\Mail;

class SendMailBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail happy birthday user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {     
        $users = User::select('user_name','email','birthday')
                        ->whereMonth('birthday', date('m'))
                        ->whereDay('birthday', date('d'))->get();
        $viewMail = 'mails.send_mail_birthday';
        if(!is_null($users))
        {
            foreach($users as $user) {
                $mails=[
                    'viewMail' => $viewMail,
                    'user' => $user,
                    'subject' => 'Happy Birthday '. $user->user_name
                ];  
                    $email = new SendMailUser($mails);
                    Mail::to($user->email)->send($email);

            }
        }

    }
}
