<?php

namespace Modules\Users\Console;

use Modules\Codes\models\Code;
use Illuminate\Console\Command;
use Modules\Users\App\Models\User;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CheckUserCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check user codes for expiration and update status';

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
        // Fetch all users with a code  
        $users = User::whereNotNull('code')->get();

        foreach ($users as $user) {
            // Fetch the corresponding code  
            $code = Code::where('code', $user->code)->first();
            if (!empty($code)) {
                // Check if the code has expired  
                if ($code->expire_at <= now()) {
                    // Update user status and code status  
                    $user->status = 'unsubscribed';
                    $code->status = 'ended';

                    // Save changes  
                    $user->save();
                    $code->save();

                    $this->info("User {$user->name} status updated to 'unsubscribed'.");
                }
            } else {
                $this->warn("Code not found for user {$user->name}.");
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
