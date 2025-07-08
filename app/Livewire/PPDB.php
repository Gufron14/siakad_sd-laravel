<?php

namespace App\Livewire;

use App\Models\PPDB as PPDBModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('PPDB')]

class PPDB extends Component
{
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
    
    public $existingRegistration = null;
    
    protected $rules = [
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
    ];
    
    protected $messages = [
        'nama_lengkap.required' => 'Nama lengkap wajib diisi',
        'tempat_lahir.required' => 'Tempat lahir wajib diisi',
        'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
        'anak_ke.required' => 'Anak ke wajib diisi',
        'jumlah_saudara.required' => 'Jumlah saudara wajib diisi',
        'alamat_siswa.required' => 'Alamat siswa wajib diisi',
        'nama_ayah.required' => 'Nama ayah wajib diisi',
        'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi',
        'nama_ibu.required' => 'Nama ibu wajib diisi',
        'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib diisi',
        'alamat_ortu.required' => 'Alamat orang tua wajib diisi',
        'nomor_telepon.required' => 'Nomor telepon wajib diisi',
    ];
    
    // public function mount()
    // {
    //     $this->existingRegistration = PPDBModel::where('user_id', Auth::id())->first();
    // }
    
    public function kirimPendaftaran()
    {
        $this->validate();
        
        try {
            PPDBModel::create([
                // 'user_id' => Auth::id(),
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

            session()->flash('success', 'Formulir pendaftaran berhasil dikirim!');
            
            // $this->existingRegistration = PPDBModel::where('user_id', Auth::id())->first();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat mengirim formulir. Silakan coba lagi.');
        }
    }
    
    public function render()
    {
        return view('livewire.ppdb');
    }
}
