<?php

namespace App\Controllers;

class Pages extends BaseController
{
	public function index()
	{
		$data = [
			'judultab' => 'Web Komik Kita',
			'arrai' => ['satu', 'dua', 'tigaaa']
		];
		return view('pages/home', $data);
	}

	public function about()
	{
		$data = [
			'judultab' => 'Tentang Komik Kita'
		];
		return view('pages/about', $data);
	}

	public function kontak()
	{
		$data = [
			'judultab' => 'Hubungi Kami',
			'alamat' => [
				[
					'tipe' => 'Rumah',
					'alamat' => 'Jl. Raberas No. 43',
					'kota' => 'Sumbawa'
				],
				[
					'tipe' => 'Kantor',
					'alamat' => 'Jl. Nusantara No.351',
					'kota' => 'Sumbawa Barat'
				]
			]
		];
		return view('pages/kontak', $data);
	}
	//--------------------------------------------------------------------

}
