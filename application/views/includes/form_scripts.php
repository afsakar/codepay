<!-- Form JS -->
<script src="<?=base_url("assets")?>/js/plugins/pwstrength-bootstrap/pwstrength-bootstrap.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/select2/js/select2.full.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/masked-inputs/jquery.maskedinput.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/dropzonejs/dropzone.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/flatpickr/flatpickr.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?=base_url("assets")?>/js/pages/be_forms_plugins.min.js"></script>

<!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
<script>jQuery(function(){ Codebase.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); });</script>
<script>jQuery(function(){ Codebase.helpers(['summernote', 'ckeditor', 'simplemde']); });</script>
<script>
    $('.js-summernote').summernote({
        height: 100,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: 200,             // set maximum height of editor
        focus: true                  // set focus to editable area after initializing summernote
    });
</script>