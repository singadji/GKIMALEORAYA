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
    <td style="display: none;">{{ $item->tanggal_terdaftar }}</td>
    
    <td class="align-left">
        {!! $nama !!}
        {!! $statusIkon !!}
    </td>

    <td class="align-left">{{ $item->gender }}</td>
    <td style="display: none;">{{ $item->tempat_tanggal_lahir }}</td>

    <td class="text-left">
        {{ optional($item->kkJemaat)->alamat 
            ?? optional(optional($item->hubunganKeluarga)->kkJemaat)->alamat 
            ?? '-' }}
    </td>

    <td class="align-left">{{ optional($item->kkJemaat)->id_group_wilayah 
            ?? optional(optional($item->hubunganKeluarga)->kkJemaat)->id_group_wilayah 
            ?? '-' }}</td>
    <td class="text-center">{{ $item->telepon }}</td>
    
    <td class="text-center">
        <span @class(["badge", "text-white", $item->badge_class])>
            {!! $statusBadge !!}
        </span>
    </td>
</tr>
