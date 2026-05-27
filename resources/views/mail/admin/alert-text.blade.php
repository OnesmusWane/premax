PREMAX AUTOMOTIVE STUDIO — {{ strtoupper($type) }}
========================================

{{ $alertSubject }}

@foreach($rows as $row)
{{ str_pad($row['label'], 18) }}  {{ $row['value'] }}
@endforeach
@if($note)

--- Message ---
{{ $note }}
@endif

---
Premax Automotive Studio · Nairobi, Kenya
This is an automated admin alert — please do not reply.
