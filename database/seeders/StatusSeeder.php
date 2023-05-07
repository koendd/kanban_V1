<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requested = new Status();
        $requested->name = "Requested";
        $requested->description = "These tasks are requested by the applicants but not yet approved!";
        $requested->order_number = 1;
        $requested->preparetion = true;
        $requested->active = false;
        $requested->finishing = false;
        $requested->color = 0x3333FF;
        $requested->save();

        $approved = new Status();
        $approved->name = "Approved";
        $approved->description = "These tasks are approved and ready to start with";
        $approved->order_number = 2;
        $approved->preparetion = true;
        $approved->active = false;
        $approved->finishing = false;
        $approved->color = 0x33FF33;
        $approved->save();

        $startup = new Status();
        $startup->name = "Start-Up";
        $startup->description = "These job are ready to start";
        $startup->order_number = 3;
        $startup->preparetion = true;
        $startup->active = true;
        $startup->finishing = false;
        $startup->color = 0x33FF33;
        $startup->save();

        $preparing = new Status();
        $preparing->name = "Preparing";
        $preparing->description = "These tasks need some more information from the the applicants, materials, requirements";
        $preparing->order_number = 4;
        $preparing->preparetion = false;
        $preparing->active = true;
        $preparing->finishing = false;
        $preparing->color = 0x33FF33;
        $preparing->save();

        $busy = new Status();
        $busy->name = "Busy";
        $busy->description = "Somebody is working on this task";
        $busy->order_number = 5;
        $busy->preparetion = false;
        $busy->active = true;
        $busy->finishing = false;
        $busy->color = 0xFFFF11;
        $busy->save();

        $waitingForMaterials = new Status();
        $waitingForMaterials->name = "Waiting for materials";
        $waitingForMaterials->description = "This taks is temporary on hold because not all materials are available";
        $waitingForMaterials->order_number = 6;
        $waitingForMaterials->preparetion = false;
        $waitingForMaterials->active = true;
        $waitingForMaterials->finishing = false;
        $waitingForMaterials->color = 0xFF11FF;
        $waitingForMaterials->save();

        $executable = new Status();
        $executable->name = "Executable";
        $executable->description = "";
        $executable->order_number = 7;
        $executable->preparetion = false;
        $executable->active = true;
        $executable->finishing = false;
        $executable->color = 0xFF0000;
        $executable->save();

        $followUp = new Status();
        $followUp->name = "Follow Up";
        $followUp->description = "";
        $followUp->order_number = 8;
        $followUp->preparetion = false;
        $followUp->active = true;
        $followUp->finishing = true;
        $followUp->color = 0x333333;
        $followUp->save();

        $handled = new Status();
        $handled->name = "Handled";
        $handled->description = "These tasks have been fully addressed";
        $handled->order_number = 9;
        $handled->preparetion = false;
        $handled->active = false;
        $handled->finishing = true;
        $handled->color = 0xDDDDDD;
        $handled->save();
    }
}
