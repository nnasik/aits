{{-- ROW TEMPLATE --}}
<table class="d-none">
    <tbody>
        <tr id="rowTemplate" class="d-none">
            
            <td>
                <button type="button" class="btn btn-danger btn-sm removeRow">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
            <td>
                <select name="training_course_id[]" class="form-control trainingSelect" required>
                    <option value="">-- Select --</option>
                    @foreach($trainings as $t)
                    <option value="{{ $t->id }}" data-name="{{ $t->name }}" data-duration="{{ $t->duration }}"
                        data-price="{{ $t->price }}">
                        {{ $t->name }}
                    </option>
                    @endforeach
                </select>
                
            </td>
            <td><input type="text" name="training_name[]" class="form-control trainingName" class="form-control trainingName"></td>
            <td><input type="text" name="duration[]" class="form-control duration" required></td>
            <td>
                <select name="delivery_mode[]" class="form-control delivery" required>
                    <option value="In-Class">In-Class</option>
                    <option value="Onsite">Onsite</option>
                    <option value="Online">Online</option>
                </select>
            </td>
            <td><input type="number" name="qty[]" class="form-control qty" value="1" required></td>
            <td><input type="number" name="unit_price[]" class="form-control price" value="0" required></td>
            <td><input type="number" name="discount[]" class="form-control discount" value="0"></td>
            <td><input type="number" name="total[]" class="form-control total" readonly></td>
        </tr>
    </tbody>
</table>