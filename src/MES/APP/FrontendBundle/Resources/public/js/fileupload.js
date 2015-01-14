/*jslint browser: true, unparam:true*/
/*global alert, require, define*/

    function file (id) {

        var $fieldRoot = $('#fileupload-' + id);
        var $fieldContainer = $fieldRoot.parent();
        var $input = $fieldRoot.find('.upload-input');
        var $progressBar = $fieldRoot.find('.progress');
        var $progressBarSuccess = $fieldRoot.find('.progress-bar');
        var $button = $fieldRoot.find('.fileinput-button');
        var $files = $fieldRoot.find('.files');
        var $filePath = $fieldRoot.find('.file-path');
        var $previewImg = $fieldRoot.find('.preview-image');
        var $name = $fieldRoot.find('.file-name');
        var $previewName = $fieldRoot.find('.preview-name');
        function clearErrors() {
            $fieldRoot.find('.errors li').addClass('hidden');
            $fieldRoot.next('.help-block').remove();
            $fieldContainer.removeClass('has-error');
        }

        function addError(error) {
            $fieldRoot.find('.error-' + error.replace(/^error\./, '')).removeClass('hidden');
            $fieldContainer.addClass('has-error');
        }

        function addFile(file) {
            $filePath.val(file.path);
            $name.val(file.name);
            $previewName.text(file.name);
            $previewImg.removeClass('hidden').attr('src', file.url);
        }

        function removeFileCallback() {
            var $fileEntry = $(this).closest('.file-entry');
            removeFileId($fileEntry.data('id'));
            $fileEntry.remove();
        }

        $input.fileupload({
            dataType: 'json',
            formData: {
                token: $input.data('token'),
                endpoint: $input.data('endpoint')
            },
            start: function (e, data) {
                $button.hide();
                $progressBar.show();
                $progressBarSuccess.css('width', '0%');
                clearErrors();
            },
            done: function (e, data) {
                $button.show();
                $progressBar.hide();

                $.each(data.result.files, function (index, file) {
                    if (file.error) {
                        addError(file.error);
                    } else {
                        addFile(file);
                    }
                });
            },
            error: function (e, data) {
                $button.show();
                $progressBar.hide();
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $progressBarSuccess.css(
                        'width',
                        progress + '%'
                        );
            }
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }