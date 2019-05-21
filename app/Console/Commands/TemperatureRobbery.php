<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Temperature;
use App\Lake;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class TemperatureRobbery extends Command

{

    /**

     * The name and signature of the console command.

     *

     * @var string

     */

    protected $signature = 'temperature:rob';



    /**

     * The console command description.

     *

     * @var string

     */

    protected $description = 'Rob lake temperatures';



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


        $client = new Client();
        $crawler = $client->request('GET', 'http://meteonews.ch/de/Artikel/Lakes/CH/de');

        $temp_arr = [];

        // get every row from table except first and save to array
        $temp_arr = $crawler->filter('table tr')
        ->reduce(function (Crawler $node, $i) { 
            return $i != 0;
        })
        ->each(function(Crawler $node, $i){
            $name = mb_strtolower(preg_replace('/[^[:word:]]/', '', $node->children()->first()->text()));
            $temp = preg_replace('/[^[:digit:]]/', '', $node->children()->eq(1)->text());
            return [$name => $temp];
        });

        // loop over temperatures and save in db
        foreach($temp_arr as $lake){
            foreach($lake as $name => $temp){ 
                
                # save lake if not recognized
                $lake = Lake::firstOrCreate(
                    ['key' => $name], ['title' => ucfirst($name)]
                );
                
                $lake->temperatures()->save(new Temperature(['value' => $temp]));

                # add temperature to history
                /*$temp_entry = new Temperature;
                $temp_entry->value = $temp;
                $temp_entry->lake_id = $lake->id;
                $temp_entry->save();*/
                
                $this->info($name.': '.$temp);
            }
        }

        $this->info('Temperatures have been robbed');

    }

}