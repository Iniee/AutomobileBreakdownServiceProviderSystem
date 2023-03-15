<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Breakdown;
use App\Models\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteNullBreakdownData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:nullbreakdowndata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete data from the breakdown table if status is null after 30 mins';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now()->subMinutes(30);

    
       $breakdowns = Breakdown::where(function($query) {
                $query->whereNull('status')
                      ->orWhere('status', 'requested');
            })
            ->where('created_at', '<', $now)
            ->get();
            
        foreach ($breakdowns as $breakdown) {
             Request::where('breakdown_id', $breakdown->breakdown_id)->delete();
            $breakdown->delete();
        }
        
        $this->info('Breakdown data deleted successfully!');
    }
    
}