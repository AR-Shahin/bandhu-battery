@props(["label","name", "id" => null,"items","key" => null, "is_multiple" => false,"multi_placeholder" => '', "value" => null,"multiIDForUpdate" => []])

<div class="form-group">
    @if ($label)
    <label for="{{ $id }}"><b>{{ $label }} : </b></label>
    @endif

    <select name="{{ $name }}" id="{{ $id }}" class="form-control select2   @error($name)
    is-invalid
@enderror"
    @if ($is_multiple)
    multiple="multiple" data-placeholder="{{ $multi_placeholder }}"
    @endif
    >
        <option value="">Select An Item</option>
        @foreach ($items as $item)
        <option value="{{ $item->id }}"
            @if(old($name) == $item->id || $value == $item->id || in_array($item->id,$multiIDForUpdate))
            selected
            @endif
            >{{ $item->name ?? $item->$key }}</option>
        @endforeach
    </select>

@error($name)
    <span class="text-danger">{{ $message }}</span>
@enderror
</div>
