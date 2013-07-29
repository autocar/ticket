<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class JobEndCronCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'job:end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Time to close work job.';

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
     * @return void
     */
    public function fire()
    {
        $this->line('Welcome to the job cron.');

        $auto_close = Configuration::where('key', 'auto_close')->first();
        if ($auto_close['value'])
        {
            $auto_close_time = Configuration::where('key', 'auto_close_time')->first();
            $diff_time       = date("Y-m-d H:i:s", time() - ($auto_close_time['value'] * 60 * 60));
            $jobs            = Job::where('status', '=', '1')->where('invalid', '=', '0')->where('start_time', '<', $diff_time)->get();

            foreach ($jobs as $job)
            {
                Job::where('id', $job->id)->update(array('status' => 2));
            }
        }

        $this->line('Done !');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}