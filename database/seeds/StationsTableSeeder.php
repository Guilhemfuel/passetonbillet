<?php

use Illuminate\Database\Seeder;
use App\Station;
use League\Csv\Reader;


class StationsTableSeeder extends Seeder
{

    private function valueOrNull($value) {
        return !strlen($value) ? null : $value;
    }

    /**
     * Add the eurostar stations to the database.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath( storage_path( 'app/data/stations.csv' ) )
                     ->setDelimiter( ';' )
                     ->setHeaderOffset( 0 );

        foreach ( $csv as $record ) {

            Station::create( [
                'id'                => $record['id'],
                'uic'               => $record['uic'] ? (integer) $record['uic'] : null,
                'uic8_sncf'         => $record['uic8_sncf'] ? (integer) $record['uic8_sncf'] : null,
                'name'              => $record['name'],
                'parent_station_id' => $record['parent_station_id'] ? (integer) $record['parent_station_id'] : null,
                'slug'              => $record['slug'],
                'country'           => $record['country'],
                'timezone'          => $record['time_zone'],
                'sncf_id'           => $record['sncf_id'],
                'same_as'           => $record['same_as'] ? (integer) $record['same_as'] : null,
                'is_suggestable'    => $record['is_suggestable'] == 't',
                'data'              => json_encode( [
                    'name_fr'         => $this->valueOrNull($record['info:fr']),
                    'name_en'         => $this->valueOrNull($record['info:en']),
                    'latitude'        => $this->valueOrNull($record['latitude']),
                    'longitude'       => $this->valueOrNull($record['longitude']),
                    'is_city'         => $record['is_city'] == 't',
                    'is_main_station' => $record['is_main_station'] == 't',
                    'is_airport'      => $record['is_airport'] == 't',
                    'sncf_tvs_id'     => $this->valueOrNull($record['sncf_tvs_id']),
                    'idtgv_id'        => $this->valueOrNull($record['idtgv_id']),
                    'db_id'           => $this->valueOrNull($record['db_id']),
                    'busbud_id'       => $this->valueOrNull($record['busbud_id']),
                    'distribusion_id' => $this->valueOrNull($record['distribusion_id']),
                    'flixbus_id'      => $this->valueOrNull($record['flixbus_id']),
                    'leoexpress_id'   => $this->valueOrNull($record['leoexpress_id']),
                    'obb_id'          => $this->valueOrNull($record['obb_id']),
                    'ouigo_id'        => $this->valueOrNull($record['ouigo_id']),
                    'trenitalia_id'   => $this->valueOrNull($record['trenitalia_id']),
                    'ntv_rtiv_id'     => $this->valueOrNull($record['ntv_rtiv_id']),
                    'ntv_id'          => $this->valueOrNull($record['ntv_id']),
                    'hkx_id'          => $this->valueOrNull($record['hkx_id']),
                    'renfe_id'        => $this->valueOrNull($record['renfe_id']),
                    'atoc_id'         => $this->valueOrNull($record['atoc_id']),
                    'benerail_id'     => $this->valueOrNull($record['benerail_id']),
                    'westbahn_id'     => $this->valueOrNull($record['westbahn_id']),
                ] )
            ] );
            echo '.';
        }
        echo "\nDone.\n";

    }
}
