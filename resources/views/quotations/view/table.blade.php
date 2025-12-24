<!-- table.blade.php -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width:5%;"></th>
            <th style="width:20%;">Training</th>
            <th style="width:25%;">Certificate Name</th>
            <th style="width:10%;">Duration</th>
            <th style="width:10%;">Delivery</th>
            <th style="width:6%;">Qty</th>
            <th style="width:8%;">Unit Price</th>
            <th style="width:8%;">Discount</th>
            <th style="width:10%;">Total</th>
        </tr>

    </thead>

    <tbody id="rowsBody">
        @foreach($quotation->rows as $row)
        <tr>
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
                        data-price="{{ $t->price }}" {{ $row->training_course_id == $t->id ? 'selected' : '' }}>
                        {{ $t->name }}
                    </option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" name="training_name[]" class="trainingName form-control duration"
                    value="{{ $row->training_name }}"></td>
            <td><input type="text" name="duration[]" class="form-control duration" value="{{ $row->duration }}"
                    required></td>
            <td>
                <select name="delivery_mode[]" class="form-control delivery" required>
                    <option {{ $row->delivery_mode=='In-Class'?'selected':'' }}>In-Class</option>
                    <option {{ $row->delivery_mode=='Onsite'?'selected':'' }}>Onsite</option>
                    <option {{ $row->delivery_mode=='Online'?'selected':'' }}>Online</option>
                </select>
            </td>
            <td><input type="number" name="qty[]" class="form-control qty text-end" value="{{ $row->qty }}" required>
            </td>
            <td><input type="number" name="unit_price[]" class="form-control price text-end"
                    value="{{ $row->unit_price }}" required></td>
            <td><input type="number" name="discount[]" class="form-control discount text-end"
                    value="{{ $row->discount }}"></td>
            <td><input type="number" name="total[]" class="form-control total text-end" value="{{ $row->total }}"
                    readonly></td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th colspan="9" class="text-end">
                Sub Total : <span id="sub_total">{{ number_format($quotation->sub_total, 2) }}</span><br>
                Discount : <span id="overall_discount_display">{{ number_format($quotation->discount, 2) }}</span>
                <input type="hidden" name="overall_discount" id="overall_discount" value="{{ $quotation->discount }}">
                <br>
                VAT (5%) : <span id="vat">{{ number_format($quotation->vat, 2) }}</span><br>
                <strong>Grand Total : <span id="grand_total">{{ number_format($quotation->grand_total, 2)
                        }}</span></strong>
            </th>
        </tr>
    </tfoot>

</table>