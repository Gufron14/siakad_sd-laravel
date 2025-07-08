<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Kelas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Title('Pembagian Kelas')]
#[Layout('components.layouts.admin-app')]

class PembagianKelas extends Component
{
    use WithPagination;

    public $selectedGuru = [];
    public $showModal = false;
    public $modalType = 'create'; // create, edit
    public $guruId;
    public $name = '';
    public $email = '';
    public $nip = '';
    public $phone = '';
    public $address = '';
    public $password = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'nip' => 'required|string|unique:users,nip',
        'phone' => 'nullable|string',
        'address' => 'nullable|string',
        'password' => 'required|min:6'
    ];

    public function mount()
    {
        $this->loadSelectedGuru();
    }

    public function loadSelectedGuru()
    {
        $kelas = Kelas::with('guru')->get();
        foreach ($kelas as $k) {
            if ($k->guru_id) {
                $this->selectedGuru[$k->nama] = $k->guru_id;
            }
        }
    }

    public function updateWaliKelas($tingkat, $guruId)
    {
        $kelas = Kelas::where('nama', $tingkat)->first();
        
        if ($kelas) {
            // Reset guru lain yang mungkin sudah mengajar kelas ini
            if ($kelas->guru_id && $kelas->guru_id != $guruId) {
                $oldKelas = Kelas::where('guru_id', $kelas->guru_id)->first();
                if ($oldKelas) {
                    $oldKelas->update(['guru_id' => null]);
                }
            }

            // Reset kelas lain yang mungkin diajar oleh guru ini
            if ($guruId) {
                Kelas::where('guru_id', $guruId)->update(['guru_id' => null]);
            }

            $kelas->update(['guru_id' => $guruId ?: null]);
            $this->selectedGuru[$tingkat] = $guruId;
        }

        session()->flash('message', 'Wali kelas berhasil diperbarui!');
    }

    public function saveAllPembagian()
    {
        foreach ($this->selectedGuru as $tingkat => $guruId) {
            if ($guruId) {
                $this->updateWaliKelas($tingkat, $guruId);
            }
        }

        session()->flash('message', 'Semua pembagian kelas berhasil disimpan!');
    }

    public function openModal($type = 'create', $id = null)
    {
        $this->modalType = $type;
        $this->showModal = true;
        $this->resetForm();

        if ($type === 'edit' && $id) {
            $guru = User::findOrFail($id);
            $this->guruId = $guru->id;
            $this->name = $guru->name;
            $this->email = $guru->email;
            $this->nip = $guru->nip;
            $this->phone = $guru->phone;
            $this->address = $guru->address;
            
            // Update validation rules for edit
            $this->rules['email'] = 'required|email|unique:users,email,' . $id;
            $this->rules['nip'] = 'required|string|unique:users,nip,' . $id;
            $this->rules['password'] = 'nullable|min:6';
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->guruId = null;
        $this->name = '';
        $this->email = '';
        $this->nip = '';
        $this->phone = '';
        $this->address = '';
        $this->password = '';
        $this->resetValidation();
    }

    public function saveGuru()
    {
        if ($this->modalType === 'edit') {
            $this->rules['password'] = 'nullable|min:6';
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'nip' => $this->nip,
            'phone' => $this->phone,
            'address' => $this->address,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->modalType === 'create') {
            $guru = User::create($data);
            $guru->assignRole('guru');
            session()->flash('message', 'Guru berhasil ditambahkan!');
        } else {
            $guru = User::findOrFail($this->guruId);
            $guru->update($data);
            session()->flash('message', 'Guru berhasil diperbarui!');
        }

        $this->closeModal();
    }

    public function deleteGuru($id)
    {
        $guru = User::findOrFail($id);
        
        // Reset kelas jika guru ini adalah wali kelas
        if ($guru->kelas) {
            $guru->kelas->update(['guru_id' => null]);
        }

        $guru->delete();
        session()->flash('message', 'Guru berhasil dihapus!');
    }

    public function render()
    {
        $kelas = Kelas::with('guru')->orderBy('nama')->get();
        $allGuru = User::guru()->get();
        $guruList = User::guru()->paginate(10);

        return view('livewire.admin.pembagian-kelas', [
            'kelas' => $kelas,
            'allGuru' => $allGuru,
            'guruList' => $guruList
        ]);
    }
}
