<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\HtmlRecord;
use Illuminate\Support\Facades\Storage;
use Goutte\Client;



class GetHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetHtml';

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
     * @return mixed
     */
    public function handle()
    {
        $HtmlRecords = HtmlRecord::all();
        foreach ($HtmlRecords as $HtmlRecord) {
            if($HtmlRecord->html == NULL){
                $client = new Client();
                $crawler = $client->request('GET', $HtmlRecord->url);
                $HtmlRecord->html = $crawler->html();
                $HtmlRecord->save();
            }
        }

    }
}