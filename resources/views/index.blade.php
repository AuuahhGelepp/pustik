<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No Telp</th>
            <th>Divisi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($anggota as $key => $value)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $value->nama_anggota }}</td>
                <td>{{ $value->alamat }}</td>
                <td>{{ $value->no_telp }}</td>
                <td>{{ $value->divisi->nama_divisi }}</td>
                <td>
                    <a href="{{ route('anggota.edit', $value->id_anggota) }}">Edit</a>
                    <form action="{{ route('anggota.destroy', $value->id_anggota) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>