@props(['item', 'loop'])

@php
    $isKK = $item->is_kk ?? false;
    $statusIcon = '';
    if ($item->status_aktif == 'Meninggal Dunia') {
        $statusIcon = '<sup><i class="fa fa-solid fa-cross" style="color:purple;"></i></sup>';
    } elseif ($item->status_aktif == 'Atestasi') {
        $statusIcon = '<sup><i class="fa fa-solid fa-share" style="color:red;"></i></sup>';
    }
@endphp

<tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#f0f4ff'" onmouseout="this.style.background='transparent'">
    <td class="text-center text-muted">{{ $loop->iteration }}</td>
    <td>
        <span class="font-weight-bold text-dark">{{ $item->nia }}</span>
    </td>
    <td>
        <div class="d-flex align-items-center">
            <div class="avatar avatar-sm rounded-circle bg-gradient-secondary text-white d-flex align-items-center justify-content-center me-2"
                 style="width: 32px; height: 32px; font-size: 0.75rem;">
                {{ strtoupper(substr($item->nama_jemaat ?? 'X', 0, 1)) }}
            </div>
            <span class="font-weight-600">
                {{ $item->nama_jemaat }} {!! $statusIcon !!}
            </span>
        </div>
    </td>
    <td class="text-center">
        @if($item->gender == 'L')
            <span class="badge badge-info" style="font-size: 0.75rem;">
                <i class="fas fa-mars me-1"></i>L
            </span>
        @elseif($item->gender == 'P')
            <span class="badge badge-danger" style="font-size: 0.75rem;">
                <i class="fas fa-venus me-1"></i>P
            </span>
        @else
            <span class="badge badge-secondary" style="font-size: 0.75rem;">{{ $item->gender }}</span>
        @endif
    </td>
    <td style="max-width: 300px; white-space: normal; word-wrap: break-word;">
        <span class="text-muted">
            @if ($isKK)
                {{ $item->kkJemaat->alamat ?? $item->alamat_domisili ?? '-' }}
            @elseif ($item->hubunganKeluarga && $item->hubunganKeluarga->kkJemaat)
                {{ $item->hubunganKeluarga->kkJemaat->alamat ?? '-' }}
            @else
                {{ $item->alamat_domisili ?? 'Tidak Diketahui' }}
            @endif
        </span>
    </td>
    <td class="text-center">
        <span class="badge badge-outline-primary px-2 py-1" style="border: 1.5px solid #5e72e4; color: #5e72e4; background: rgba(94,114,228,0.08); font-size: 0.75rem;">
            @if ($isKK)
                {{ $item->kkJemaat->id_group_wilayah ?? '-' }}
            @elseif ($item->hubunganKeluarga && $item->hubunganKeluarga->kkJemaat)
                {{ $item->hubunganKeluarga->kkJemaat->id_group_wilayah ?? '-' }}
            @else
                -
            @endif
        </span>
    </td>
    <td class="text-center">
        <span class="text-muted">
            @if ($item->telepon)
                <a href="tel:{{ $item->telepon }}" class="text-decoration-none text-dark">
                    <i class="fas fa-phone-alt text-success me-1" style="font-size: 0.7rem;"></i>{{ $item->telepon }}
                </a>
            @else
                -
            @endif
        </span>
    </td>
    <td class="text-center">
        @php
            $badgeClass = $item->status_aktif == 'Aktif' ? 'badge-success' :
                        ($item->status_aktif == 'Meninggal Dunia' ? 'badge-danger' :
                        ($item->status_aktif == 'Atestasi' ? 'badge-warning' : 'badge-danger'));
        @endphp
        <span class="badge {{ $badgeClass }}" style="font-size: 0.65rem; padding: 0.25em 0.5em;">
            {{ $item->status_aktif }}
        </span>
    </td>
    <td class="text-center" style="max-width: 80px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
        @if ($item->keterangan)
            <span class="text-dark" style="font-size: 0.85rem; display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $item->keterangan }}</span>
        @else
            <span class="text-muted">-</span>
        @endif
    </td>
</tr>