<?php

namespace MBober35\RoleRule\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use MBober35\Helpers\Traits\CopyStubs;
use Symfony\Component\Finder\SplFileInfo;

class RoleRuleCommand extends Command
{
    use CopyStubs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role-rule
                    { --no-replace : Without replace any files }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init role-rules';

    protected $prefix;
    protected $noReplace;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->prefix = __DIR__ . "/Stubs/";
        $this->noReplace = false;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->noReplace = $this->option("no-replace");
        // Export models.
        $this->copyStubs($this->prefix . "models", "Models", $this->noReplace);

        // Export controllers.
        $this->copyStubs($this->prefix . "controllers", "Http/Controllers/RoleRule", $this->noReplace);
        $this->copyStubs($this->prefix . "admin", "Http/Controllers", $this->noReplace);
    }
}
