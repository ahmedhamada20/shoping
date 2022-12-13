<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Package;
use App\Order;
use Carbon\Carbon;

class CancelPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create cancel package if package is not proceed or cancel in 10 minute';

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
     * @return int
     */
    public function handle()
    {
        $date = \Carbon\Carbon::now()->subMinutes(60)->toDateTimeString();
        $packages = Package::where('created_at','<',$date)
                    // ->where('is_proceed',0)
                    //->limit(1)
                    ->get();

        foreach ($packages as $key => $package) {
            $this->cancel($package);
        }
    }

    public function cancel($package)
    {
        try {
            // Check for package data is available or not
            if($package){
                $orders = Order::where('package_id', $package->id)->first();
                if(empty($orders)){
                    Package::where("id",$package->id)->delete();
                }

                return true;
                Log::info('Cancelled package created from corn job.');
            }else{
                Log::error('Package not found.');
                return ;
            }
        }catch(\Exception $e) {
            Log::error($e);
            return ;
        }
    }
}
