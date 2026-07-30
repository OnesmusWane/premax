@props(['path', 'alt' => '', 'class' => '', 'priority' => false])
@php
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $base = substr($path, 0, -(strlen($ext) + 1));
@endphp
<img src="{{ asset($path) }}"
     srcset="{{ asset("{$base}-480.{$ext}") }} 480w, {{ asset("{$base}-1024.{$ext}") }} 1024w, {{ asset($path) }} 1920w"
     sizes="100vw"
     alt="{{ $alt }}"
     @if($class) class="{{ $class }}" @endif
     loading="{{ $priority ? 'eager' : 'lazy' }}"
     @if($priority) fetchpriority="high" @endif
     decoding="async">
