<script src="/plugins/jquery/jquery-2.1.0.min.js"></script>
<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/plugins/bootstrap/bootstrap.min.js"></script>

<?php echo Asset::js(['admin.js']); ?>

<?php if ($controller === 'Controller_Admin_Dashboard'): ?>
    <script src="/plugins/fineuploader/jquery.fineuploader-5.0.1.min.js"></script>
    <script>
        // Change status
        $(document).on('change', 'input[name="maintenance"]', function () {
            var maintenance = $(this).prop('checked') ? 1 : 0;
            $.post('/admin/dashboard/maintenance', {maintenance: maintenance});
        });
    </script>
<?php endif; ?>

<?php if ($controller === 'Controller_Admin_Profile'): ?>
    <script src="/plugins/fineuploader/jquery.fineuploader-5.0.1.min.js"></script>
    <script>
        // Load and run Uploader
        var option = {
            el: 'update-icon-uploader',
            template: 'update-icon-template',
            form: 'update-icon-form',
            inputName: 'user_photo',
            type: 'update-user-icon'
        };
        FormUpload(option);
    </script>
<?php endif; ?>

<?php if ($controller === 'Controller_Admin_Category'): ?>
    <script src="/plugins/fineuploader/jquery.fineuploader-5.0.1.min.js"></script>
    <script>
        // Load and run Uploader
        var option = {
            el: 'category-uploader',
            template: 'category-template',
            form: 'create-category-form',
            inputName: 'category_photo',
            type: 'create-category-photo'
        };
        FormUpload(option);

        var form = $('#create-category-form');
        // Sort category
        var ul_sortable = $('.sortable');
        ul_sortable.sortable({
            placeholder: 'ui-state-highlight',
            cursor: 'move'
        });
        ul_sortable.disableSelection();
        ul_sortable.on('sortupdate', function (event, ui) {
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
            form.find('div.main-icon > img').attr('src', '<?php echo _PATH_NO_IMAGE_; ?>');
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
            form.find('div.main-icon > img').attr('src', category_photo);
            form.find('input[name="id"]').val(category_id);
        });
    </script>
<?php endif; ?>

<?php if ($controller === 'Controller_Admin_Product' && $action === 'index' && !empty($total_page)): ?>
    <script src="/plugins/jQuery-pagination/jquery.pagination.js"></script>
    <script>
        $('#pagination').jqueryPagination({
            totalPages: <?php echo $total_page; ?>,
            visiblePages: <?php echo _DEFAULT_VISIBLE_PAGES_; ?>,
            prev: '←',
            next: '→',
            onPageClick: function (event, page) {
                var posting = $.post('/admin/product/list', {page: page});
                posting.done(function (data) {
                    if (data.product) {
                        var html = '';
                        $.each(data.product, function (index, value) {
                            var check = '';
                            if (parseInt(value.status) === 1) {
                                check = 'checked';
                            }
                            html += ' \
                                <tr data-id="' + value.id + '"> \
                                    <td> \
                                        <img class="img-rounded" src="' + value.product_photo_display + '"> \
                                        <span>' + value.product_name + '</span> \
                                    </td> \
                                    <td class="text-center"> \
                                        <div class="toggle-switch-status toggle-switch-primary-status"> \
                                            <label> \
                                                <input type="checkbox" name="status" ' + check + '> \
                                                <div class="toggle-switch-inner-status"></div> \
                                                <div class="toggle-switch-switch-status"><i class="fa fa-check"></i></div> \
                                            </label> \
                                        </div> \
                                    </td> \
                                    <td class="text-center"> \
                                        <a class="btn btn-danger" href="/admin/product/' + value.id + '">Edit</a> \
                                    </td> \
                                </tr> \
                            ';
                        });
                        $('#product-list').html(html);
                    }
                });
            }
        });

        // Change status
        $(document).on('change', 'input[name="status"]', function () {
            var status = $(this).prop('checked') ? 1 : 2;
            var product_id = $(this).parents('tr').attr('data-id');
            $.post('/admin/product/status', {product_id: product_id, status: status});
        });
    </script>
<?php endif; ?>

<?php if ($controller === 'Controller_Admin_Product' && in_array($action, array('new'))): ?>
    <script src="/plugins/tinymce/tinymce.min.js"></script>
    <script src="/plugins/tinymce/jquery.tinymce.min.js"></script>
    <script src="/plugins/fineuploader/jquery.fineuploader-5.0.1.min.js"></script>
    <script>
        // Load and run Uploader
        var option = {
            el: 'product-photo-uploader',
            template: 'product-photo-template',
            form: 'create-product-form',
            inputName: 'product_photo',
            type: 'create-product-photo'
        };
        FormUpload(option);

        // Create Wysiwig editor for textare
        TinyMCEStart('#product_description', 'basic');

        // Reset form
        var form = $('#create-product-form');
        $('button#reset').on('click', function () {
            resetForm(form);
            tinymce.activeEditor.setContent('');
            form.find('input[name="id"]').val('');
            form.find('div.main-icon > img').attr('src', '<?php echo _PATH_NO_IMAGE_; ?>');
            if ($('a#qq-cancel-link').length === 1) {
                $('a#qq-cancel-link')[0].click();
            }
        });
    </script>
<?php endif; ?>

<?php if ($controller === 'Controller_Admin_Product' && in_array($action, array('edit'))): ?>
    <link href="/plugins/bootstrap-toggle-switch/toggle-switch.css" rel="stylesheet">
    <script src="/plugins/tinymce/tinymce.min.js"></script>
    <script src="/plugins/tinymce/jquery.tinymce.min.js"></script>
    <script src="/plugins/fineuploader/jquery.fineuploader-5.0.1.min.js"></script>
    <script>
        // Load and run Uploader
        var option = {
            el: 'product-photo-uploader',
            template: 'product-photo-template',
            form: 'update-product-photo-form',
            inputName: 'product_photo',
            type: 'update-product-photo'
        };
        FormUpload(option);

        // Load and run Uploader
        var sub_option = {
            el: 'sub-product-photo-uploader',
            template: 'sub-product-photo-template',
            multiple: true,
            form: 'sub-product-photo-form',
            inputName: 'sub_product_photo',
            type: 'create-sub-product-photo'
        };
        FormUpload(sub_option);

        // Create Wysiwig editor for textare
        TinyMCEStart('#product_description', 'basic');

        // Change status
        $(document).on('change', 'input[name="status"]', function () {
            var status = $(this).prop('checked') ? 1 : 2;
            var product_id = $(this).parents('label').attr('data-id');
            $.post('/admin/product/status', {product_id: product_id, status: status});
        });

        // Delete sub photo
        $(document).on('click', 'button.delete-btn', function () {
            var product_id = $(this).parents('tbody').attr('data-id');
            var photo_id = $(this).parents('tr').attr('data-id');
            $.post('/admin/product/delete_sub_photo', {product_id: product_id, photo_id: photo_id});
            $(this).parents('tr').remove();
        });

        // Sort sub photo
        var ul_sortable = $('.sortable');
        ul_sortable.sortable({
            placeholder: 'ui-state-highlight',
            cursor: 'move'
        });
        ul_sortable.disableSelection();
        ul_sortable.on('sortupdate', function (event, ui) {
            var sortable_data = $('.sortable').sortable('serialize');
            console.log(sortable_data);
            $.post('/admin/product/sort_sub_photo', sortable_data);
        });
    </script>
<?php endif; ?>
