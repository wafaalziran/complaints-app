@foreach($data as $a)
<form method="POST" action="/aspirasi/{{$a->id}}">
@csrf
<select name="status">
<option>Menunggu</option>
<option>Proses</option>
<option>Selesai</option>
</select>
<textarea name="feedback"></textarea>
<button>Update</button>
</form>
@endforeach