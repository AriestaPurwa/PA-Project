<form action="{{ route('projects.store') }}" method="POST">
    @csrf

    <input type="text" name="nama_project" placeholder="Nama Project">

    <textarea name="deskripsi"></textarea>

    <button type="submit">Simpan</button>
</form>