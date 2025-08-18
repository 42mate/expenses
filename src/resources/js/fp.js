import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateSize,
    FilePondPluginImageEdit
);

const inputElement = $('input[type="file"].filepond');
const csrfToken = $('meta[name="csrf-token"]').attr('content');

inputElement.each(function (i, e) {
    const pond = FilePond.create(e, {
        server: {
            process: '/fp/up',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        },
    });

    e.addEventListener

    //Recovers the state if the file was previously updated
    const state = $(e).attr('data-state');
    console.log(state);
    if (state !== '' && state !== 'null') {
        const states = JSON.parse(state);
        states.forEach((state, index) => {
            pond.addFile('/fp/load?file=' + state);
        });
    }
})

$(document).ready(function() {
    //Locks submit while uploading
    const submit = $('[type=submit]');
    const ponds = $('.filepond--root');

    ponds.on('FilePond:addfilestart', (e) => {
        submit.prop("disabled", true);
    });

    ponds.on('FilePond:processfile', (e) => {
        submit.prop("disabled", false);
    });

    ponds.on('FilePond:processfiles', (e) => {
        submit.prop("disabled", false);
    });

    const deletes = $('.filepond--custom-delete');
    deletes.click(function (e) {
        const d = $(e.target);
        const delete_url = d.attr('data-delete-url');
        const preview_container = $(d.parent('.filepond--custom--preview-container'));

        $.ajax({
            url: delete_url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            success: function(response) {
                preview_container.fadeOut();
            },
            error: function(xhr, status, error) {
                console.error("Error deleting resource:", error);
            }
        });
    })
});
