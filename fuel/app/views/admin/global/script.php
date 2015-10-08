<script src="/plugins/jquery/jquery-2.1.0.min.js"></script>
<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/plugins/bootstrap/bootstrap.min.js"></script>
<!--<script src="/plugins/justified-gallery/jquery.justifiedgallery.min.js"></script>-->

<?php
echo Asset::js(['admin.js']);
?>

<?php if ($controller === 'Controller_Admin_Profile'): ?>
    <script>
        // Load and run Uploader
        LoadFineUploader(IconUpload);
    </script>
<?php endif; ?>

<?php if ($controller === 'Controller_Admin_Category'): ?>
    <script>
        var form = $('#create-category-form');

        // Load and run Uploader
        LoadFineUploader(CategoryUpload);

        // Sort category
        var ul_sortable = $('.sortable');
        ul_sortable.sortable({
            placeholder: 'ui-state-highlight',
            cursor: 'move'
        });
        ul_sortable.disableSelection();
        ul_sortable.on("sortupdate", function (event, ui) {
            var sortable_data = $('.sortable').sortable('serialize');
            $.post('/admin/category/sort', sortable_data);
        });

        // Change status
        $(document).on('change', 'input[name="status"]', function () {
            var status = $(this).prop('checked') ? 1 : 2;
            var category_id = $(this).parents('tr').attr('data-id');
            $.post('/admin/category/status', {category_id: category_id, status: status});
        });

        // Reset form
        $('button#reset').on('click', function () {
            resetForm(form);
            form.find('input[name="id"]').val('');
            form.find('div#main-icon > img').attr('src', '<?php echo _PATH_NO_IMAGE_; ?>');
            if ($('a#qq-cancel-link').length === 1) {
                $('a#qq-cancel-link')[0].click();
            }
        });

        // Show edit information
        $(document).on('click', 'button.edit', function () {
            $('#add-category .box-content').fadeIn();
            $('#add-category .collapse-link > i').attr('class', 'fa fa-chevron-up');
            var $this = $(this),
                    category_id = $this.parents('tr').attr('data-id'),
                    parent_category_id = $this.parents('tr').attr('data-parent-id'),
                    category_name = $this.parents('tr').attr('data-category-name'),
                    category_photo = $this.parents('tr').find('img').attr('src');
            if (parseInt(parent_category_id) === 0) {
                parent_category_id = '';
            }
            resetForm(form, parent_category_id);
            form.find('input[name="category_name"]').val(category_name);
            form.find('div#main-icon > img').attr('src', category_photo);
            form.find('input[name="id"]').val(category_id);
        });
    </script>
<?php endif; ?>

<?php if ($controller === 'Controller_Admin_Product' && $action === 'new'): ?>
    <script src="/plugins/tinymce/tinymce.min.js"></script>
    <script src="/plugins/tinymce/jquery.tinymce.min.js"></script>
    <script>
        var form = $('#create-product-form');

        // Load and run Uploader
        LoadFineUploader(ProductUpload);

        // Create Wysiwig editor for textare
        TinyMCEStart('#product_description', 'basic');

        // Reset form
        $('button#reset').on('click', function () {
            resetForm(form);
            tinymce.activeEditor.setContent('');
            form.find('input[name="id"]').val('');
            form.find('div#main-icon > img').attr('src', '<?php echo _PATH_NO_IMAGE_; ?>');
            if ($('a#qq-cancel-link').length === 1) {
                $('a#qq-cancel-link')[0].click();
            }
        });

    </script>
<?php endif; ?>
