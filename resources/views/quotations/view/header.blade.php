<!-- header.blade.php -->
<div class="row mb-3 px-3">
        <div class="col-6">
            <table style="width:auto;">
                <tr>
                    <td>Quote To :</td>
                    <td><strong>{{$quotation->company_name}}</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td><strong>{{$quotation->company_address}}</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td><strong>{{$quotation->company_phone}}</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td><strong>{{$quotation->company_email}}</strong></td>
                </tr>
                <tr>
                    <td>Quote For :</td>
                    <td><strong>{{$quotation->quote_for}}</strong></td>
                </tr>
            </table>
        </div>
        <div class="col-6 text-end">
            <table style="width:auto; margin-left:auto;">
                <tr>
                    <td>Reference :</td>
                    <td><strong>AITS-{{$quotation->reference}}</strong></td>
                </tr>
                <tr>
                    <td>Rev :</td>
                    <td><strong>{{ str_pad($quotation->revision, 2,'0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td>Date :</td>
                    <td><strong>{{$quotation->date}}</strong></td>
                </tr>
                <tr>
                    <td>Valid Until :</td>
                    <td><strong>{{$quotation->valid_until}}</strong></td>
                </tr>
            </table>
        </div>
    </div>