@foreach($quotations as $quotation)
<div class="col-md-4">
     
    @if($quotation->status=='Draft')
        <div class="card card-outline card-warning">
    @elseif($quotation->status=='Finalized')
        <div class="card card-outline card-primary">
    @else
        <div class="card card-outline card-dark">
    @endif
        <div class="card-header">
        <h3 class="card-title"> 
            {{$quotation->company_name}} : <i class="text-muted">AITS-{{$quotation->reference}}</i></h3>
        <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <p>
                The body of the card
            </p>
            <div class="row">
                <div class="col">
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="row text-end">
                <div class="col">
                    
                    @if($quotation->status=='Draft')
                        <button class="btn btn-sm btn-success disabled">
                            <i class="bi bi-plus"></i> Revision
                        </button>
                        <a class="btn btn-sm btn-warning" href="{{route('quotation.show',$quotation->id)}}">
                            <i class="bi bi-pencil-square"></i> Edit</a>
                        <button class="btn btn-sm btn-primary disabled">
                            <i class="bi bi-download"></i> Download
                        </button>
                    @elseif($quotation->status=='Finalized')
                        <button class="btn btn-sm btn-success">
                            <i class="bi bi-plus"></i> Revision
                        </button>
                        <a class="btn btn-sm btn-warning disabled">
                            <i class="bi bi-pencil-square"></i> Edit</a>
                        <a class="btn btn-sm btn-primary" href="{{route('quotation.pdf.00',$quotation->id)}}">
                            <i class="bi bi-download"></i> Download</a>
                    @else
                        
                    @endif
                    
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        
    </div>
</div>

@endforeach