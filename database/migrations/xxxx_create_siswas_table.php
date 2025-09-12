public function up(): void
{
    Schema::create('siswas', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nis')->unique();
        $table->timestamps();
    });
}
