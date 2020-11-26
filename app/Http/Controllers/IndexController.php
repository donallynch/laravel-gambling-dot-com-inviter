<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /** @var float $lat */
    private $lat = 53.3340285;

    /** @var float $lng */
    private $lng = -6.2535495;

    /** @var int $threshold */
    private $threshold = 100;

    /** @var array $dataStructure */
    private $dataStructure = [];

    /** @var string $importFile */
    private $importFile;

    /**
     * IndexController constructor.
     */
    public function __construct() {
        $this->importFile = 'import-file.json';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexAction(Request $request)
    {
        /* Handle File Importer */
        $this->handleFileImport();

        /* Sort DataStructure */
        ksort($this->dataStructure);

        /* Render view */
        return view('inviter', [
            'data' => $this->dataStructure,
            'threshold' => $this->threshold
        ]);
    }

    /**
     * @return bool
     */
    private function handleFileImport()
    {
        /**
         * Read massive file line by line
         *  The maximum memory (RAM) needed depends on the longest line in the input file
         */
        $handle = fopen($this->importFile, 'r');

        /* If there's a problem location or accessing file */
        if (!$handle) {
            exit('no-file');
        }

        /* Read single line of file (to avoid loading massive file into RAM/Memory) */
        $i = 0;
        while (($line = fgets($handle)) !== false) {

            /* Convert single line to array */
            $line = json_decode($line, true);

            /* Convert numeric items (so we can use them in calculations later) */
            $line['latitude'] = floatval($line['latitude']);
            $line['affiliate_id'] = floatval($line['affiliate_id']);
            $line['longitude'] = floatval($line['longitude']);

            /* Calculate distance to Affiliate */
            $distance = $this->distanceInKm($line['latitude'], $line['longitude']);

            /* If within threshold */
            if ($distance <= $this->threshold) {
                /* Register affiliate */
                $this->dataStructure[$line['affiliate_id']] = [
                    'name' => $line['name'],
                    'affiliate_id' => $line['affiliate_id'],
                    'distance' => $distance,
                    'latitude' => $line['latitude'],
                    'longitude' => $line['longitude']
                ];
            }

            $i++;
        }

        /* Close file handler */
        fclose($handle);

        return true;
    }

    /**
     * @param $lat2
     * @param $lon2
     * @return float|int
     */
    private function distanceInKm($lat2, $lon2) {
        $theta = $this->lng - $lon2;
        $dist = sin(deg2rad($this->lat)) * sin(deg2rad($lat2)) +  cos(deg2rad($this->lat)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return ($miles * 1.609344);
    }
}
