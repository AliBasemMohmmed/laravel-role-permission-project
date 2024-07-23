@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mb-4">وصفة طبية</h1>
                <h4 class="text-right mb-4" style="text-align: right;">
                    <a href="{{ $Pharmacy->Url_location }}" target="_blank" class="text-decoration-none">
                        <i class="bi bi-geo-alt-fill"></i style="text-align: right;">
                        {{ $Pharmacy->location }} موقع الصيدلية
                    </a>
                </h4>
                <div class="mb-3 text-right" style="text-align: right;">
                    <label for="pharmacy_name" class="form-label">اسم الصيدلية</label>
                    <input type="text" class="form-control text-right" id="pharmacy_name" name="pharmacy_name"
                        value="{{ $Pharmacy->name }}" disabled style="text-align: right;">
                </div>
                <div class="mb-3 text-right" style="text-align: right;">
                    <label for="doctor_name" class="form-label">اسم الطبيب</label>
                    <input type="text" class="form-control text-right" id="doctor_name" name="doctor_name"
                        value="{{ $prescriptions->doctor_name }}" disabled style="text-align: right;">
                </div>
                <div class="mb-3 text-right" style="text-align: right;">
                    <label for="prescription_number" class="form-label">رقم الوصفة الطبية</label>
                    <input type="text" class="form-control text-right" id="prescription_number"
                        name="prescription_number" value="{{ $prescriptions->prescription_number }}" disabled
                        style="text-align: right;">
                </div>
                <div class="mb-3 text-right" style="text-align: right;">
                    <label for="dispensation_date" class="form-label">تاريخ الصرف</label>
                    <input type="date" class="form-control text-right" id="dispensation_date" name="dispensation_date"
                        value="{{ $prescriptions->dispensation_date }}" disabled style="text-align:right;">
                </div>
                <hr>
                <div>
                    <h4 class="text-right mb-3" style="text-align: right;">الأدوية الموصوفة</h4>
                    <table class="table table-striped table-bordered text-right">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-right">اسم الدواء</th>
                                <th scope="col" class="text-right">الوقت</th>
                                <th scope="col" class="text-right">قبل/بعد الأكل</th>
                                <th scope="col" class="text-right">عدد مرات الأخذ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medications as $p)
                                <tr>
                                    <td class="text-right">{{ $p->product->name }}</td>
                                    <td class="text-right">{{ $p->time }}</td>
                                    <td class="text-right">{{ $p->eating }}</td>
                                    <td class="text-right">{{ $p->dosage_frequency }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="text-center mt-4">
                    <button class="btn btn-primary" onclick="printPrescription()">طباعة الوصفة الطبية</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function printPrescription() {
            window.print();
        }
    </script>


@endsection
