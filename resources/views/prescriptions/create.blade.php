@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 style="text-align: right;">إنشاء وصفة طبية</h1>

        <form action="{{ route('prescription.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="doctor_name" class="form-label">اسم الدكتور</label>

                <input type="text" class="form-control" id="doctor_name" name="doctor_name" value="{{ $doctor->name }}" disabled>
            </div>
            <div class="mb-3">
                <label for="patient_name" class="form-label">اسم المريض</label>
                <input type="text" class="form-control" id="patient_name" name="patient_name" required>
            </div>

            <div class="mb-3">
                <label for="national_id_image" class="form-label">صوره البطاقه الوطنية</label>
                <input type="file" class="form-control" id="national_id_image" name="national_id_image" required>
            </div>

            <div class="mb-3">
                <label for="patient_age" class="form-label">عمر المريض</label>
                <input type="number" class="form-control" id="patient_age" name="patient_age" required>
            </div>

            <div id="medicationsContainer">
                <div class="medication-group">
                    <div class="mb-3">
                        <label for="medication" class="form-label">العلاجات</label>
                        <select class="form-control" name="medication[]" required>
                            <option value="">Select Medication</option>
                            @foreach ($prescriptions as $prescription)
                                <option value="{{ $prescription->id }}">{{ $prescription->name }} ---
                                    {{ $prescription->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">الوقت</label>
                        <input type="time" class="form-control" name="time[]" required>
                    </div>
                    <div class="mb-3">
                        <label for="eating" class="form-label">الوقت (بعد/قبل الأكل)</label>
                        <select class="form-control" name="eating[]" required>
                            <option value="before_meal">قبل الأكل</option>
                            <option value="after_meal">بعد الأكل</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="dosage_frequency" class="form-label">عدد مرات الأخذ</label>
                        <input type="number" class="form-control" name="dosage_frequency[]" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="addMedicationButton">إضافة علاج</button>

            <div class="mb-3">
                <label for="prescription_number" class="form-label">رقم الوصفة الطبية</label>
                <input type="text" class="form-control" id="prescription_number" name="prescription_number" required>
            </div>

            <div class="mb-3">
                <label for="dispensation_date" class="form-label">تاريخ الصرف</label>
                <input type="date" class="form-control" id="dispensation_date" name="dispensation_date" required>
            </div>

            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>

    <script>
        document.getElementById('addMedicationButton').addEventListener('click', function() {
            const medicationsContainer = document.getElementById('medicationsContainer');
            const medicationGroup = document.querySelector('.medication-group').cloneNode(true);

            // Reset select and input fields
            medicationGroup.querySelector('select').selectedIndex = 0;
            medicationGroup.querySelector('input[type="time"]').value = '';
            medicationGroup.querySelector('input[type="number"]').value = '';

            medicationsContainer.appendChild(medicationGroup);
        });
    </script>
@endsection
