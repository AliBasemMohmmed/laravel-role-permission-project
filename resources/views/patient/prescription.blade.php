@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h1 style="text-align: center;">وصفة طبية</h1>
                <div class="mb-3" style="text-align: right;">
                    <label for="pharmacy_name" class="form-label">اسم الصيدلية</label>
                    <input type="text" class="form-control" id="pharmacy_name" name="pharmacy_name"
                        value="{{ $Pharmacy->name }}" disabled style="text-align: right;">
                </div>
                <div class="mb-3" style="text-align: right;">
                    <label for="doctor_name" class="form-label">اسم الطبيب</label>
                    <input type="text" class="form-control" id="doctor_name" name="doctor_name"
                        value="{{ $prescriptions->doctor_name }}" disabled style="text-align: right;">
                </div>
                <div class="mb-3" style="text-align: right;">
                    <label for="prescription_number" class="form-label">رقم الوصفة الطبية</label>
                    <input type="text" class="form-control" id="prescription_number" name="prescription_number"
                        value="{{ $prescriptions->prescription_number }}" disabled style="text-align: right;">
                </div>
                <div class="mb-3" style="text-align: right;">
                    <label for="dispensation_date" class="form-label">تاريخ الصرف</label>
                    <input type="date" class="form-control" id="dispensation_date" name="dispensation_date"
                        value="{{ $prescriptions->dispensation_date }}" disabled style="text-align: right;">
                </div>
                <hr>
                <div>
                    <h4 style="text-align: right;">الأدوية الموصوفة</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align: right;">اسم الدواء</th>
                                <th scope="col" style="text-align: right;">الوقت</th>
                                <th scope="col" style="text-align: right;">قبل/بعد الأكل</th>
                                <th scope="col" style="text-align: right;">عدد مرات الأخذ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medications as $p)
                                <tr>
                                    <td style="text-align: right;">{{ $p->product->name }}</td>
                                    <td style="text-align: right;">{{ $p->time }}</td>
                                    <td style="text-align: right;">{{ $p->eating }}</td>
                                    <td style="text-align: right;">{{ $p->dosage_frequency }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="text-center">
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
