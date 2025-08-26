import Dropzone from "dropzone";

Dropzone.autoDiscover = false;
// Por defecto Dropzone busca elementos que tengan la clase de Dropzone, pero nosotros queremos
// darle el comportamiento y decirle a qué endpoint queremos enviar las peticiones, o las
// imágenes en este caso. Por eso le ponemos: false. 
const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true, // permite al usuario eliminar su imagen
    dictRemoveFile: 'Borrar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        if(document.querySelector('[name="imagen"]').value.trim()) {
        // Si hay un valor en ese elemento hidden llamado 'imagen', se ejecutará lo siguiente:
            const imagenPublicada = {};     // A pesar de usar 'const' al definirlo, como es un objeto, sí te permite asignar valores. Cuando es una variable, no.
            imagenPublicada.size = 1234;    // El objeto de imagen debe tener un size, por eso ponemos cualquier cosa(1234). Se podría hacer otro input hidden para poner el tamaño real de la imagen, pero no es obligatorio
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;
            
            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    }
});

// Esta librería es para poder subir imágenes en los posts
// Este tipo de eventos como 'sending', 'success', 'error', 'removedfile' son muy útiles para
// debuggear y saber qué se está procesando cuando se trabaja con Dropzone

/* dropzone.on('sending', function(file, xhr, formData) {
    console.log(file);
}); */

dropzone.on('success', function(file, response) {
    document.querySelector('[name="imagen"]').value = response.imagen;
});

/* dropzone.on('error', function(file, message) {
    console.log(message);
}); */

dropzone.on('removedfile', function() {
    document.querySelector('[name="imagen"]').value = '';
});

