@props(['item', 'loop'])

@php
    $isKK = $item->is_kk ?? false;
    $nama = $isKK ? "<strong>{$item->nama_jemaat}</strong>" : $item->nama_jemaat;
    $statusIkon = match($item->status_icon) {
        'cross' => '<sup><i class="fa fa-solid fa-cross" style="color:purple;"></i></sup>',
        'share' => '<sup><i class="fa fa-solid fa-share" style="color:red;"></i></sup>',
        default => '',
    };
    $statusBadge = $isKK 
        ? "<strong>{$item->status_aktif}</strong>" 
        : $item->status_aktif;
@endphp

<tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer;">
    <td>{!! $isKK ? "<strong>{$loop->iteration}.</strong>" : "{$loop->iteration}." !!}</td>
    <td class="text-center font-weight-bold" width="30px">{{ $item->nia }}</td>
    <td style="display: none;">
        {{ $item->tanggal_terdaftar }}</td>
    
    <td class="align-left">
        {!! $nama !!}
        {!! $statusIkon !!}
    </td>

    <td class="align-left">{{ $item->gender }}</td>
    <td style="display: none;">{{ $item->tempat_lahir }}</td>
    <td style="display: none;">{{ \Carbon\Carbon::parse($item->tanggal ?? $item->tanggal_lahir ?? '')->translatedFormat('d F Y') }}</td>
    <td style="display: none;">{{ $item->tanggal_baptis }}</td>
    <td style="display: none;">{{ $item->tanggal_sidi }}</td>
    <td style="display: none;">{{ $item->tanggal_nikah }}</td>

    <td class="text-left" style="max-width: 500px; white-space: normal; word-wrap: break-word;">
        {{ optional($item->kkJemaat)->alamat 
            ?? optional(optional($item->hubunganKeluarga)->kkJemaat)->alamat 
            ?? '-' }}
    </td>

    <td class="align-left">
        {{ optional($item->kkJemaat)->id_group_wilayah ?? optional(optional($item->hubunganKeluarga)->kkJemaat)->id_group_wilayah ?? '-' }}
    </td>
    <td style="display: none;">{{ $item->asal_gereja }}</td>
    <td class="text-center">{{ $item->telepon }}</td>
    <td class="text-center">
        <span @class(["badge", "text-white", $item->badge_class])>
            {!! $statusBadge !!}
        </span>
    </td>
    <td class="text-left" style="max-width: 500px; white-space: normal; word-wrap: break-word;">
    @if ($item->status_aktif === 'Meninggal Dunia')
       pada tanggal {{ optional($item->meninggalJemaat)->tanggal 
            ? \Carbon\Carbon::parse($item->meninggalJemaat->tanggal)->translatedFormat('d F Y') 
            : '-' }}
    @elseif (in_array($item->status_aktif, ['Pindah Gereja', 'Atestasi Keluar']))
        ke {{ optional($item->atestasiJemaatKeluar)->gereja ?? '-' }},
       tanggal {{ optional($item->atestasiJemaatKeluar)->tanggal 
            ? \Carbon\Carbon::parse($item->atestasiJemaatKeluar->tanggal)->translatedFormat('d F Y') 
            : '' }}
    @else
        {{ $item->keterangan ?? '-' }}
    @endif
</td>
</tr>
