class AbsensiEkstra extends Model
{
    use HasFactory;

    protected $table = 'absensi_ekstras';

    protected $fillable = ['siswa_id', 'ekstrakurikuler_id', 'tanggal', 'status_kehadiran'];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }
}
