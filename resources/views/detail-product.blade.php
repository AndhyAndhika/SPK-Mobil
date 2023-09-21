@extends('New-Template')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <img src="{{ asset('UIUX/IMG/' . $nama . '.webp') }}" class="card-img-top w-50 mx-auto" alt="{{ asset('UIUX/IMG/' . $nama . '.webp') }}">
            <div class="card-body">
              <h5 class="card-title fw-bold text-uppercase h3">{{ $nama }}</h5>
              <p class="card-text">
                <div class="table-responsive">
                    <table class="table table-striped-columns table-hover table-bordered nowrap display w-100" style="overflow-x: scroll">
                        <thead class="bg-secondary">
                            <tr>
                                <th class="text-center">TYPE</th>
                                <th class="text-center">HARGA</th>
                                <th class="text-center">MESIN (CC)</th>
                                <th class="text-center">SEATER</th>
                                <th class="text-center">DIMENSI (cm)</th>
                                <th class="text-center">VELG</th>
                                <th class="text-center">INTERIOR</th>
                                <th class="text-center">EXTERIOR</th>
                                <th class="text-center">FITUR SAFETY</th>
                                <th class="text-center">FITUR TAMBAHAN</th>
                                <th class="text-center">WARNA TERSEDIA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->type }}</td>
                                    <td>@Rupiah($item->price)</td>
                                    <td class="text-end">{{ $item->kapasitas_cc }}</td>
                                    <td class="text-center">{{ $item->kapasitas_orang }}</td>
                                    <td>{{ $item->dimensi }}</td>
                                    <td>{{ $item->velg }}</td>
                                    <td><?php $itemsArray = explode(', ', $item->interior) ?>
                                        <ul>
                                            @foreach ($itemsArray as $inter)
                                                <li>{{ $inter }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td><?php $itemsArray = explode(', ', $item->eksterior) ?>
                                        <ul>
                                            @foreach ($itemsArray as $eks)
                                                <li>{{ $eks }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td><?php $itemsArray = explode(', ', $item->safety) ?>
                                        <ul>
                                            @foreach ($itemsArray as $safe)
                                                <li>{{ $safe }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td><?php $itemsArray = explode(', ', $item->fitur_tambahan) ?>
                                        <ul>
                                            @foreach ($itemsArray as $fitur_)
                                                <li>{{ $fitur_ }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td><?php $itemsArray = explode(', ', $item->warna_tersedia) ?>
                                        <ul>
                                            @foreach ($itemsArray as $warna_)
                                                <li>{{ $warna_ }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </p>
              {{-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
              <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p> --}}
            </div>
        </div>
    </div>
</div>
@endsection
