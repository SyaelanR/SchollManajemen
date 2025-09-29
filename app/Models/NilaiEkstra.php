class NilaiEkstra extends Model
{
    use HasFactory;

    protected $table = 'nilai_ekstras';

    protected $fillable = ['siswa_id', 'ekstrakurikuler_id', 'nilai', 'keterangan'];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }
}
