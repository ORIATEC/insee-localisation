<?php

namespace ORIATEC\InseeLocalisation\Console\Commands;

use Illuminate\Console\Command;
use ORIATEC\InseeLocalisation\Models\Localisation;
use Rodenastyle\StreamParser\StreamParser;
use Tightenco\Collect\Support\Collection;

class ImportInseeLocalisation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insee:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Insee Data from data.gouv.fr';

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

        $data_gouv_url = 'https://www.data.gouv.fr/fr/datasets/r/dbe8a621-a9c4-4bc3-9cae-be1699c5ff25';

        /*$data_raw = mb_convert_encoding(file_get_contents($data_gouv_url), "HTML-ENTITIES", "UTF-8");

        $csv = new CSV_Parser();
        $csv->fromString($data_raw);
        $data = $csv->parse();
        */

        $nb_line = substr_count(file_get_contents($data_gouv_url), "\n");

        $counter = new \stdClass();
        $counter->imported = 0;
        $counter->not_imported = 0;


        $progressBar = $this->output->createProgressBar($nb_line - 1);
        $progressBar->start();

        StreamParser::csv($data_gouv_url)->each(function(Collection $data) use ($progressBar, $counter){
            $progressBar->advance();

            if(
                empty($data->get('code_commune_INSEE'))
                || empty($data->get('nom_commune'))
                || empty($data->get('code_postal'))
                || empty($data->get('nom_commune_postal'))
                || empty($data->get('code_departement'))
                || empty($data->get('nom_departement'))
                || empty($data->get('code_region'))
                || empty($data->get('nom_region'))
            ){
                $counter->not_imported++;
                return;
            }

            $insert_data = [
                'insee_city_code' => $data->get('code_commune_INSEE'),
                'city_name' => $data->get('nom_commune'),
                'city_name_uppercase' => strtoupper($data->get('nom_commune')),
                'city_zipcode' => $data->get('code_postal'),
                'city_name_normalize' => $data->get('nom_commune_postal'),
                'city_locality_name_normalize' => $data->get('ligne_5'),
                'department_code' => $data->get('code_departement'),
                'department_name' => $data->get('nom_departement'),
                'region_code' => $data->get('code_region'),
                'region_name' => $data->get('nom_region')
            ];

            if(!empty($data->get('latitude'))){
                $insert_data['lat'] = $data->get('latitude');
            }
            if(!empty($data->get('longitude'))){
                $insert_data['lng'] = $data->get('longitude');
            }

            Localisation::create(
                $insert_data
            );

            $counter->imported++;
        });

        $progressBar->finish();

        $this->info('Importation terminée. '.$counter->imported.' villes traitées. '.$counter->not_imported.' villes non importées car des données sont manquantes.');

        return 0;
    }
}

