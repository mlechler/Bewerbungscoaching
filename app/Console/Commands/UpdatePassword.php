<?php

namespace App\Console\Commands;

use App\Mail\PasswordUpdateReminder;
use App\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UpdatePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a reminder mail to the member.';

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
        $members = Member::all();
        foreach($members as $member)
        {
            Mail::to($member->email)->send(new PasswordUpdateReminder());
        }
    }
}
