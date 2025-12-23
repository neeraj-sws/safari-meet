<?php

namespace Database\Seeders;

use App\Models\{Park, ParkDetailsTabs, ParkInformationModel, ParkTabs};
use Illuminate\Database\Seeder;

class ParkInformationSeeder extends Seeder
{
    public function run()
    {
        $parkLists = Park::all();

        foreach ($parkLists as $parkList) {

            if (ParkInformationModel::where('park_id', $parkList->id)->exists()) {
                continue;
            }

            $this->createParkInformation($parkList->id);
        }
    }

    public function createParkInformation($parkId)
    {
        ParkInformationModel::create([
            'park_id' => $parkId,
            'information' => $this->dummyDescription(),
            'booking_process' => $this->dummyDescription(),
            'dos_image' => "https://loremflickr.com/800/600/animal?rand=" . mt_rand(10000, 99999),
            'donts_image' => "https://loremflickr.com/800/600/animal?rand=" . mt_rand(10000, 99999),
            'dos_description' => $this->dummyDescription(),
            'donts_description' => $this->dummyDescription(),
        ]);
    }

    private function dummyDescription()
    {
        return "
            <p>Lorem ipsum dolor sit amet consectetur adipiscing elit tristique donec dapibus vitae, vestibulum ullamcorper nullam curabitur pharetra ligula curae nec vivamus per risus, inceptos eros odio tincidunt gravida sed potenti ad mi proin. Tempor mollis fringilla dapibus enim aliquet ligula posuere tellus etiam, nostra justo blandit volutpat libero vestibulum nibh dignissim, cursus faucibus malesuada pretium facilisis conubia ultricies himenaeos. Feugiat aptent vestibulum justo parturient duis taciti tincidunt mattis, phasellus himenaeos dictum suspendisse ornare eu metus diam, tortor commodo senectus eleifend euismod vulputate nascetur. Ullamcorper venenatis molestie ut est lacus dui volutpat, cras sed massa pellentesque eros conubia, velit consequat a porttitor nisl placerat. Praesent bibendum cursus lobortis cras etiam litora natoque nostra, scelerisque nisl mollis imperdiet dictumst fames vitae ac, commodo conubia gravida inceptos diam aliquet malesuada.</p>
            <p>Vestibulum tortor maecenas pulvinar senectus dignissim fermentum pharetra accumsan, potenti ante eros imperdiet scelerisque vehicula nunc montes, venenatis pretium felis neque at massa iaculis. Himenaeos luctus semper potenti fusce mauris litora aptent, lectus inceptos ac sollicitudin id nam volutpat vel, porttitor tortor lacus nisi cras facilisis. Vehicula metus egestas lacinia massa justo eget class aliquet leo, lobortis ultrices nunc suscipit vestibulum mus nisi sociosqu, feugiat pharetra tristique nostra venenatis in magnis porttitor. Class congue turpis ornare cras quis at lacus nostra maecenas placerat rutrum, platea netus dictumst dictum pellentesque scelerisque faucibus parturient leo. Mattis suspendisse auctor pretium nulla nec tortor lacinia sollicitudin conubia ultricies velit, urna viverra sapien suscipit in etiam fermentum sodales imperdiet class. Et fermentum lectus habitasse ultricies ad fusce convallis, venenatis orci duis laoreet tortor suscipit vel integer, conubia nibh luctus neque commodo potenti. Inceptos curabitur venenatis hac convallis est sem augue, purus platea cum gravida tristique volutpat nec magnis, mattis leo dui dictum odio litora. Natoque quam pellentesque tincidunt vitae mollis suspendisse morbi phasellus vehicula habitasse volutpat potenti venenatis auctor netus ultrices, feugiat cubilia congue montes augue dui in neque litora donec parturient nisi blandit eu tristique. Lacinia massa vitae suspendisse cras mi gravida, penatibus et curabitur commodo habitant eros, sociosqu ullamcorper dapibus tristique nam. Fermentum congue netus tempus ultrices ligula nisl dui urna elementum imperdiet, tincidunt commodo et at justo leo nullam taciti inceptos, blandit aenean nec consequat natoque tortor ridiculus hac rhoncus.</p>
            <p>Lobortis in nulla eu scelerisque tristique urna, cras tellus vestibulum maecenas litora velit ante, non quisque himenaeos nullam donec. Purus est enim augue orci nascetur class at sem fusce, hac dictum libero et auctor ut pretium malesuada per, neque sollicitudin tincidunt habitasse nisl gravida integer fermentum. Erat dictumst quam consequat gravida placerat laoreet commodo non, cum est scelerisque semper arcu lacus integer enim accumsan, phasellus sociosqu nam felis dictum bibendum ornare. Volutpat elementum metus congue mus arcu quisque dictumst hendrerit nostra et mollis odio cras, cubilia porta dui fames in dignissim nibh risus ad himenaeos mattis aenean. Arcu lacus netus primis pretium fames vitae suspendisse diam, hendrerit ultricies varius pulvinar himenaeos aptent id, volutpat per malesuada viverra lobortis at magna.</p>
            <p>Porttitor dui iaculis euismod leo justo mus nibh non himenaeos, a libero condimentum consequat commodo etiam pulvinar augue hac facilisis, massa vitae dictum egestas vehicula sollicitudin imperdiet torquent. Cubilia id ac purus tempor montes fermentum, nam sodales facilisi cursus praesent, vel et proin aliquet condimentum. Rhoncus metus a pretium massa sed id suspendisse libero lacus, turpis ac feugiat malesuada placerat luctus dictum morbi class phasellus, scelerisque nullam nisl varius diam sollicitudin ante viverra.</p>
            <p>Per nascetur fusce interdum hendrerit himenaeos facilisi eleifend, imperdiet donec montes risus taciti mattis, senectus accumsan blandit ante ad aenean. Bibendum maecenas eros hac himenaeos mus porttitor mattis mollis velit tellus, senectus consequat ut fermentum vel natoque iaculis vitae platea, imperdiet nibh porta turpis facilisis hendrerit suscipit nec pellentesque. Lacinia curabitur litora placerat pulvinar interdum pellentesque sociis sodales, nunc aptent laoreet aliquet sapien montes pharetra tortor facilisis, hendrerit venenatis a nisi suscipit natoque ullamcorper. Duis leo gravida morbi non facilisi class eros, facilisis convallis nisi nascetur diam habitasse, tempor pulvinar conubia metus elementum placerat.</p>
        ";
    }
}
