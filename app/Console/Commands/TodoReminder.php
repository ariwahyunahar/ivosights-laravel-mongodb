<?php

namespace App\Console\Commands;

use App\Models\Todolist;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TodoMailer;

class TodoReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'users:todo-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Todo reminder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $todolists = Todolist::where('todo_at', '<=', Carbon::now()->add(15, 'minute')->toDateTimeString())
                            ->where('todo_at', '>', Carbon::now()->toDateTimeString())
                            ->where('is_notified', 0)
                            ->get();
        if($todolists->count()){
            foreach($todolists as $isi){
                Mail::to('ari.wahyu.nahar@gmail.com')->send(new TodoMailer($isi));
                // if(!\Illuminate\Support\Facades\Mail::failures()){
                //     Todolist::where('_id', $isi->_id)
                //         ->update([
                //             'is_notified' =>1
                //         ])
                //         ;
                // }
                Todolist::where('_id', $isi->_id)
                    ->update([
                        'is_notified' =>1
                    ])
                    ;
            }
        }
        return 0;
    }
}
