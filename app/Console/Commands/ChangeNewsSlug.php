<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\Redirect;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ChangeNewsSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change_news_slug {oldSlug} {newSlug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $oldSlug = $this->argument('oldSlug');
        $newSlug = $this->argument('newSlug');
        $checkSame = Redirect::where('old_slug', route('news_item', ['slug' => $oldSlug], false))
            ->where('new_slug', route('news_item', ['slug' => $newSlug], false))
            ->first();

        if ($checkSame !== null)
        {
            $this->error("SUCH AN ENTRY ALREADY EXISTS");
            return 1;
        }

        if ($oldSlug === $newSlug)
        {
            $this->error("SLUGS ARE THE SAME");
            return 1;
        }

        $news = News::where('slug', $oldSlug)->first();
        if ($news === null)
        {
            $this->error("SUCH A SLUG DOES NOT EXIST");
            return 1;
        }

        DB::transaction(function () use ($news, $newSlug) {
            Redirect::where('old_slug', route('news_item', ['slug' => $newSlug], false))->delete();
            $news->slug = $newSlug;
            $news->save();
        });

        return Command::SUCCESS;
    }
}
