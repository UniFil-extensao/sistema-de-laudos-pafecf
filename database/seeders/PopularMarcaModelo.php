<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;

class PopularMarcaModelo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apb = Marca::create(["nome"=>"APB"]);
        $bematech = Marca::create(["nome"=>"BEMATECH"]);
        $daruma = Marca::create(["nome"=>"DARUMA AUTOMACAO"]);
        $datageris = Marca::create(["nome"=>"DATAREGIS"]);
        $elgin_amazonia = Marca::create(["nome"=>"ELGIN (AMAZONIA)"]);
        $epson = Marca::create(["nome"=>"EPSON"]);
        $ncr = Marca::create(["nome"=>"NCR"]);
        $itautec = Marca::create(["nome"=>"ITAUTEC"]);
        $perto = Marca::create(["nome"=>"PERTO"]);
        $sonda = Marca::create(["nome"=>"SONDA"]);
        $sweda = Marca::create(["nome"=>"SWEDA"]);
        $ibm = Marca::create(["nome"=>"IBM"]);
        $urano = Marca::create(["nome"=>"URANO"]);
        $zpm = Marca::create(["nome"=>"ZPM"]);

        $daruma->modelos()->create(["nome"=>"FS2100 T"]);
        $daruma->modelos()->create(["nome"=>"FS2100 T"]);
        $daruma->modelos()->create(["nome"=>"FS2100 T"]);
        $daruma->modelos()->create(["nome"=>"FS2100 T"]);
        $daruma->modelos()->create(["nome"=>"MACH 3"]);
        $daruma->modelos()->create(["nome"=>"FS600 USB"]);
        $daruma->modelos()->create(["nome"=>"FS700 L"]);
        $daruma->modelos()->create(["nome"=>"FS700 H"]);
        $daruma->modelos()->create(["nome"=>"FS700 M"]);
        $daruma->modelos()->create(["nome"=>"MACH 2"]);
        $daruma->modelos()->create(["nome"=>"FS600"]);
        $daruma->modelos()->create(["nome"=>"FS600"]);
        $daruma->modelos()->create(["nome"=>"FS600"]);
        $daruma->modelos()->create(["nome"=>"MACH 1"]);
        $daruma->modelos()->create(["nome"=>"FS800I"]);
        $daruma->modelos()->create(["nome"=>"FS800I"]);
        $daruma->modelos()->create(["nome"=>"FS420"]);
        $daruma->modelos()->create(["nome"=>"FS420"]);

        $datageris->modelos()->create(["nome"=>"3202DT"]);
        $datageris->modelos()->create(["nome"=>"3202DT"]);
        $datageris->modelos()->create(["nome"=>"3202DT"]);
        $datageris->modelos()->create(["nome"=>"6000EP"]);
        $datageris->modelos()->create(["nome"=>"6000EP"]);
        $datageris->modelos()->create(["nome"=>"MT100"]);
        $datageris->modelos()->create(["nome"=>"MT100"]);

        $elgin_amazonia->modelos()->create(["nome"=>"IF 6000TH"]);
        $elgin_amazonia->modelos()->create(["nome"=>"IF 6000TH"]);
        $elgin_amazonia->modelos()->create(["nome"=>"K"]);
        $elgin_amazonia->modelos()->create(["nome"=>"K"]);
        $elgin_amazonia->modelos()->create(["nome"=>"ELGIN FIT"]);
        $elgin_amazonia->modelos()->create(["nome"=>"X5"]);
        $elgin_amazonia->modelos()->create(["nome"=>"FX7"]);


        $epson->modelos()->create(["nome"=>"TM-T88 FB"]);
        $epson->modelos()->create(["nome"=>"TM-T88 FB"]);
        $epson->modelos()->create(["nome"=>"TM-T81 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T81 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T81 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T81 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T81 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T81 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-H6000 FB"]);
        $epson->modelos()->create(["nome"=>"TM-H6000 FB"]);
        $epson->modelos()->create(["nome"=>"TM-H6000 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-H6000 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-H6000 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-H6000 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-H6000 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T88 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T88 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T88 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T88 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T88 FBII"]);
        $epson->modelos()->create(["nome"=>"TM-T88 FBIII"]);
        $epson->modelos()->create(["nome"=>"TM-T88 FBIII"]);
        $epson->modelos()->create(["nome"=>"TM-T81 FBIII"]);
        $epson->modelos()->create(["nome"=>"TM-T81 FBIII"]);
        $epson->modelos()->create(["nome"=>"TM-H6000 FBIII"]);
        $epson->modelos()->create(["nome"=>"TM-H6000 FBIII"]);
        $epson->modelos()->create(["nome"=>"TM-T800F"]);
        $epson->modelos()->create(["nome"=>"TM-T800F"]);
        $epson->modelos()->create(["nome"=>"TM-T900F"]);
        $epson->modelos()->create(["nome"=>"TM-T900F"]);
        $epson->modelos()->create(["nome"=>"TM-T900F"]);
        $epson->modelos()->create(["nome"=>"TM-T900F"]);

        $bematech->modelos()->create(["nome"=>"MP-3000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-3000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-4000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-4000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI II"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI II"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI II"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI II"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI II"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI II"]);
        $bematech->modelos()->create(["nome"=>"MP-4200 TH FI II"]);
        $bematech->modelos()->create(["nome"=>"MP-6100 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-2100 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-2100 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-2100 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-7000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"MP-7000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"ECF-IF MP 2000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"ECF-IF MP 2000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"ECF-IF MP 6000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"ECF-IF MP 6000 TH FI"]);
        $bematech->modelos()->create(["nome"=>"ECF-IF MP 6000 TH FI"]);

        $ncr->modelos()->create(["nome"=>"7197"]);
        $ncr->modelos()->create(["nome"=>"7197"]);
        $ncr->modelos()->create(["nome"=>"7197"]);
        $ncr->modelos()->create(["nome"=>"7167"]);
        $ncr->modelos()->create(["nome"=>"7167"]);
        $ncr->modelos()->create(["nome"=>"7167"]);

        $itautec->modelos()->create(["nome"=>"INFOWAY 1E T1"]);
        $itautec->modelos()->create(["nome"=>"INFOWAY 1E T1"]);
        $itautec->modelos()->create(["nome"=>"QW PRINTER 1E T3"]);
        $itautec->modelos()->create(["nome"=>"INFOWAY 1E T2"]);
        $itautec->modelos()->create(["nome"=>"INFOWAY 1E T2"]);
        $itautec->modelos()->create(["nome"=>"QW PRINTER 6000 MT2"]);
        $itautec->modelos()->create(["nome"=>"QW PRINTER 6000 MT2"]);
        $itautec->modelos()->create(["nome"=>"KUBUS 1EF"]);
        $itautec->modelos()->create(["nome"=>"KUBUS 1EF"]);

        $perto->modelos()->create(["nome"=>"PERTOCHEK FP"]);
        $perto->modelos()->create(["nome"=>"PERTOPRINTER 1EF"]);
        $perto->modelos()->create(["nome"=>"PERTO PRINTER II 1EF"]);
        $perto->modelos()->create(["nome"=>"PERTO PRINTER II 1EF"]);
        $perto->modelos()->create(["nome"=>"PERTO PRINTER II 1EF"]);

        $apb->modelos()->create(["nome"=>"MSD 6600 IF"]);

        $sonda->modelos()->create(["nome"=>"SIM-67"]);
        $sonda->modelos()->create(["nome"=>"SIM-67"]);
        $sonda->modelos()->create(["nome"=>"SIM-67"]);
        $sonda->modelos()->create(["nome"=>"SIM-97"]);
        $sonda->modelos()->create(["nome"=>"SIM-97"]);
        $sonda->modelos()->create(["nome"=>"SIM-97"]);

        $sweda->modelos()->create(["nome"=>"IF ST1000"]);
        $sweda->modelos()->create(["nome"=>"IF ST1000"]);
        $sweda->modelos()->create(["nome"=>"IF ST120"]);
        $sweda->modelos()->create(["nome"=>"IF ST120"]);
        $sweda->modelos()->create(["nome"=>"IF ST200"]);
        $sweda->modelos()->create(["nome"=>"IF ST200"]);
        $sweda->modelos()->create(["nome"=>"IF ST2000"]);
        $sweda->modelos()->create(["nome"=>"IF ST100"]);
        $sweda->modelos()->create(["nome"=>"IF ST100"]);
        $sweda->modelos()->create(["nome"=>"IF ST100"]);
        $sweda->modelos()->create(["nome"=>"IF ST2500"]);

        $ibm->modelos()->create(["nome"=>"4610-KN4"]);
        $ibm->modelos()->create(["nome"=>"4610-KN4"]);
        $ibm->modelos()->create(["nome"=>"4610-SJ6"]);
        $ibm->modelos()->create(["nome"=>"4610-SJ6"]);
        $ibm->modelos()->create(["nome"=>"4610-SJ6"]);
        $ibm->modelos()->create(["nome"=>"4610-KJ4"]);
        $ibm->modelos()->create(["nome"=>"4610-KJ4"]);
        $ibm->modelos()->create(["nome"=>"4610-KR4"]);
        $ibm->modelos()->create(["nome"=>"4610-KR4"]);
        $ibm->modelos()->create(["nome"=>"4610-KR4"]);

        $urano->modelos()->create(["nome"=>"URANO/1FIT LOGGER"]);
        $urano->modelos()->create(["nome"=>"URANO/1FIT LOGGER"]);

        $zpm->modelos()->create(["nome"=>"ZPM/1FIT LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM/1FIT LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM/1FIT LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM/2EFC LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM/2EFC LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM/2EFC LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM/2EFC LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM/3EF LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM/3EF LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM/II FIT LOGGER"]);
        $zpm->modelos()->create(["nome"=>"ZPM-200"]);
        $zpm->modelos()->create(["nome"=>"ZPM-200"]);
        $zpm->modelos()->create(["nome"=>"ZPM-300"]);
        $zpm->modelos()->create(["nome"=>"ZPM-300"]);
        $zpm->modelos()->create(["nome"=>"ZPM-400"]);
        $zpm->modelos()->create(["nome"=>"ZPM-400"]);
        $zpm->modelos()->create(["nome"=>"ZPM-500"]);
        $zpm->modelos()->create(["nome"=>"ZPM-500"]);

    }
}
