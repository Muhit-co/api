<?php

namespace Muhit\Console\Commands;

use Illuminate\Console\Command;
use Muhit\Models\Tag;
use Muhit\Models\Hood;
use Muhit\Models\Issue;

class DataExporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export {target}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exports givin target as json.';

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
        $target = $this->argument('target');
        switch ($target) {
            case 'tags':
                $this->tags();
                break;
            
            case 'hoods': 
                $this->hoods();
                break;
            case 'issues': 
                $this->issues();
                break;
            
            default:
                $this->comment("No default target");
                break;
        }
    }

    public function tags()
    {
        $tags = Tag::all();
        echo $tags->toJson();
    }

    public function hoods()
    {
        $hoods = Hood::all();
        echo $hoods->toJson();
    }

    public function issues()
    {
        $issues = Issue::with('comments', 'user', 'tags', 'images', 'updates')->get();
        echo $issues->toJson();
    }
}
