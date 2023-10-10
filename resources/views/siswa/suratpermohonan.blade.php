@extends('template_backend.home')
@section('heading', 'Surat Permohonan Siswa')
@section('page')
  <li class="breadcrumb-item active">Surat Permohonan Siswa</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Surat Permohonan Siswa</h3>
      </div>
      <form action="{{route('siswa.suratPermohonanSiswaStore')}}" method="post">
        @csrf
        <div class="card-body">
            <div class="form-group">
              <label for="status_kehadiran">Keterangan Permohonan</label>
              <select id="kehadirans_id" type="text" class="form-control @error('kehadirans_id') is-invalid @enderror select2bs4" name="kehadirans_id">
                <option value="">-- Pilih Keterangan Permohonan --</option>
                @foreach ($kehadiran as $data)
                  <option value="{{ $data->id }}">{{ $data->keterangan }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <textarea class="textarea @error('alasan') is-invalid @enderror" name="alasan" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Ajukan Permohonan Sekarang </button>
        </div>
      </form>
    </div>
</div>
@endsection
@section('script')
    <script>
        $("#StatusSiswa").addClass("active");
    </script>
@endsection
