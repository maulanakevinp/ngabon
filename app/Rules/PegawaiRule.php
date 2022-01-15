<?php

namespace App\Rules;

use App\Models\Kasbon;
use App\Models\Pegawai;
use Illuminate\Contracts\Validation\Rule;

class PegawaiRule implements Rule
{
    private $gagal_kasbon = false, $kasbon = 0;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($kasbon)
    {
        $this->kasbon = $kasbon;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pegawai = Pegawai::find($value);
        if ($pegawai) {
            if ($pegawai->tanggal_masuk > date('Y-m-d', strtotime('-1 years'))) {
                $kasbon = Kasbon::where('pegawai_id',$pegawai->id)->whereMonth('tanggal_diajukan', date('m'))->whereYear('tanggal_diajukan', date('Y'))->get();
                if (count($kasbon) <= 3) {
                    $total_kasbon = 0;
                    foreach ($kasbon as $item) {
                        $total_kasbon += $item->total_kasbon;
                    }
                    $persentase = (($total_kasbon + $this->kasbon) / $pegawai->total_gaji) * 100;
                    if ($persentase <=50) {
                        return true;
                    }
                    $this->gagal_kasbon = true;
                    return false;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->gagal_kasbon) {
            return 'Total kasbon dalam 1 bulan tidak boleh lebih dari 50% total gaji';
        }
        return 'Pegawai tidak ditemukan.';
    }
}
