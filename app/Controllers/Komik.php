<?php

namespace App\Controllers;
use App\Models\KomikModel;
use CodeIgniter\HTTP\Request;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        // $komik = $this->komikModel->findAll();

        $data = [
            'judultab' => 'Koleksi Komik',
            // 'komik' => $komik,
            'komik' => $this->komikModel->getKomik()
        ];

        
        // dd($komik);

        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        // echo $slug;
        // $komik = $this->komikModel->where(['slug' => $slug])->first();
        
        // dd($komik);
        
        $data = [
            'judultab' => 'Detail Koleksi Komik',
            // 'komik' => $komik,
            'komik' => $komik = $this->komikModel->getKomik($slug)
        ];
        //jika komik tidak ada di tabel
        if(empty($data['komik'])) throw new \CodeIgniter\Exceptions\PageNotFoundException('Maaf, judul Komik "'. $slug . '" tidak ditemukan.');

        return view('komik/detail', $data);
    }

    public function create()
    {
        // session();
        $data = [
            'judultab' => 'Form Tambah Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        if(!$this->validate([
            // 'judul' => 'required|is_unique[komik.judul]',
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah ada, silakan input {field} lainnya.'
                ]
            ],
            'penulis' => 'required'
        ])) {
            $validation = \Config\Services::validation();
            // dd($validation); //nangkep
            return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
        }
        // dd($this->request->getVar());
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);
        // return view('komik/save', $data);
        session()->setFlashdata('pesan_tambah','data komik ditambahkan.');
        return redirect()->to('/komik');
    }

    public function delete($id = null)
    {
        $this->komikModel->delete($id);
        session()->setFlashdata('pesan_hapus','data komik dihapus.');
        return redirect()->to('/komik');
    }


    //--------------------------------------------------------------------

}
