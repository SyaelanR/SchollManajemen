public function up()
{
    Schema::create('jadwals', function (Blueprint $table) {
        $table->id();
        $table->string('kelas');         // contoh: "XII-IPA1"
        $table->string('mapel');         // "Matematika"
        $table->string('guru');          // "Pak Budi"
        $table->string('hari');          // "Senin"
        $table->string('jam');           // "07:00 - 08:30"
        $table->timestamps();
    });
}
