@props(["text" => "Submit" ,"is_block" => null])
<div class="form-group d-inline">
    <button type="submit" class="btn btn-sm btn-success
    @if($is_block)
        w-100
    @endif
    ">{{ $text }}</button>
</div>
