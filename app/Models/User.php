<?php



namespace App\Models;



// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;



class User extends Authenticatable

{

    /** @use HasFactory<\Database\Factories\UserFactory> */

    use HasFactory, Notifiable;



    /**

     * The attributes that are mass assignable.

     *

     * @var list<string>

     */

    protected $fillable = [

        'name',

        'email',

        'password',
<<<<<<< HEAD

        'nisn_nik',

        'alamat',

=======
        'nisn_nik',
        'alamat',
>>>>>>> a6adbf5193a184152a171d35876dc6c673c84630
        'role',

        'id_kelas',
<<<<<<< HEAD

        'id_angkatan',

=======
        'id_angkatan',
>>>>>>> a6adbf5193a184152a171d35876dc6c673c84630
        'jenis_kelamin',

        'username',
<<<<<<< HEAD

        'id_sekolah',

        'no_telp',

        'tempat_lahir',

        'tanggal_lahir',

        'usia',

        'tanggal_masuk',

        'tanggal_lulus',

        'nama_orang_tua',

        'gaji_orang_tua',

        'jumlah_sodara',

=======
        'id_sekolah',
        'no_telp',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'tanggal_masuk',
        'tanggal_lulus',
        'nama_orang_tua',
        'gaji_orang_tua',
        'jumlah_sodara',
>>>>>>> a6adbf5193a184152a171d35876dc6c673c84630
    ];



    /**

     * The attributes that should be hidden for serialization.

     *

     * @var list<string>

     */

    protected $hidden = [

        'password',

        'remember_token',

    ];



    /**

     * Get the attributes that should be cast.

     *

     * @return array<string, string>

     */

    protected function casts(): array

    {

        return [

            'email_verified_at' => 'datetime',

            'password' => 'encrypted',
<<<<<<< HEAD

            'nisn_nik' => 'encrypted',

=======
            'nisn_nik' => 'encrypted',
>>>>>>> a6adbf5193a184152a171d35876dc6c673c84630
        ];

    }

}