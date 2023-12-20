<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        SitemapGenerator::create(env('SITEMAP_URL'))
            ->hasCrawled(function (Url $url) {
                $segments = $url->segments();
                $priority = max(0.4, 1 - 0.1 * min(count($segments), 4));
                $url->setPriority($priority);
                $url->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY);
                $url->setLastModificationDate(now());
                return $url;
            })
            ->getSitemap()
            ->writeToFile(public_path('sitemap.xml'));
    }
}
