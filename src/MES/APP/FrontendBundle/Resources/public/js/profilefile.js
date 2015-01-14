/*jslint browser: true, unparam:true*/
/*global alert, require, define*/

define(['jquery', 'jqueryfileupload/jquery.fileupload'], function ($, jqueryFileupload) {
    'use strict';
    
    return function (id) {
        $(function () {
            'use strict';
            
            var $fieldRoot = $('#fileupload-'+id);
            var $fieldContainer = $fieldRoot.parent();
            var $input = $fieldRoot.find('.upload-input');
            var $progressBar = $fieldRoot.find('.progress');
            var $progressBarSuccess = $fieldRoot.find('.progress-bar');
            var $button = $fieldRoot.find('.fileinput-button');
            var $files = $fieldRoot.find('.files');
            var $select = $('#'+id);
            var $filesChoice = $fieldRoot.find('.files-choice');
            var $filesChoiceSelect = $filesChoice.find('select');
            
            function clearErrors() {
                $fieldRoot.find('.errors li').addClass('hidden');
                $fieldRoot.next('.help-block').remove();
                $fieldContainer.removeClass('has-error');
            }
            
            function addError(error) {
                $fieldRoot.find('.error-'+error.replace(/^error\./, '')).removeClass('hidden');
                $fieldContainer.addClass('has-error');
                $button.show();
                $filesChoice.show();
            }
            
            function addFileId(id) {
                $select.append($('<option value="' + id + '" selected>'));
            }
            
            function removeAllFiles() {
                $files.find('.file-entry').remove();
                $select.find('option').remove();
                $button.show();
                $filesChoice.show();
            }
            
            function removeFileId(id) {
                id = parseInt(id, 10);
                $select.children('option').each(function () {
                    if (parseInt($(this).attr('value'), 10) === id) {
                        $(this).remove();
                    }
                });
            }
            
            function removeFileCallback() {
                var $fileEntry = $(this).closest('.file-entry');
                removeFileId($fileEntry.data('id'));
                $fileEntry.remove();
                $button.show();
                $filesChoice.show();
            }
            
            function addFileEntry(id, name) {
                var $removeButton = $('<a><span class="glyphicon glyphicon-remove"></span></a>');
                $removeButton.click(removeFileCallback);

                $('<p class="file-entry"/>')
                    .data('id', id)
                    .text(name)
                    .appendTo($files)
                    .append($removeButton)
                    ;
            }
            
            $filesChoiceSelect.change(function () {
                var selectedId = $filesChoiceSelect.val();
                
                if (selectedId) {
                    removeAllFiles();
                    
                    $button.hide();
                    $filesChoice.hide();
                    
                    addFileId(selectedId);
                    addFileEntry(selectedId, $filesChoiceSelect.find('option:selected').text());
                    
                    $filesChoiceSelect.val('');
                }
            });
            
            $select.children('option').each(function () {
                var $option = $(this);
                addFileEntry($option.attr('value'), $option.text());
            });
            
            $input.fileupload({
                dataType: 'json',
                formData: {
                    token: $input.data('token'),
                    endpoint: $input.data('endpoint')
                },
                start: function (e, data) {
                    $button.hide();
                    $filesChoice.hide();
                    
                    $progressBar.show();
                    $progressBarSuccess.css('width', '0%');
                    clearErrors();
                },
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        if (file.error) {
                            addError(file.error);
                        } else {
                            addFileEntry(file.id, file.name);
                            addFileId(file.id);
                        }
                    });
                    
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
        });
    };
});