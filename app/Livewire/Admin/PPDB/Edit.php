<?php

namespace App\Livewire\Admin\PPDB;

use App\Models\PPDB;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Update Peserta Didik')]
#[Layout('components.layouts.admin-app')]
class Edit extends Component
{
    public $ppdbId;
    
    // Data Siswa
    public $nama_lengkap = '';
    public $tempat_lahir = '';
    public $tanggal_lahir = '';
    public $jenis_kelamin = '';
    public $anak_ke = '';
    public $jumlah_saudara = '';
    public $alamat_siswa = '';

    // Data Orang Tua
    public $nama_ayah = '';
    public $pekerjaan_ayah = '';
    public $nama_ibu = '';
    public $pekerjaan_ibu = '';
    public $alamat_ortu = '';
    public $nomor_telepon = '';

    public function mount($id = null) 
    {
        if ($id) {
            $this->ppdbId = $id;
            $siswa = PPDB::findOrFail($id);
            
            $this->nama_lengkap = $siswa->nama_lengkap;
            $this->tempat_lahir = $siswa->tempat_lahir;
            $this->tanggal_lahir = $siswa->tanggal_lahir;
            $this->jenis_kelamin = $siswa->jenis_kelamin;
            $this->anak_ke = $siswa->anak_ke;
            $this->jumlah_saudara = $siswa->jumlah_saudara;
            $this->alamat_siswa = $siswa->alamat_siswa;
            $this->nama_ayah = $siswa->nama_ayah;
            $this->pekerjaan_ayah = $siswa->pekerjaan_ayah;
            $this->nama_ibu = $siswa->nama_ibu;
            $this->pekerjaan_ibu = $siswa->pekerjaan_ibu;
            $this->alamat_ortu = $siswa->alamat_ortu;
            $this->nomor_telepon = $siswa->nomor_telepon;
        }
    }

    public function kirimPendaftaran()
    {
        $this->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'anak_ke' => 'required|integer|min:1',
            'jumlah_saudara' => 'required|integer|min:0',
            'alamat_siswa' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'alamat_ortu' => 'required|string',
            'nomor_telepon' => 'required|string|max:20',
        ]);

        try {
            $siswa = PPDB::findOrFail($this->ppdbId);
            $siswa->update([
                'nama_lengkap' => $this->nama_lengkap,
                'tempat_lahir' => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'anak_ke' => $this->anak_ke,
                'jumlah_saudara' => $this->jumlah_saudara,
                'alamat_siswa' => $this->alamat_siswa,
                'nama_ayah' => $this->nama_ayah,
                'pekerjaan_ayah' => $this->pekerjaan_ayah,
                'nama_ibu' => $this->nama_ibu,
                'pekerjaan_ibu' => $this->pekerjaan_ibu,
                'alamat_ortu' => $this->alamat_ortu,
                'nomor_telepon' => $this->nomor_telepon,
            ]);

            session()->flash('success', 'Data peserta didik berhasil diperbarui!');
            return redirect()->route('ppdb');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function render()
    {
        return view('livewire.admin.ppdb.edit');
    }
}
