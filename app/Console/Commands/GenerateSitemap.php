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
        SitemapGenerator::create(env('APP_URL_PUBLIC'))
            ->hasCrawled(function (Url $url) {

                $segments = $url->segments();

                if(empty($segments)) {
                    $url->setPriority(0.9);
                }else if(sizeof($segments) == 1) {
                    $url->setPriority(0.8);
                }else if(sizeof($segments) == 2) {
                    $url->setPriority(0.7);
                }else if(sizeof($segments) == 3) {
                    $url->setPriority(0.6);
                }else if(sizeof($segments) == 4) {
                    $url->setPriority(0.5);
                }else{
                    $url->setPriority(0.4);
                }

                return $url;
            })
            ->getSitemap()
            ->writeToFile(public_path('sitemap.xml'));
    }
}
