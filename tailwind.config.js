/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    // Aquí es donde compila los archivos de php y js que contienen clases de Tailwind
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php", 
    // PAGINACIÓN - incluimos estos archivos para que le aplique las clases también. Lección 116
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

