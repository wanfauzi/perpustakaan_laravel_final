<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
    $kategori_list = [
        [
            'id' => 1,
            'nama' => 'Programming',
            'deskripsi' => 'Buku pemrograman dan coding',
            'jumlah_buku' => 25
        ],
        [
            'id' => 2,
            'nama' => 'Database',
            'deskripsi' => 'Buku database',
            'jumlah_buku' => 15
        ],
        [
            'id' => 3,
            'nama' => 'Networking',
            'deskripsi' => 'Buku jaringan komputer',
            'jumlah_buku' => 10
        ],
        [
            'id' => 4,
            'nama' => 'Web Design',
            'deskripsi' => 'Buku desain web',
            'jumlah_buku' => 12
        ],
        [
            'id' => 5,
            'nama' => 'Data Science',
            'deskripsi' => 'Buku data science',
            'jumlah_buku' => 20
        ]
    ];

    return view('kategori.index',
        compact('kategori_list'));
    }

    // Method show
    public function show($id)
    {
        $kategori_list = [

            [
                'id' => 1,
                'nama' => 'Programming',
                'deskripsi' => 'Buku pemrograman dan coding',
                'jumlah_buku' => 25
            ],

            [
                'id' => 2,
                'nama' => 'Database',
                'deskripsi' => 'Buku database',
                'jumlah_buku' => 15
            ],

            [
                'id' => 3,
                'nama' => 'Networking',
                'deskripsi' => 'Buku jaringan komputer',
                'jumlah_buku' => 10
            ],

            [
                'id' => 4,
                'nama' => 'Web Design',
                'deskripsi' => 'Buku desain web',
                'jumlah_buku' => 12
            ],

            [
                'id' => 5,
                'nama' => 'Data Science',
                'deskripsi' => 'Buku data science',
                'jumlah_buku' => 20
            ]

        ];

        $kategori = collect($kategori_list)
            ->firstWhere('id', (int)$id);

        if(!$kategori){
            abort(404);
        }

        switch ($id) {

            case 1:
                $buku_list = [
                    [
                        'judul' => 'Pemrograman PHP',
                        'penulis' => 'Budi Raharjo'
                    ],
                    [
                        'judul' => 'Laravel Framework',
                        'penulis' => 'Andi Nugroho'
                    ],
                    [
                        'judul' => 'JavaScript Modern',
                        'penulis' => 'Rina Wijaya'
                    ]
                ];
                break;

            case 2:
                $buku_list = [
                    [
                        'judul' => 'MySQL Database',
                        'penulis' => 'Siti Aminah'
                    ],
                    [
                        'judul' => 'PostgreSQL Dasar',
                        'penulis' => 'Ahmad Fauzi'
                    ]
                ];
                break;

            case 3:
                $buku_list = [
                    [
                        'judul' => 'Cisco Networking',
                        'penulis' => 'Rudi Hartono'
                    ],
                    [
                        'judul' => 'Mikrotik Router',
                        'penulis' => 'Dedi Santoso'
                    ]
                ];
                break;

            case 4:
                $buku_list = [
                    [
                        'judul' => 'HTML & CSS',
                        'penulis' => 'Eko Prasetyo'
                    ],
                    [
                        'judul' => 'Bootstrap 5',
                        'penulis' => 'Fitriani'
                    ]
                ];
                break;

            case 5:
                $buku_list = [
                    [
                        'judul' => 'Data Science dengan Python',
                        'penulis' => 'Wahyudi'
                    ],
                    [
                        'judul' => 'Machine Learning Dasar',
                        'penulis' => 'Rizky Saputra'
                    ]
                ];
                break;

            default:
                $buku_list = [];
            }
            return view(
                'kategori.show',
                compact('kategori', 'buku_list')
            );
        }
    // Method search
    public function search(Request $request)
    {
        $keyword = strtolower($request->keyword ?? '');

        $kategori_list = [
            [
                'id' => 1,
                'nama' => 'Programming',
                'deskripsi' => 'Buku pemrograman dan coding',
                'jumlah_buku' => 25
            ],
            [
                'id' => 2,
                'nama' => 'Database',
                'deskripsi' => 'Buku database',
                'jumlah_buku' => 15
            ],
            [
                'id' => 3,
                'nama' => 'Networking',
                'deskripsi' => 'Buku jaringan komputer',
                'jumlah_buku' => 10
            ],
            [
                'id' => 4,
                'nama' => 'Web Design',
                'deskripsi' => 'Buku desain web',
                'jumlah_buku' => 12
            ],
            [
                'id' => 5,
                'nama' => 'Data Science',
                'deskripsi' => 'Buku data science',
                'jumlah_buku' => 20
            ]
        ];

        $kategori_list = array_filter(
            $kategori_list,
            function ($kategori) use ($keyword) {

                return str_contains(
                    strtolower($kategori['nama']),
                    $keyword
                ) ||
                str_contains(
                    strtolower($kategori['deskripsi']),
                    $keyword
                );
            }
        );

        return view(
            'kategori.search',
            compact('keyword', 'kategori_list')
        );
    }
}