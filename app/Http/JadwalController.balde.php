
namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // Tampilkan semua jadwal per kelas
    public function index($kelas)
    {
        $jadwals = Jadwal::where('kelas', $kelas)->get();
        return view('jadwal', compact('jadwals', 'kelas'));
    }

    // Simpan jadwal baru
    public function store(Request $request)
    {
        Jadwal::create($request->all());
        return back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    // Hapus jadwal
    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal berhasil dihapus');
    }

    // Update jadwal
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());
        return back()->with('success', 'Jadwal berhasil diperbarui');
    }
}
