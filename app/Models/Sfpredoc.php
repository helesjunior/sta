<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredoc extends Model
{
    protected $table = 'sfpredoc';

    protected $fillable = [
        'txtObser'
    ];


    public function createFromXML(array $predoc)
    {
        $this->fill($predoc);
        $this->sfpredocable()->associate($predoc['morph']);
        $this->save();


        $this->createPredocDarfFromXml($predoc);
        $this->createPredocObFromXml($predoc);
        $this->createPredocNsFromXml($predoc);
        $this->createPredocDarFromXml($predoc);
        $this->createPredocGfipFromXml($predoc);
        $this->createPredocGpsFromXml($predoc);
        $this->createPredocGruFromXml($predoc);
        $this->createPredocPfFromXml($predoc);

        return $this;
    }

    private function createPredocObFromXml(array $dado)
    {
        if (!isset($dado['predocOB'])) {
            return;
        }
        $predocOB = $dado['predocOB'];

        $predocOB['sfpredoc_id'] = $this->id;
        $sfpredocob = new Sfpredocob;
        $sfpredocob->createFromXml($predocOB);
    }

    private function createPredocNsFromXml(array $dado)
    {
        if (!isset($dado['predocNS'])) {
            return;
        }
        $predocNS = $dado['predocNS'];

        $predocNS['sfpredoc_id'] = $this->id;
        $sfpredocns = new Sfpredocns;
        $sfpredocns->createFromXml($predocNS);
    }

    private function createPredocDarfFromXml(array $dado)
    {
        if (!isset($dado['predocDARF'])) {
            return;
        }
        $predocDARF = $dado['predocDARF'];

        $predocDARF['sfpredoc_id'] = $this->id;
        $sfpredocdarf = new Sfpredocdarf;
        $sfpredocdarf->createFromXml($predocDARF);
    }

    private function createPredocDarFromXml(array $dado)
    {
        if (!isset($dado['predocDAR'])) {
            return;
        }
        $predocDAR = $dado['predocDAR'];

        $predocDAR['sfpredoc_id'] = $this->id;
        $sfpredocdar = new Sfpredocdar;
        $sfpredocdar->createFromXml($predocDAR);
    }

    private function createPredocGfipFromXml(array $dado)
    {
        if (!isset($dado['predocGFIP'])) {
            return;
        }
        $predocGFIP = $dado['predocGFIP'];

        $predocGFIP['sfpredoc_id'] = $this->id;
        $sfpredocgfip = new Sfpredocgfip;
        $sfpredocgfip->createFromXml($predocGFIP);
    }

    private function createPredocGpsFromXml(array $dado)
    {
        if (!isset($dado['predocGPS'])) {
            return;
        }
        $predocGPS = $dado['predocGPS'];

        $predocGPS['sfpredoc_id'] = $this->id;
        $sfpredocgps = new Sfpredocgps;
        $sfpredocgps->createFromXml($predocGPS);
    }

    private function createPredocGruFromXml(array $dado)
    {
        if (!isset($dado['predocGRU'])) {
            return;
        }
        $predocGRU = $dado['predocGRU'];

        $predocGRU['sfpredoc_id'] = $this->id;
        $sfpredocgru = new Sfpredocgru;
        $sfpredocgru->createFromXml($predocGRU);
    }

    private function createPredocPfFromXml(array $dado)
    {
        if (!isset($dado['predocPF'])) {
            return;
        }
        $predocPF = $dado['predocPF'];

        $predocPF['sfpredoc_id'] = $this->id;
        $sfpredocpf = new Sfpredocpf;
        $sfpredocpf->createFromXml($predocPF);
    }


    public function sfpredocable()
    {
        return $this->morphTo();
    }

    public function predocOB()
    {
        return $this->hasOne(Sfpredocob::class);
    }

    public function predocNS()
    {
        return $this->hasOne(Sfpredocns::class);
    }

    public function predocDARF()
    {
        return $this->hasOne(Sfpredocdarf::class);
    }

    public function predocDAR()
    {
        return $this->hasOne(Sfpredocdar::class);
    }

    public function predocGRU()
    {
        return $this->hasOne(Sfpredocgru::class);
    }

    public function predocGPS()
    {
        return $this->hasOne(SfpredocGPS::class);
    }

    public function predocGFIP()
    {
        return $this->hasOne(Sfpredocgfip::class);
    }

    public function predocPF()
    {
        return $this->hasOne(Sfpredocpf::class);
    }


}
