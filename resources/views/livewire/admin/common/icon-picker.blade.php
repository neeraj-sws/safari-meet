<div class="icon-picker-wrapper">
    <div class="input-group iconpicker-container">
        <input type="text" class="form-control iconPicker iconpicker-element iconpicker-input"
               id="iconInput" value="{{ $icon }}"
               data-pageId="{{ $pageid }}" data-icon="{{ $icon }}" data-field="{{ $field }}">
        <span id="iconPreview" class="iconPreview input-group-text">
            <i class="{{ $icon }}"></i>
        </span>
    </div>
</div>
