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
            'judul' => [
                'rules'     => 'required|is_unique[komik.judul]',
                'errors'    => [
                    'required'  => 'Judul komik harus diisi.',
                    'is_unique' => 'Judul komik sudah ada, silakan input {field} lainnya.'
                ]
            ],
            'penulis' => [
                'rules'     => 'required',
                'errors'    => ['required' => 'Nama penulis harus diisi.']
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar terlalu besar, maksimal 2 Mb.',
                    // 'uploaded'  => 'Silakan pilih gambar sampul terlebih dahulu.',
                    'is_image'  => 'File salah. Anda bukan memilih gambar.',
                    'mime_in'   => 'File anda bukan gambar.'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/komik/create')->withInput();
        }
        // dd($this->request->getVar());

        //ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        //apakah tidak ada gambar yang di apload
        if($fileSampul->getError() == 4) {
            $namaSampul = 'noimage.jpg';
        } else {
            //generate nama sampul
            $namaSampul = $fileSampul->getRandomName();
            //pindahkan file ke folder server
            $fileSampul->move('img/komik', $namaSampul);
            //ambil nama file
            // $namaSampul = $fileSampul->getName();
        }


        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
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

    public function edit($slug)
    {
        $data = [
            'judultab' => 'Form Ubah Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        //cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        if(!$this->validate([
            // 'judul' => 'required|is_unique[komik.judul]',
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah ada, silakan input {field} lainnya.'
                ]
            ],
            'penulis' => 'required'
        ])) {
            $validation = \Config\Services::validation();
            // dd($validation); //nangkep
            return redirect()->to('/komik/edit/'. $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }
        // dd($this->request->getVar()); //melihat semua inputan
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);
        // return view('komik/save', $data);
        session()->setFlashdata('pesan_tambah','data komik telah diubah.');
        return redirect()->to('/komik');
    }


    //--------------------------------------------------------------------

}
