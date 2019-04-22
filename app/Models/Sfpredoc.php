<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredoc extends Model
{
    protected $table = 'sfpredoc';

    protected $fillable = [
        'txtObser'
    ];

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
