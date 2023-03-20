<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style>
    .dropzone .dz-preview .dz-success-mark,
    .dropzone .dz-preview .dz-error-mark {
        pointer-events: none !important;
        z-index: 500 !important;
        display: none !important;
    }

    .dropzone.dz-clickable * {
        cursor: default !important;
    }

    .dropzone .dz-preview .dz-image img {
        margin: auto;
        /* center the image inside the thumbnail */
    }

    .dropzone .dz-preview .dz-error-message {
        top: 140px;
        /* move the tooltip below the "Remove" link */
    }

    .dropzone .dz-preview .dz-error-message:after {
        left: 30px;
        /* move the tooltip's arrow to the left of the "Remove" link */
        top: -18px;
        border-bottom-width: 18px;
    }

    .dropzone .dz-preview .dz-remove {
        margin-top: 4px;
        font-size: 11px;
        text-transform: uppercase;
    }

    .dropzone {
        background: white;
        border-radius: 5px;
        border: 2px dashed rgb(0, 135, 247);
        border-image: none;
    }
</style>