
public function up(): void
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
        $table->date('tanggal');
        $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpha']);
        $table->timestamps();
    });
}
